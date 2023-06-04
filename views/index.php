<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AI Bro - AI Chat Assistant for Career Guidance & College Counseling</title>
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    <style>
        .chat-container{
            border: 1px solid #ccc;
            padding: 10px;
        }
        #typing{
            white-space: pre-wrap !important;
        }

        .message {
            margin-bottom: 10px;
        }

        textarea {
            min-width: 100%;
        }

        .history-container {
            white-space: pre-wrap !important;
            margin-bottom: 20px;
        }

        .chat-input-container {
            position: relative;
        }

        .send-button {
            position: absolute;
            right: 10px;
            bottom: 15px;
        }
        textarea{
            min-height: 65px !important;
            max-height: 150px;
        }
    </style>
</head>
<body>
<div class="container">
    <div class="history-container">
        <div id="history-list"></div>
        <button id="reset-button" class="btn btn-danger">Clear Conversations</button>
    </div>
    <div class="chat-container">
        <div class="message"><b>AI Bro:</b> <span id="typing"></span></div>
        <div class="info"></div>
    </div>

    <div class="chat-input-container">
        <textarea type="text" id="user-input" class="form-control"></textarea>
        <button id="send-button" class="btn btn-primary send-button"><i class="bi bi-send-fill"></i></button>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
<script>
    function typeHTML(html, speed) {
        const typingElement = document.getElementById('typing');
        typingElement.innerHTML = ''; // Clear previous content
        let index = 0;
        const typingInterval = setInterval(() => {
            typingElement.innerHTML += html[index];
            index++;
            if (index >= html.length) {
                clearInterval(typingInterval);
                enableButton();
            }
        }, speed);
    }

    function saveToLocalStorage(message, id, total_tokens, finish_reason, time, aiResponse) {
        const conversation = {
            message: message,
            id: id,
            total_tokens: total_tokens,
            finish_reason: finish_reason,
            time: time,
            aiResponse: aiResponse
        };
        let conversations = localStorage.getItem('conversations');
        if (conversations) {
            conversations = JSON.parse(conversations);
        } else {
            conversations = [];
        }
        conversations.push(conversation);
        localStorage.setItem('conversations', JSON.stringify(conversations));
    }

    function renderChatHistory() {
        const historyList = document.getElementById('history-list');
        historyList.innerHTML = '';

        const conversations = JSON.parse(localStorage.getItem('conversations'));
        if (!conversations) return;

        conversations.forEach(function (conversation) {
            const card = document.createElement('div');
            card.className = 'card mb-2';
            const cardBody = document.createElement('div');
            cardBody.className = 'card-body';
            const userPrompt = document.createElement('div');
            userPrompt.className = 'card-text';
            userPrompt.innerHTML = '<b>User:</b> ' + conversation.message;
            const aiResponse = document.createElement('div');
            aiResponse.className = 'card-text';
            aiResponse.innerHTML = '<b>AI Bro:</b> ' + conversation.aiResponse;

            cardBody.appendChild(userPrompt);
            cardBody.appendChild(aiResponse);
            card.appendChild(cardBody);
            historyList.appendChild(card);
        });
    }

    function resetConversations() {
        localStorage.removeItem('conversations');
        document.querySelector('#typing').innerHTML = ""
        renderChatHistory();
        sendGreetingMessage()
        document.querySelector('#user-input').focus()
    }

    async function sendRequest() {
        disableButton();
        let userInput = document.getElementById('user-input').value;
        if (userInput.trim() == '') return enableButton();

        const url = '<?php echo route('api/aibro')?>';
        const data = new FormData();
        data.append('message', userInput);

        try {
            const response = await axios.post(url, data);
            if (response.status === 200) {
                const responseData = response.data;
                if (responseData.status === '200') {
                    let aiResponse = responseData.data.response;
                    aiResponse = aiResponse.replace(/<br\s*[\/]?>/gi, "\n");
                    const typingSpeed = 10; // Adjust typing speed (milliseconds per character)
                    const id = responseData.data[0].id;
                    const total_tokens = responseData.data[0].usage.total_tokens;
                    const finish_reason = responseData.data[0].choices[0].finish_reason;
                    const time = responseData.data[0].created;

                    typeHTML(aiResponse, typingSpeed);

                    renderChatHistory();
                    saveToLocalStorage(userInput, id, total_tokens, finish_reason, time, aiResponse);

                    userInput = document.querySelector('#user-input');
                    userInput.value = '';
                    userInput.focus();
                }
            } else {
                console.log('Error: ' + response.status);
            }
        } catch (error) {
            console.log('Error: ' + error);
        }
    }

    document.addEventListener('DOMContentLoaded', function () {
        const sendButton = document.getElementById('send-button');
        sendButton.addEventListener('click', function () {
            sendRequest();
        });

        const resetButton = document.getElementById('reset-button');
        resetButton.addEventListener('click', function () {
            resetConversations();
        });

        renderChatHistory();
        document.getElementById('user-input').focus();
    });

    function disableButton() {
        const sendButton = document.getElementById('send-button');
        const resetButton = document.getElementById('reset-button');
        sendButton.disabled = true;
        resetButton.disabled = true;
        sendButton.innerHTML = '<span class="spinner-grow spinner-grow-sm" role="status" aria-hidden="true"></span>';
    }

    function enableButton() {
        const sendButton = document.getElementById('send-button');
        const resetButton = document.getElementById('reset-button');
        sendButton.disabled = false;
        resetButton.disabled = false;
        sendButton.innerHTML = '<i class="bi bi-send-fill"></i>';
        document.getElementById('user-input').focus();
        document.getElementById('user-input').scrollIntoView({behavior: 'smooth'});
    }

    function sendGreetingMessage() {
        const greeting = "Hello! I am AI Bro, an AI chat assistant for career guidance and college counseling. \n\nHow may I help you today?";
        typeHTML(greeting, 10);

        const time = new Date().toISOString();
    }

    document.addEventListener('DOMContentLoaded', function () {
        // ...
        renderChatHistory();
        sendGreetingMessage();
        document.getElementById('user-input').focus();
    });

</script>
</body>
</html>
