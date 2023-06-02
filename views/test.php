<!DOCTYPE html>
<html>
<head>
  <title>AI Bro - AI Chat Assitant for Career Guidance & College Counseling</title>
  <style>
    .chat-container {
      border: 1px solid #ccc;
      padding: 10px;
      white-space: pre-wrap !important;
      max-width: 20vw;
      max-height: 300px;
      overflow-y: scroll;
    }
    .message {
      margin-bottom: 10px;
    }
  </style>
</head>
<body>
  <div class="chat-container">
    <div class="message">User: <textarea type="text" id="user-input"></textarea></div>
    <div class="message">AI Bro: <span id="typing"></span></div>
  </div>
  <button id="send-button">Send Message</button>

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
        }
      }, speed);
    }

    function sendRequest() {
      const userInput = document.getElementById('user-input').value;
      if (userInput.trim() === '') return;
      
      const xhr = new XMLHttpRequest();
      const url = '<?php echo route('api/aibro')?>';
      const data = new FormData();
      data.append('message', userInput);

      xhr.open('POST', url, true);
      xhr.onreadystatechange = function() {
        if (xhr.readyState === 4) {
          if (xhr.status === 200) {
            const response = JSON.parse(xhr.responseText);
            if (response.status === '200') {
              aiResponse = response.data;
              aiResponse = aiResponse.replace(/<br\s*[\/]?>/gi, "\n");
              const typingSpeed = 10; // Adjust typing speed (milliseconds per character)
              typeHTML(aiResponse, typingSpeed);
            }
          } else {
            console.log('Error: ' + xhr.status);
          }
        }
      };
      xhr.send(data);
    }

    document.addEventListener('DOMContentLoaded', function() {
      const sendButton = document.getElementById('send-button');
      sendButton.addEventListener('click', function() {
        sendRequest();
      });
    });
  </script>
</body>
</html>
