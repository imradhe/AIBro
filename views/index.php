<?php 

?>
<!DOCTYPE html>
<html lang="en">
  <?php include("views/partials/head.php"); ?>
  

  <body class="pb-0 mb-0">
    <?php include("views/partials/nav.php"); ?>

    <div class="container">
      <div class="mt-5 logo text-center">
        <img
          src="<?php assets('img/AIBro.png');?>"
          alt="AI Bro Logo"
          class="img-fluid my-2 mt-5"
          style="max-height: 240px"
        />
        <h4>
          Your AI Assistant for Career Guidance <br />
          & College Counseling
        </h4>
      </div>

      <div class="examples text-center mt-5">
        <h5 class="text-secondary pt-5">Try asking about</h5>

        <div class="d-flex flex-column align-items-center">
          <button type="button" data-prompt="Top 10 IITs for Computer Science" class="btn btn-outline-secondary rounded-pill my-2">
            "Top 10 IITs for Computer Science" →
          </button>
          <button type="button" data-prompt="Preparation strategy for JEE Mains" class="btn btn-outline-secondary rounded-pill my-2">
            "Preparation strategy for JEE Mains" →
          </button>
          <button type="button" data-prompt="Rank Prediction for JEE Mains" class="btn btn-outline-secondary rounded-pill my-2">
            "Rank Prediction for JEE Mains" →
          </button>
        </div>
      </div>

      <div class="conversations mt-5 pb-5 px-4"></div>

    <div class="footer position-fixed navbar-fixed  bottom-0 pt-1 bg-white">

        <button type="button" class="btn btn-clear btn-outline-dark btn-sm rounded-pill my-3 mx-2" id="clear">
          <i class="bi bi-eraser-fill fs-5"></i> Clear Conversations
        </button> 

        <div class="text-center d-flex mb-3">
          
          <textarea
            name="prompt"
            id="prompt"
            class="form-control prompt rounded-pill mx-2"
            placeholder="Type your message here"
          ></textarea>

          <button id="send" class="btn btn-transparent send">
            <i class="bi bi-send-fill"></i>
          </button>

        </div>  


    </div>

    <div class="modal fade" id="announcement" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
          <h5 class="modal-title" id="announcementTitle"><img src="<?php assets("img/AIBroLogo.png")?>" alt="AI Bro" class="img-fluid" style="max-height: 60px;"></h5>
          </div>
          <div class="modal-body text-center">
          <h4><b>Welcome!</b></h4>
          <h5>Login or Create an account to continue</h5>
          <div class="lead">
          <a href="<?php echo route('login')?>" class="btn btn-secondary rounded-pill fw-bold m-2">Login</a>
          <a href="<?php echo route('register')?>" class="btn btn-primary rounded-pill fw-bold m-2">Create An Account</a>
          </div>
          </div>
        </div>
      </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    
    <script src="<?php assets('js/app.js');?>"></script>

    <script>
    
    // 9. Send Request
      async function sendRequest(promptValue){

          let url = '<?php echo route('api/aibro') ?>'
        let data = new FormData()
        data.append('message', promptValue)
        data.append('count', count())
        data.append('tokens', tokenCount())
        examples.style.display = "none"

        try {
          let response = await axios.post(url, data)

          if (response.status === 200) {
            let responseData = response.data

            if (responseData.status === '200' && responseData.message === 'Success') {
              let aiResponse = responseData.data.response.replace(/<br\s*[\/]?>/gi, '\n')
              let id = responseData.data[0].id
              let total_tokens = responseData.data[0].usage.total_tokens
              let finish_reason = responseData.data[0].choices[0].finish_reason
              let time = responseData.data[0].created

              return {
                promptValue: promptValue,
                id: id,
                total_tokens: total_tokens,
                finish_reason: finish_reason,
                time: time,
                aiResponse: aiResponse
              }

            } else {
              return false
            }
          }
        } catch (error) {
          console.log('Error: ' + error)
          return false
        }
      }


    </script>
  </body>
</html> 