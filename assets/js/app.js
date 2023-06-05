const prompt = document.querySelector("#prompt")
const clear = document.querySelector("#clear")
const send = document.querySelector("#send")
const conversations = document.querySelector(".conversations")
const allConversations = document.querySelector(".conversation")
let lastConversation = document.querySelector(
  ".conversations .conversation:last-child .message"
)

prompt.addEventListener("keyup", function () {
  prompt.style.height = "auto"
  prompt.style.height = prompt.scrollHeight + "px"
  prompt.classList.remove("rounded-pill")

  if (prompt.value === "") {
    prompt.style.height = ""
    prompt.classList.add("rounded-pill")
  }

  send.classList.toggle("text-success", prompt.value !== "")
})

prompt.addEventListener("focus", function () {
  prompt.style.height = "auto"
  prompt.style.height = prompt.scrollHeight + "px"
  prompt.classList.remove("rounded-pill")

  if (prompt.value === "") {
    prompt.style.height = ""
    prompt.classList.add("rounded-pill")
  }

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
  console.log(getConversations)
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
    conversations.innerHTML += `
      <div class="conversation mb-5">
        <div class="ai text-secondary">AI Bro</div>
        <div class="message bg-ai"></div>
      </div>
      `
    if (greetings()) enable()
  }
  

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
  disable()
  let getConversations = JSON.parse(localStorage.getItem("conversations"))
  //console.log(getConversations)
  getConversations.forEach(conversation=> {
    conversation.removed = true
    console.log(conversation)
  })
  localStorage.setItem("conversations", JSON.stringify(getConversations))
  conversations.innerHTML += `
    <div class="conversation mb-5">
      <div class="ai text-secondary">AI Bro</div>
      <div class="message bg-ai"></div>
    </div>
    `
  if (greetings()) enable()
}

clear.addEventListener("click", clearConversations)

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
    <div class="conversation mb-3">
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
    <div class="conversation mb-3">
      <div class="ai text-secondary">AI Bro</div>
      <div class="message bg-ai"></div>
    </div>
  `
    errorMsg =
      "Daily Limit of 5 conversations or 2000 tokens exceeded. Try again after 24 hrs"
    if (typeHTML(errorMsg, 10)) enable()
  }
})


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
