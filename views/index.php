<?php 

?>
<!DOCTYPE html>
<html lang="en">
  <?php include("views/partials/head.php"); ?>
  
  <style>
      
    * {
  font-family: "Poppins";
  box-sizing: border-box;
  margin: 0;
  padding: 0;
}

.btn:focus {
  outline: none !important;
  box-shadow: none !important;
}

img {
  user-select: none !important;
  pointer-events: none !important;
}
#app img {
  max-height: 40vh;
}

.btn-graphene {
  font-weight: bolder;
  letter-spacing: 1px;
  padding: 8px 28px;
  border-radius: 50px;
  transition: 0.5s;
  margin: 10px;
  background-color: rgba(173, 220, 203);
  color: #000;
  border: 2px solid #addccb;
}

.btn-graphene:hover,
.btn-graphene:active,
.btn-graphene:focus {
  background-color: rgba(173, 220, 203, 0.3);
  border: 2px solid #addccb;
  color: #000;
}

.navbar * {
  user-select: none !important;
}

body {
  overflow-x: hidden;
}

.examples button {
  font-size: 14px;
}

.conversations {
  margin-bottom: 200px;
}

.conversation .role {
  font-size: 14px;
}
.conversation .message {
  border-radius: 10px;
  padding: 2%;
  white-space: pre-wrap;
}

.bg-ai {
  background-color: #5454541f;
}
.bg-you {
  background-color: #a6a6a68f;
  color: #000;
}

.btn-clear{
  color: #545454;
  border: 1px solid #545454;
  background-color: #fff;
}

.prompt{
  height: 50px;
  resize: none;
  z-index: 1;
  min-width: 80vw;
  padding-top: 12px;
}

.send{
  position: relative;
  right: 60px;
  z-index: 2;
  transform: rotate(45deg);
}

.disclaimer{
  font-size: 12px;
}
@media screen and (min-width: 1920px) {
  .prompt{
     min-width: 70vw;
  }
}

