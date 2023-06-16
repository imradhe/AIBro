
      // Variables
      prompt = document.querySelector("#prompt")
      const clear = document.querySelector("#clear")
      const send = document.querySelector("#send")
      const conversations = document.querySelector(".conversations")
      const examples = document.querySelector(".examples")
      const allExamples = document.querySelectorAll(".examples .btn")
      const allConversations = document.querySelectorAll(".conversation")
      let lastConversation = document.querySelector(".conversations .conversation:last-child .message")
      let myModal = new bootstrap.Modal(document.querySelector("#announcement"))



    prompt.addEventListener("keyup", function () {
      send.classList.toggle("text-success", prompt.value != "")
    })

    // 1. Type HTML Function 
    function typeHTML(html, speed){
      lastConversation = document.querySelector(
        ".conversations .conversation:last-child .message"
      )
      lastConversation.innerHTML = ""
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

   // 2. Greetings
    function greetings() {
      disable()
      let greeting =
        "Hello! I am AI Bro, an AI chat assistant for career guidance and college counseling. \n\nHow may I help you today?"
      typeHTML(greeting, 10)
    }

    // 3. Render
    function render() {
      let getConversations = JSON.parse(localStorage.getItem("conversations")) || []
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
        if (greetings()){ 
            enable()
        }
      } else examples.style.display ="none"
      

      lastConversation = document.querySelector(".conversations .conversation:last-child .message")
      lastConversation.scrollIntoView({ behavior: "smooth" })
        loginModal()
      
    }
    // 4. Clear Conversations
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
      if (greetings()) {
          enable()
      }
    }

    clear.addEventListener("click", clearConversations)

    

    // 5. Disable
    function disable() {
      send.disabled = true
      clear.disabled = true
      send.innerHTML =
        '<span class="spinner-grow spinner-grow-sm" role="status" aria-hidden="true"></span>'
    }

    // 6. Enable
    function enable() {
      send.disabled = false
      clear.disabled = false
      send.innerHTML = '<i class="bi bi-send-fill"></i>'
      prompt.focus()
      lastConversation.scrollIntoView({ behavior: "smooth" })
    }

    // 7. Count 
    function count() {
      let conversations = JSON.parse(localStorage.getItem("conversations")) || []
      let currentTime = new Date().getTime()
      let twentyFourHoursAgo = currentTime - 2 * 60 * 60 * 1000 // 2 hours ago in milliseconds
      let count = 0

      for (const conversation of conversations) {
        let conversationTime = conversation.time
        if (twentyFourHoursAgo >= conversationTime) {
          count++
        }
      }

      return count
    }

    // 8. Token Count
    function tokenCount() {
      let conversations = JSON.parse(localStorage.getItem("conversations")) || []
      let currentTime = new Date().getTime()
      let twentyFourHoursAgo = currentTime - 2 * 60 * 60 * 1000 // 2 hours ago in milliseconds
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
    
    
          send.addEventListener("click", async function (e) {
        e.preventDefault()
          
        if(count() == 2 && !getCookie('auth')) {
            myModal.show()
            return
        }

        // Check if prompt value is empty
        if (prompt.value.trim() === "") {
          prompt.focus()
          return // Stop executing the function
        }
        promptValue = prompt.value

        conversations.innerHTML += `
              <div class="conversation mb-3">
                <div class="you text-secondary">You</div>
                <div class="message bg-you">${promptValue}</div>
              </div>
            `
        prompt.value = ""

      lastConversation = document.querySelector(".conversations .conversation:last-child .message")
      lastConversation.scrollIntoView({ behavior: "smooth" })
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
          if (typeHTML(response.aiResponse, 10)) {
            enable()
          }
        } else {
          conversations.innerHTML += `
    <div class="conversation mb-5">
      <div class="ai text-secondary">AI Bro</div>
      <div class="message bg-ai"></div>
    </div>
  `
          errorMsg =
            "Limit exceeded. Try again after 2 hrs\n"
          if (typeHTML(errorMsg, 10)) {
            enable()
          }


        }
      })


      // 10. Save

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



      const data = {
        "Top 10 IITs for Computer Science": "Here are the top 10 IITs for Computer Science:\n\n1. Indian Institute of Technology Bombay (IITB)\n2. Indian Institute of Technology Delhi (IITD)\n3. Indian Institute of Technology Kanpur (IITK)\n4. Indian Institute of Technology Madras (IITM)\n5. Indian Institute of Technology Kharagpur (IITKGP)\n6. Indian Institute of Technology Roorkee (IITR)\n7. Indian Institute of Technology Guwahati (IITG)\n8. Indian Institute of Technology Hyderabad (IITH)\n9. Indian Institute of Technology Patna (IITP)\n10. Indian Institute of Technology Gandhinagar (IITGN)\n",

        "Preparation strategy for JEE Mains": "To prepare for JEE Mains, you should follow a well-planned strategy that includes the following steps:\n\n1. Understand the syllabus and exam pattern: Before starting your preparation, you should have a clear understanding of the JEE Mains syllabus and exam pattern. This will help you to focus on the important topics and prepare accordingly.\n\n2. Create a study plan: Once you have a clear understanding of the syllabus and exam pattern, create a study plan that includes a daily schedule for studying, revising, and practicing.\n\n3. Focus on the basics: JEE Mains is all about understanding the basics of Physics, Chemistry, and Mathematics. So, focus on building a strong foundation by understanding the concepts and practicing the problems.\n\n4. Practice regularly: Regular practice is the key to success in JEE Mains. Solve as many problems as possible from different sources, including previous year question papers, mock tests, and sample papers.\n\n5. Revise regularly: Revision is important to retain what you have learned. Make sure to revise the topics regularly and keep a track of your progress.\n\n6. Stay motivated: JEE Mains is a tough exam, and it requires a lot of hard work and dedication. Stay motivated and focused on your goal, and don't let any setbacks demotivate you.\n\nRemember, consistency and hard work are the keys to success in JEE Mains. Good luck with your preparation!\n",
        "Rank Prediction for JEE Mains": "It will be updated soon! Please wait"
      }

      function getMsg(element) {
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

          
         function getCookie(cookieName) {
          const name = cookieName + "=";
          const cDecoded = decodeURIComponent(document.cookie); //to be careful
          const cArr = cDecoded.split('; ');
          let res;
          cArr.forEach(val => {
            if (val.indexOf(name) === 0) res = val.substring(name.length);
          })
          return res;
        }
        
        function loginModal(){
          if(count() == 2 && !getCookie('auth')) myModal.show()
        }