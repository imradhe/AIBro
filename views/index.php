<?php locked(['user', 'moderator', 'admin']); ?>
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
        .chat-container {
            border: 1px solid #ccc;
            padding: 10px;
        }

        #typing {
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

        textarea {
            min-height: 65px !important;
            max-height: 150px;
        }
    </style>
</head>

<body>
    <div class="container">
        <?php include('views/partials/nav.php'); ?>
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
    <script src="<?php assets('js/app.js') ?>"></script>

    <script>
        async function sendRequest() {
            disableButton();
            let userInput = document.getElementById('user-input').value;
            if (userInput.trim() == '') return enableButton();


            let url = '<?php echo route('api/aibro') ?>';
            let data = new FormData();
            data.append('message', userInput);
            data.append('count', count());
            data.append('tokens', tokenCount());
            try {


                let response = await axios.post(url, data);
                if (response.status === 200) {
                    let responseData = response.data;
                    if (responseData.status === '200' && responseData.message == "Success") {
                        let aiResponse = responseData.data.response;
                        aiResponse = aiResponse.replace(/<br\s*[\/]?>/gi, "\n");
                        let typingSpeed = 10; // Adjust typing speed (milliseconds per character)
                        let id = responseData.data[0].id;
                        let total_tokens = responseData.data[0].usage.total_tokens;
                        let finish_reason = responseData.data[0].choices[0].finish_reason;
                        let time = responseData.data[0].created;

                        typeHTML(aiResponse, typingSpeed);

                        renderChatHistory();
                        saveToLocalStorage(userInput, id, total_tokens, finish_reason, time, aiResponse);

                        userInput = document.querySelector('#user-input');
                        userInput.value = '';
                        userInput.focus();
                    }
                    else {
                        typeHTML(response.data.data, 10);
                        enableButton()
                    }

                }


            } catch (error) {
                console.log('Error: ' + error);
            }
        }
    </script>
</body>

</html>