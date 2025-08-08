document.addEventListener("DOMContentLoaded", function () {
  (function () {
    const ACCESS_TOKEN = "smartbuddy-303f355b5ccd90f3d0725a0d3065fb7a";
    const BOT_NAME = "Chiku";
    const BOT_IMAGE = "https://res.cloudinary.com/dxzoie0ab/image/upload/v1754590496/chatbot_images/xckcd7zkhbccp3vlth09.png";

    const chatBtn = document.createElement('button');
    chatBtn.id = 'chat-popup-btn';
    chatBtn.innerHTML = `<img src=${BOT_IMAGE} width="30">`;
    document.body.appendChild(chatBtn);

    const chatWindow = document.createElement('div');
    chatWindow.id = 'chat-popup-window';
    chatWindow.innerHTML = `
      <div class="chat-header">
        <img src=${BOT_IMAGE} width="30">
        <span>${BOT_NAME}</span>
      </div>
      <div class="chat-body" id="chat-body"></div>
      <div class="chat-input">
        <input type="text" id="chat-input-field" placeholder="Ask something..." />
        <button id="chat-send-btn">Send</button>
      </div>
    `;
    document.body.appendChild(chatWindow);

    const posX = getComputedStyle(document.documentElement).getPropertyValue('--chat-position-x').trim();
    const posY = getComputedStyle(document.documentElement).getPropertyValue('--chat-position-y').trim();
    const offsetX = getComputedStyle(document.documentElement).getPropertyValue('--chat-offset-x').trim();
    const offsetY = getComputedStyle(document.documentElement).getPropertyValue('--chat-offset-y').trim();

    chatBtn.style[posX] = offsetX;
    chatBtn.style[posY] = offsetY;
    chatWindow.style[posX] = offsetX;
    chatWindow.style[posY] = `calc(${offsetY} + 70px)`;

    chatBtn.addEventListener('click', () => {
      chatWindow.style.display = chatWindow.style.display === 'flex' ? 'none' : 'flex';
    });

    const sendBtn = document.getElementById('chat-send-btn');
    const inputField = document.getElementById('chat-input-field');

    sendBtn.addEventListener('click', sendMessage);

    // Send message when pressing Enter
    inputField.addEventListener('keypress', function (e) {
      if (e.key === 'Enter' && !e.shiftKey) {
        e.preventDefault();
        sendMessage();
      }
    });

    async function sendMessage() {
      const msg = inputField.value.trim();
      if (!msg) return;

      appendMessage('user', msg);
      inputField.value = '';

      // Show typing indicator
      const typingId = appendTypingIndicator();

      try {
        const res = await fetch('/api/ask', {
          method: 'POST',
          headers: {
            'Content-Type': 'application/json',
            'Authorization': `Bearer ${ACCESS_TOKEN}`
          },
          body: JSON.stringify({ question: msg })
        });
        const data = await res.json();

        // Replace typing indicator with actual answer
        updateMessageText(typingId, data.answer || "No response");
      } catch (err) {
        updateMessageText(typingId, "Error contacting server");
      }
    }

    function appendMessage(sender, text) {
      const chatBody = document.getElementById('chat-body');
      if (!chatBody) return;
      const msgEl = document.createElement('div');
      msgEl.className = `chat-msg ${sender}`;
      msgEl.innerText = text;
      chatBody.appendChild(msgEl);
      chatBody.scrollTop = chatBody.scrollHeight;
      return msgEl;
    }

    function appendTypingIndicator() {
      const chatBody = document.getElementById('chat-body');
      const typingEl = document.createElement('div');
      typingEl.className = 'chat-msg bot typing-indicator';
      typingEl.innerHTML = `<span class="dot"></span><span class="dot"></span><span class="dot"></span>`;
      chatBody.appendChild(typingEl);
      chatBody.scrollTop = chatBody.scrollHeight;
      return typingEl;
    }

    function updateMessageText(msgEl, newText) {
      if (msgEl) {
        msgEl.classList.remove('typing-indicator');
        msgEl.innerHTML = newText;
      }
    }

    // Inject styles for typing dots
    const style = document.createElement('style');
    style.innerHTML = `
      .typing-indicator {
        display: inline-flex;
        align-items: center;
        gap: 4px;
      }
      .typing-indicator .dot {
        width: 6px;
        height: 6px;
        background-color: #999;
        border-radius: 50%;
        animation: blink 1.4s infinite both;
      }
      .typing-indicator .dot:nth-child(2) {
        animation-delay: 0.2s;
      }
      .typing-indicator .dot:nth-child(3) {
        animation-delay: 0.4s;
      }
      @keyframes blink {
        0%, 80%, 100% { transform: scale(0); }
        40% { transform: scale(1); }
      }
    `;
    document.head.appendChild(style);

  })();
});
