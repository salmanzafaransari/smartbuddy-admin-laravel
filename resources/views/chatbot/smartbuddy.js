document.addEventListener("DOMContentLoaded", function () {
  (function () {
    const ACCESS_TOKEN = "{{ACCESS_TOKEN}}";
    const BOT_NAME = "{{BOT_NAME}}";
    const BOT_IMAGE = "{{BOT_IMAGE}}";
    const STORAGE_KEY = "{{CHAT_HISTORY}}";
    const trashimage = "https://res.cloudinary.com/dxzoie0ab/image/upload/v1754735371/chatbot_images/trash_c1zmjn.png";

    const chatBtn = document.createElement('button');
    chatBtn.id = 'chat-popup-btn';
    chatBtn.innerHTML = `<img src=${BOT_IMAGE} width="50" style="border-radius:50% !important;">`;
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
        <button id="clear-chat-btn" title="Clear Chat"><img src=${trashimage} width="15" /></button>
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

    inputField.addEventListener('keypress', function (e) {
      if (e.key === 'Enter' && !e.shiftKey) {
        e.preventDefault();
        sendMessage();
      }
    });

    // Load chat history
    loadChatHistory();
    document.getElementById("clear-chat-btn").addEventListener("click", function () {
      localStorage.removeItem(STORAGE_KEY);
      document.getElementById("chat-body").innerHTML = "";
    });

    async function sendMessage() {
      const API_BASE = "http://localhost:8000";
      const msg = inputField.value.trim();
      if (!msg) return;

      appendMessage('user', msg, true); // true = save to storage
      inputField.value = '';

      const typingId = appendTypingIndicator();

      try {
        const res = await fetch(`${API_BASE}/api/ask`, {
          method: 'POST',
          headers: {
            'Content-Type': 'application/json',
            'Authorization': `Bearer ${ACCESS_TOKEN}`
          },
          body: JSON.stringify({ question: msg })
        });
        const data = await res.json();
        updateMessageText(typingId, data.answer || "No response", true);
      } catch (err) {
        updateMessageText(typingId, "Error contacting server", true);
      }
    }

    function appendMessage(sender, text, save = false) {
      const chatBody = document.getElementById('chat-body');
      if (!chatBody) return;
      const msgEl = document.createElement('div');
      msgEl.className = `chat-msg ${sender}`;
      msgEl.innerText = text;
      chatBody.appendChild(msgEl);
      chatBody.scrollTop = chatBody.scrollHeight;

      if (save) {
        saveMessage(sender, text);
      }

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

    function updateMessageText(msgEl, newText, save = false) {
      if (msgEl) {
        msgEl.classList.remove('typing-indicator');
        msgEl.innerHTML = newText;

        if (save) {
          saveMessage('bot', newText);
        }
      }
    }

    // LocalStorage handling
    function saveMessage(sender, text) {
      let history = JSON.parse(localStorage.getItem(STORAGE_KEY) || "[]");
      history.push({ sender, text });
      localStorage.setItem(STORAGE_KEY, JSON.stringify(history));
    }

    function loadChatHistory() {
      const history = JSON.parse(localStorage.getItem(STORAGE_KEY) || "[]");
      history.forEach(msg => {
        appendMessage(msg.sender, msg.text);
      });
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
