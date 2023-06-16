<?php 

?>
<!DOCTYPE html>
<html lang="en">
  <?php include("views/partials/head.php"); ?>
  

  <body class="pb-0 mb-0">
    <?php include("views/partials/nav.php"); ?>

    <div class="container">
      <div class="mt-5 logo text-center">
        <a href="<?php echo home()?>"><span class="logo" style="font-size:160px"><img
          src="<?php assets('img/AIBro.png');?>"
          alt="AI Bro Logo"
          class="img-fluid my-2 mt-5"
          style="max-height: 160px;"
        /> </span> </a>
        <h1 class="fs-4">
          Your AI Assistant for Career Guidance <br />
          & College Counseling
        </h1>
      </div>

      <div class="examples text-center mt-5">
        <h2 class="text-secondary pt-5 fs-5">Try asking about</h2>

        <div class="d-flex flex-column align-items-center">
          <button type="button" data-prompt="Top 10 IITs for Computer Science"  aria-label="example 1" class="btn btn-outline-secondary rounded-pill my-2">
            "Top 10 IITs for Computer Science" →
          </button>
          <button type="button" data-prompt="Preparation strategy for JEE Mains" aria-label="example 2" class="btn btn-outline-secondary rounded-pill my-2">
            "Preparation strategy for JEE Mains" →
          </button>
          <button type="button" data-prompt="Rank Prediction for JEE Mains" aria-label="example 3" class="btn btn-outline-secondary rounded-pill my-2">
            "Rank Prediction for JEE Mains" →
          </button>
        </div>
      </div>

      <div class="conversations mt-5 pb-5 px-4"></div>

    <div class="footer position-fixed navbar-fixed shadow-sm bottom-0 bg-white">

        <button type="button" aria-label="Clear Conversations" class="btn btn-clear btn-outline-dark btn-sm rounded-pill mt-2 mb-4 mx-2 fs-6" id="clear">
          <i class="bi bi-eraser-fill"></i> Clear </button> 

        <div class="text-center d-flex mb-3">
          
          <textarea
            name="prompt"
            id="prompt"
            class="form-control prompt rounded-pill mx-2"
            placeholder="Type your message here"
          ></textarea>

          <button id="send" aria-label="Send Message" class="btn btn-transparent send">
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
    
    let url = '<?php echo route('api/aibro') ?>'

    </script>
  </body>
</html> 