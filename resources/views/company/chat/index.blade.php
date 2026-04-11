<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Chat</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <style>
        body {
            margin: 0;
            font-family: Arial;
            background: #0b141a;
        }

        .app {
            display: flex;
            height: 100vh;
        }

        /* Sidebar */
        .sidebar {
            width: 320px;
            background: #111b21;
            color: white;
            overflow-y: auto;
            border-right: 1px solid #222;
        }

        .chat-item {
            padding: 12px;
            border-bottom: 1px solid #222;
            cursor: pointer;
        }

        .chat-item:hover {
            background: #202c33;
        }

        /* Chat area */
        .chat {
            flex: 1;
            display: flex;
            flex-direction: column;
        }

        .header {
            background: #202c33;
            padding: 10px;
            color: white;
        }

        .messages {
            flex: 1;
            padding: 10px;
            overflow-y: auto;
        }

        .msg {
            margin: 6px 0;
        }

        .bubble {
            display: inline-block;
            padding: 8px 10px;
            border-radius: 8px;
            max-width: 60%;
            color: white;
        }

        .me {
            text-align: right;
        }

        .me .bubble {
            background: #005c4b;
        }

        .other .bubble {
            background: #202c33;
        }

        .input-box {
            display: flex;
            padding: 10px;
            background: #202c33;
        }

        input {
            flex: 1;
            padding: 8px;
            border: none;
            outline: none;
        }

        button {
            margin-left: 8px;
            padding: 8px 12px;
            background: #00a884;
            border: none;
            color: white;
            cursor: pointer;
        }

        .unread {
            color: #00a884;
            font-size: 12px;
        }
    </style>
</head>
<body>

<div class="app">

    <!-- Sidebar -->
    <div class="sidebar" id="conversationList">
        Loading chats...
    </div>

    <!-- Chat -->
    <div class="chat">

        <div class="header" id="chatHeader">
            Select a chat
        </div>

        <div class="messages" id="messageList"></div>

        <div class="input-box">
            <input type="text" id="msgInput" placeholder="Type message..." />
            <button onclick="sendMessage()">Send</button>
        </div>

    </div>

</div>

<script>
let currentConversation = null;
let lastMessageId = null;
let allConversations = [];

const ADMIN_ID = {{ Auth::id() }};

// INIT
document.addEventListener('DOMContentLoaded', () => {
    loadConversations();

    // 🔁 Auto refresh every 5 sec
    setInterval(() => {
        refreshData();
    }, 5000);
});

// ----------------------
// LOAD CONVERSATIONS
// ----------------------
function loadConversations() {
    fetch('/company/chat/conversations')
        .then(res => res.json())
        .then(data => {
            allConversations = data;
            renderConversations(data);
        });
}

// ----------------------
// RENDER SIDEBAR
// ----------------------
function renderConversations(list) {
    const box = document.getElementById('conversationList');

    box.innerHTML = list.map(c => `
        <div class="chat-item" onclick="openChat(${c.id})">
            <b>${c.name}</b><br>
            <small>${c.last_message || ''}</small><br>
            ${c.unread_count > 0 ? `<span class="unread">${c.unread_count} unread</span>` : ''}
        </div>
    `).join('');
}

// ----------------------
// OPEN CHAT
// ----------------------
function openChat(id) {
    currentConversation = id;
    lastMessageId = null;

    document.getElementById('messageList').innerHTML = '';

    fetch(`/company/chat/messages/${id}`)
        .then(res => res.json())
        .then(data => {
            data.forEach(m => {
                renderMessage(m);
                lastMessageId = m.id;
            });
        });
}

// ----------------------
// AUTO REFRESH
// ----------------------
function refreshData() {
    loadConversations();

    if (currentConversation) {
        refreshMessages(currentConversation);
    }
}

// ----------------------
// REFRESH MESSAGES
// ----------------------
function refreshMessages(id) {
    let url = `/company/chat/messages/${id}`;

    if (lastMessageId) {
        url += `?last_id=${lastMessageId}`;
    }

    fetch(url)
        .then(res => res.json())
        .then(data => {
            data.forEach(m => {
                if (!document.querySelector(`[data-id="${m.id}"]`)) {
                    renderMessage(m);
                    lastMessageId = m.id;
                }
            });
        });
}

// ----------------------
// SEND MESSAGE
// ----------------------
function sendMessage() {
    const input = document.getElementById('msgInput');
    const text = input.value.trim();

    if (!text || !currentConversation) return;

    fetch('/company/chat/send', {
        method: 'POST',
        headers: {
            'Content-Type':'application/json',
            'X-CSRF-TOKEN':'{{ csrf_token() }}'
        },
        body: JSON.stringify({
            conversation_id: currentConversation,
            message: text
        })
    })
    .then(res => res.json())
    .then(m => {
        renderMessage(m);
        lastMessageId = m.id;
    });

    input.value = '';
}

// ----------------------
// RENDER MESSAGE
// ----------------------
function renderMessage(m) {
    const isMe = m.sender_id == ADMIN_ID;

    const div = document.createElement('div');
    div.className = 'msg ' + (isMe ? 'me' : 'other');
    div.setAttribute('data-id', m.id);

    div.innerHTML = `
        <div class="bubble">
            ${m.is_deleted ? '🚫 Deleted' : m.content}
            <br>
            <small style="opacity:0.6">${m.created_at}</small>
        </div>
    `;

    document.getElementById('messageList').appendChild(div);

    // auto scroll
    document.getElementById('messageList').scrollTop =
        document.getElementById('messageList').scrollHeight;
}
</script>

</body>
</html>