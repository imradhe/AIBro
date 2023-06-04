    function typeHTML(html, speed) {
        let typingElement = document.getElementById('typing');
        typingElement.innerHTML = ''; // Clear previous content
        let index = 0;
        let typingInterval = setInterval(() => {
            typingElement.innerHTML += html[index];
            index++;
            if (index >= html.length) {
                clearInterval(typingInterval);
                enableButton();
            }
        }, speed);
    }

    function saveToLocalStorage(message, id, total_tokens, finish_reason, time, aiResponse) {
        let conversation = {
            message: message,
            id: id,
            total_tokens: total_tokens,
            finish_reason: finish_reason,
            time: time,
            aiResponse: aiResponse,
            removed: false // Set removed attribute to false initially
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
        let historyList = document.getElementById('history-list');
        historyList.innerHTML = '';

        let conversations = JSON.parse(localStorage.getItem('conversations'));
        if (!conversations) return;

        conversations.forEach(function (conversation) {
            if (!conversation.removed) { // Display conversations with removed attribute set to false
                let card = document.createElement('div');
                card.className = 'card mb-2';
                let cardBody = document.createElement('div');
                cardBody.className = 'card-body';
                let userPrompt = document.createElement('div');
                userPrompt.className = 'card-text';
                userPrompt.innerHTML = '<b>User:</b> ' + conversation.message;
                let aiResponse = document.createElement('div');
                aiResponse.className = 'card-text';
                aiResponse.innerHTML = '<b>AI Bro:</b> ' + conversation.aiResponse;

                cardBody.appendChild(userPrompt);
                cardBody.appendChild(aiResponse);
                card.appendChild(cardBody);
                historyList.appendChild(card);
            }
        });
    }

    function resetConversations() {
        let conversations = JSON.parse(localStorage.getItem('conversations'));
        if (conversations) {
            conversations.forEach(function (conversation) {
                conversation.removed = true; // Set removed attribute to true for all conversations
            });
            localStorage.setItem('conversations', JSON.stringify(conversations));
        }
        document.querySelector('#typing').innerHTML = "";
        renderChatHistory();
        
        sendGreetingMessage();
        document.querySelector('#user-input').focus();
    }

    


    function disableButton() {
        let sendButton = document.getElementById('send-button');
        let resetButton = document.getElementById('reset-button');
        sendButton.disabled = true;
        resetButton.disabled = true;
        sendButton.innerHTML = '<span class="spinner-grow spinner-grow-sm" role="status" aria-hidden="true"></span>';
    }

    function enableButton() {
        let sendButton = document.getElementById('send-button');
        let resetButton = document.getElementById('reset-button');
        sendButton.disabled = false;
        resetButton.disabled = false;
        sendButton.innerHTML = '<i class="bi bi-send-fill"></i>';
        document.getElementById('user-input').focus();
        document.getElementById('user-input').scrollIntoView({behavior: 'smooth'});
    }

    function sendGreetingMessage() {
        let greeting = "Hello! I am AI Bro, an AI chat assistant for career guidance and college counseling. \n\nHow may I help you today?";
        typeHTML(greeting, 10);

        let time = new Date().toISOString();
    }

    function count() {
        let conversations = JSON.parse(localStorage.getItem('conversations'));
        let currentTime = new Date().getTime();
        let twentyFourHoursAgo = currentTime - (24 * 60 * 60 * 1000); // 24 hours ago in milliseconds
        let count = 0;

        if (conversations) {
            conversations.forEach(function (conversation) {
                let conversationTime = conversation.time;
                if (twentyFourHoursAgo >= conversationTime) {
                    count++;
                }
            });
        }

        return count;
    }

    function tokenCount(){
        let conversations = JSON.parse(localStorage.getItem('conversations'));
        let currentTime = new Date().getTime();
        let twentyFourHoursAgo = currentTime - (24 * 60 * 60 * 1000); // 24 hours ago in milliseconds
        let count = 0;

        if (conversations) {
            conversations.forEach(function (conversation) {
                let tokens = conversation.total_tokens;
                if (twentyFourHoursAgo >= tokens) {
                    count+= tokens;
                }
            });
        }

        return count;        
    }


    function limitReached(){
        errorMsg = "Daily Limit of 5 conversations or 2000 tokens exceeded. Try again after 24 hrs"
        typeHTML(errorMsg, 10)
        return enableButton() 
    }


    document.addEventListener('DOMContentLoaded', function () {

        let sendButton = document.getElementById('send-button');
        sendButton.addEventListener('click', function () {
            sendRequest();
        });

        let resetButton = document.getElementById('reset-button');
        resetButton.addEventListener('click', function () {
            resetConversations();
        });

        renderChatHistory();
        document.getElementById('user-input').focus();

            sendGreetingMessage();
            document.getElementById('user-input').focus();
            

    });