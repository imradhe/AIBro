<!DOCTYPE html>
<html>
<head>
  <title>AI Bro - AI Chat Assistant for Career Guidance & College Counseling</title>
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
  <style>
    .chat-container {
      border: 1px solid #ccc;
      padding: 10px;
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
  </style>
</head>
<body>
  <div class="container">
    <div class="history-container">
      <div id="history-list"></div>
      <button id="reset-button" class="btn btn-danger">Clear Conversations</button>
    </div>
    <div class="chat-container">
      <div class="message">AI Bro: <span id="typing"></span></div>
      <div class="info"></div>
    </div>
  
    <textarea type="text" id="user-input" class="form-control"></textarea>
  
    <button id="send-button" class="btn btn-primary">Send Message</button>
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

      conversations.forEach(function(conversation) {
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
      renderChatHistory();
    }

    async function sendRequest() {
      disableButton();
      let userInput = document.getElementById('user-input').value;
      if (userInput.trim() === '') return;

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

            saveToLocalStorage(userInput, id, total_tokens, finish_reason, time, aiResponse);
            renderChatHistory();

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

    document.addEventListener('DOMContentLoaded', function() {
      const sendButton = document.getElementById('send-button');
      sendButton.addEventListener('click', function() {
        sendRequest();
      });

      const resetButton = document.getElementById('reset-button');
      resetButton.addEventListener('click', function() {
        resetConversations();
      });

      renderChatHistory();
      document.getElementById('user-input').focus();
    });

    function disableButton() {
      const sendButton = document.getElementById('send-button');
      sendButton.disabled = true;
      sendButton.textContent = 'Loading...';
    }

    function enableButton() {
      const sendButton = document.getElementById('send-button');
      sendButton.disabled = false;
      sendButton.textContent = 'Send Message';
      document.getElementById('user-input').focus();
      document.getElementById('user-input').scrollIntoView({ behavior: 'smooth' });
    }
  </script>
</body>
</html>