@media screen and (max-width: 576px) {
  .prompt{
     min-width: 92vw;
  }
}
  
  </style>

  <body class="pb-0 mb-0">
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



    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>

    <script>
      const prompt = document.querySelector("#prompt")
      const clear = document.querySelector("#clear")
      const send = document.querySelector("#send")
      const conversations = document.querySelector(".conversations")
      const examples = document.querySelector(".examples")
      const allExamples = document.querySelectorAll(".examples .btn")
      const allConversations = document.querySelectorAll(".conversation")
      let lastConversation = document.querySelector(
        ".conversations .conversation:last-child .message"
      )



    prompt.addEventListener("keyup", function () {
      send.classList.toggle("text-success", prompt.value !== "")
    })


    function typeHTML(html, speed) {
      lastConversation = document.querySelector(
        ".conversations .conversation:last-child .message"
      )
      lastConversation.innerHTML = "" // Clear previous content
      let index = 0
      let typingInterval = setInterval(() => {
        lastConversation.innerHTML += html[index]
        index++
        if (index >= html.length) {
          clearInterval(typingInterval)
          enable()
        }
      }, speed)
    }

    function greetings() {
      disable()
      let greeting =
        "Hello! I am AI Bro, an AI chat assistant for career guidance and college counseling. \n\nHow may I help you today?"
      typeHTML(greeting, 10)
    }

    function save(prompt, id, total_tokens, finish_reason, time, aiResponse) {
      let conversation = {
        prompt: prompt,
        id: id,
        total_tokens: total_tokens,
        finish_reason: finish_reason,
        time: time,
        aiResponse: aiResponse,
        removed: false, // Set removed attribute to false initially
      }

      let getConversations =
        JSON.parse(localStorage.getItem("conversations")) || []
      getConversations.push(conversation)
      set = localStorage.setItem("conversations", JSON.stringify(getConversations))

      return set
    }

    function render() {
      let getConversations =
        JSON.parse(localStorage.getItem("conversations")) || []
      let html = ""

      for (const conversation of getConversations) {
        if (!conversation.removed) {
          html += `
            <div class="conversation mb-3">
              <div class="you text-secondary">You</div>
              <div class="message bg-you">${conversation.prompt}</div>
            </div>

            <div class="conversation mb-5">
              <div class="ai text-secondary">AI Bro</div>
              <div class="message bg-ai">${conversation.aiResponse}</div>
            </div>
          `
        } 
      }

      conversations.innerHTML = html

      if (conversations.innerHTML === "") {
        examples.style.display ="block"
        conversations.innerHTML += `
          <div class="conversation mb-5">
            <div class="ai text-secondary">AI Bro</div>
            <div class="message bg-ai"></div>
          </div>
          `
        if (greetings()) enable()
      } else examples.style.display ="none"
      

      lastConversation = document.querySelector(
        ".conversations .conversation:last-child .message"
      )
      lastConversation.scrollIntoView({ behavior: "smooth" })
    }

    function reset() {
      conversations.innerHTML = ""
      disable()
      localStorage.removeItem("conversations")
      conversations.innerHTML += `
      <div class="conversation mb-5">
        <div class="ai text-secondary">AI Bro</div>
        <div class="message bg-ai"></div>
      </div>
      `
      if (greetings()) enable()
    }

    function clearConversations() {
      conversations.innerHTML = ""
      let getConversations = JSON.parse(localStorage.getItem("conversations"))
      
      if(getConversations){
        conversations.innerHTML = ''
        getConversations.forEach(conversation=> {
          conversation.removed = true
        })
        localStorage.setItem("conversations", JSON.stringify(getConversations))
      }
      conversations.innerHTML += `
        <div class="conversation mb-5">
          <div class="ai text-secondary">AI Bro</div>
          <div class="message bg-ai"></div>
        </div>
        `
        examples.style.display ="block"
      if (greetings()) enable()
    }

    clear.addEventListener("click", clearConversations)




    function disable() {
      send.disabled = true
      clear.disabled = true
      send.innerHTML =
        '<span class="spinner-grow spinner-grow-sm" role="status" aria-hidden="true"></span>'
    }

    function enable() {
      send.disabled = false
      clear.disabled = false
      send.innerHTML = '<i class="bi bi-send-fill"></i>'
      prompt.focus()
      lastConversation.scrollIntoView({ behavior: "smooth" })
    }

    function count() {
      let conversations = JSON.parse(localStorage.getItem("conversations")) || []
      let currentTime = new Date().getTime()
      let twentyFourHoursAgo = currentTime - 24 * 60 * 60 * 1000 // 24 hours ago in milliseconds
      let count = 0

      for (const conversation of conversations) {
        let conversationTime = conversation.time
        if (twentyFourHoursAgo >= conversationTime) {
          count++
        }
      }

      return count
    }

    function tokenCount() {
      let conversations = JSON.parse(localStorage.getItem("conversations")) || []
      let currentTime = new Date().getTime()
      let twentyFourHoursAgo = currentTime - 24 * 60 * 60 * 1000 // 24 hours ago in milliseconds
      let count = 0

      for (const conversation of conversations) {
        let tokens = conversation.total_tokens
        if (twentyFourHoursAgo >= tokens) {
          count += tokens
        }
      }

      return count
    }

    window.addEventListener("load", function () {
      render()
    })
    </script>
    <script>
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

        send.addEventListener("click", async function (e) {
          e.preventDefault()

          const promptValue = prompt.value

          // Check if prompt value is empty
          if (promptValue === "") {
            prompt.focus()
            return // Stop executing the function
          }

          conversations.innerHTML += `
    <div class="conversation mb-3">
      <div class="you text-secondary">You</div>
      <div class="message bg-you">${promptValue}</div>
    </div>
  `
          prompt.value = ""

          disable()

          const response = await sendRequest(promptValue)

          if (response) {
            conversations.innerHTML += `
    <div class="conversation mb-5">
      <div class="ai text-secondary">AI Bro</div>
      <div class="message bg-ai"></div>
    </div>
  `

            lastConversation.scrollIntoView({ behavior: "smooth" })
            save(
              response.promptValue,
              response.id,
              response.total_tokens,
              response.finish_reason,
              response.time,
              response.aiResponse
            )
            if (typeHTML(response.aiResponse, 10)) enable()
          } else {
            conversations.innerHTML += `
    <div class="conversation mb-5">
      <div class="ai text-secondary">AI Bro</div>
      <div class="message bg-ai"></div>
    </div>
  `
            errorMsg =
              "Daily Limit of 5 conversations or 2000 tokens exceeded. Try again after 24 hrs"
            if (typeHTML(errorMsg, 10)) enable()
          }
        })

          const data = {
            "Top 10 IITs for Computer Science" : "Here are the top 10 IITs for Computer Science:\n\n1. Indian Institute of Technology Bombay (IITB)\n2. Indian Institute of Technology Delhi (IITD)\n3. Indian Institute of Technology Kanpur (IITK)\n4. Indian Institute of Technology Madras (IITM)\n5. Indian Institute of Technology Kharagpur (IITKGP)\n6. Indian Institute of Technology Roorkee (IITR)\n7. Indian Institute of Technology Guwahati (IITG)\n8. Indian Institute of Technology Hyderabad (IITH)\n9. Indian Institute of Technology Patna (IITP)\n10. Indian Institute of Technology Gandhinagar (IITGN)\n", 
            
            "Preparation strategy for JEE Mains" : "To prepare for JEE Mains, you should follow a well-planned strategy that includes the following steps:\n\n1. Understand the syllabus and exam pattern: Before starting your preparation, you should have a clear understanding of the JEE Mains syllabus and exam pattern. This will help you to focus on the important topics and prepare accordingly.\n\n2. Create a study plan: Once you have a clear understanding of the syllabus and exam pattern, create a study plan that includes a daily schedule for studying, revising, and practicing.\n\n3. Focus on the basics: JEE Mains is all about understanding the basics of Physics, Chemistry, and Mathematics. So, focus on building a strong foundation by understanding the concepts and practicing the problems.\n\n4. Practice regularly: Regular practice is the key to success in JEE Mains. Solve as many problems as possible from different sources, including previous year question papers, mock tests, and sample papers.\n\n5. Revise regularly: Revision is important to retain what you have learned. Make sure to revise the topics regularly and keep a track of your progress.\n\n6. Stay motivated: JEE Mains is a tough exam, and it requires a lot of hard work and dedication. Stay motivated and focused on your goal, and don't let any setbacks demotivate you.\n\nRemember, consistency and hard work are the keys to success in JEE Mains. Good luck with your preparation!\n", 
            "Rank Prediction for JEE Mains" : "It will be updated soon! Please wait" 
          }

          function getMsg(element){
            
            disable()
            examples.style.display = "none"
            msg = element.dataset.prompt
            let currentTime = new Date().getTime()
            save(msg, "", 0, "stop", currentTime, data[msg])
            conversations.innerHTML += `
            <div class="conversation mb-3">
              <div class="you text-secondary">You</div>
              <div class="message bg-you">${msg}</div>
            </div>
    
            <div class="conversation mb-5">
              <div class="ai text-secondary">AI Bro</div>
              <div class="message bg-ai"></div>
            </div>
            `
            typeHTML(data[msg], 10)
            enable()

          }

          allExamples.forEach(example => {
            example.addEventListener('click', () => getMsg(example))
          })
      </script>
  </body>
</html> 