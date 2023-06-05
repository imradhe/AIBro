<?php 

?>
<!DOCTYPE html>
<html lang="en">
  <?php include("views/partials/head.php"); ?>

  <body>
    <?php include("views/partials/nav.php"); ?>

    <div class="container">
      <div class="mt-5 logo text-center">
        <img
          src="https://placehold.co/120"
          alt="AI Bro Logo"
          class="img-fluid my-2 mt-5"
        />
        <h4>
          Your AI Assistant for Career Guidance <br />
          & College Counseling
        </h4>
      </div>

      <div class="examples text-center mt-5">
        <h5 class="text-secondary pt-5">Try asking about</h5>

        <div class="d-flex flex-column align-items-center">
          <button class="btn btn-outline-secondary rounded-pill my-2">
            "Top 10 IITs for Computer Science" →
          </button>
          <button class="btn btn-outline-secondary rounded-pill my-2">
            "Preparation strategy for JEE Mains" →
          </button>
          <button class="btn btn-outline-secondary rounded-pill my-2">
            "Rank Prediction for JEE Mains" →
          </button>
        </div>
      </div>

      <div class="conversations mt-5 pb-5">
        <div class="conversation mb-5">
          <div class="ai text-secondary">AI Bro</div>
          <div class="message bg-ai"></div>
        </div>
      </div>
    </div>

    <button class="btn btn-primary rounded-circle clear ms-2" id="clear">
      <i class="bi bi-eraser-fill fs-5"></i>
    </button>

    <textarea
      name="prompt"
      id="prompt"
      class="form-control prompt rounded-pill ps-4 pt-3"
      placeholder="Send a message"
    ></textarea>
    <button id="send" class="btn btn-transparent send">
      <i class="bi bi-send-fill"></i>
    </button>

    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <script src="<?php assets('js/app.js');?>"></script>
    <script>

      async function sendRequest(promptValue){
        let url = '<?php echo route('api/aibro') ?>'
        let data = new FormData()
        data.append('message', promptValue)
        data.append('count', count())
        data.append('tokens', tokenCount())


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