@extends('layouts.mobile-layout')

@push('styles')
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600&display=swap" rel="stylesheet"/>
<style>
*, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

::-webkit-scrollbar { width: 5px; }
::-webkit-scrollbar-track { background: transparent; }
::-webkit-scrollbar-thumb { background: #374151; border-radius: 4px; }

.app-wrapper {
    display: flex;
    width: 95%;
    height: 85vh;
    overflow: hidden;
    border-radius: 12px;
    box-shadow: 0 24px 80px rgba(0,0,0,.6);
}

/* ─── Sidebar ── */
.sidebar {
    width: 360px;
    min-width: 360px;
    height: 100%;
    background: #111b21;
    border-right: 1px solid #1d2b34;
    display: flex;
    flex-direction: column;
    flex-shrink: 0;
}
.sidebar-topbar {
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 10px 16px;
    background: #202c33;
    min-height: 58px;
    flex-shrink: 0;
}
.sidebar-search {
    padding: 8px 12px;
    background: #111b21;
    flex-shrink: 0;
}
.search-wrap {
    display: flex;
    align-items: center;
    gap: 8px;
    padding: 8px 12px;
    background: #202c33;
    border-radius: 8px;
}
.search-input {
    background: transparent;
    border: none;
    outline: none;
    color: #d1d7db;
    font-size: 13px;
    width: 100%;
}
.search-input::placeholder { color: #8696a0; }

.filter-tabs {
    display: flex;
    gap: 8px;
    padding: 0 12px 8px;
    background: #111b21;
    flex-shrink: 0;
}
.filter-tab {
    font-size: 12px;
    font-weight: 500;
    padding: 4px 12px;
    border-radius: 20px;
    border: none;
    cursor: pointer;
    transition: background .15s, color .15s;
    background: #202c33;
    color: #8696a0;
}
.filter-tab.active { background: #00a884; color: #111b21; }

#conversationList { flex: 1; overflow-y: auto; }

/* ─── Chat items ── */
.chat-item {
    display: flex;
    align-items: center;
    gap: 12px;
    padding: 10px 16px;
    cursor: pointer;
    transition: background .1s;
    border-bottom: 1px solid #1d2b34;
}
.chat-item:hover  { background: #202c33; }
.chat-item.active { background: #2a3942; }

.avatar-wrap { position: relative; flex-shrink: 0; }
.avatar-img  { width: 48px; height: 48px; border-radius: 50%; object-fit: cover; }
.online-dot {
    width: 10px; height: 10px;
    background: #00a884;
    border-radius: 50%;
    border: 2px solid #111b21;
    position: absolute; bottom: 0; right: 0;
}
.unread-badge {
    background: #00a884;
    color: #fff;
    font-size: 11px;
    font-weight: 600;
    border-radius: 50%;
    min-width: 18px;
    height: 18px;
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 0 4px;
    flex-shrink: 0;
}

/* ─── Chat Area ── */
.chat-area {
    flex: 1;
    display: flex;
    flex-direction: column;
    height: 100%;
    background: #0b141a;
    position: relative;
    overflow: hidden;
}
.chat-bg {
    background-image: url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' fill-rule='evenodd'%3E%3Cg fill='%23182229' fill-opacity='0.5'%3E%3Cpath d='M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E");
}

/* ─── Header ── */
.chat-header {
    display: flex;
    align-items: center;
    gap: 12px;
    padding: 8px 16px;
    background: #202c33;
    min-height: 58px;
    border-bottom: 1px solid #2a3942;
    flex-shrink: 0;
}

/* ─── Messages ── */
#messageList {
    flex: 1;
    overflow-y: auto;
    padding: 12px 10px;
    display: flex;
    flex-direction: column;
    gap: 2px;
}
.msg-row { display: flex; margin-bottom: 2px; }
.msg-row.me  { justify-content: flex-end; }
.msg-row.you { justify-content: flex-start; }

.bubble {
    max-width: 68%;
    padding: 7px 12px 6px;
    position: relative;
    word-break: break-word;
}
.bubble-out { background: #005c4b; border-radius: 8px 0 8px 8px; }
.bubble-in  { background: #202c33; border-radius: 0 8px 8px 8px; }
.bubble-text { font-size: 13.5px; color: #e9edef; line-height: 1.5; }
.bubble-meta {
    display: flex;
    align-items: center;
    gap: 3px;
    margin-top: 3px;
    justify-content: flex-end;
}
.bubble-time { font-size: 11px; color: #8696a0; white-space: nowrap; }
.msg-deleted { opacity: .45; font-style: italic; }

/* Action buttons */
.bubble-actions {
    position: absolute;
    top: 4px;
    display: flex;
    gap: 3px;
    opacity: 0;
    transition: opacity .15s;
    pointer-events: none;
}
.bubble:hover .bubble-actions { opacity: 1; pointer-events: auto; }
.bubble-out .bubble-actions { left: -70px; }
.bubble-in  .bubble-actions { right: -70px; }
.action-btn {
    font-size: 11px;
    padding: 2px 6px;
    border-radius: 4px;
    background: #2a3942;
    color: #8696a0;
    border: none;
    cursor: pointer;
    line-height: 1.6;
}
.action-btn:hover { background: #3a4a52; color: #d1d7db; }

/* File / voice bubble */
.bubble-file {
    display: flex;
    align-items: center;
    gap: 8px;
    background: rgba(255,255,255,.06);
    border-radius: 6px;
    padding: 6px 10px;
    margin-bottom: 4px;
    font-size: 12px;
    color: #d1d7db;
    text-decoration: none;
}
.bubble-file svg { flex-shrink: 0; }

/* ─── Typing ── */
#typingWrapper { padding: 4px 12px; flex-shrink: 0; display:none; }
.typing-bubble {
    display: none;
    align-items: center;
    gap: 4px;
    background: #202c33;
    border-radius: 0 8px 8px 8px;
    padding: 10px 14px;
    width: fit-content;
}
.typing-dot {
    width: 7px; height: 7px;
    background: #8696a0;
    border-radius: 50%;
    animation: bounce 1.2s infinite;
}
.typing-dot:nth-child(2) { animation-delay: .2s; }
.typing-dot:nth-child(3) { animation-delay: .4s; }
@keyframes bounce {
    0%,80%,100% { transform:translateY(0); }
    40%          { transform:translateY(-6px); }
}

/* ─── Input ── */
.input-bar {
    display: none;
    align-items: flex-end;
    gap: 10px;
    padding: 8px 14px;
    background: #202c33;
    flex-shrink: 0;
}
.input-wrap {
    flex: 1;
    background: #2a3942;
    border-radius: 10px;
    padding: 8px 14px;
}
.msg-textarea {
    width: 100%;
    background: transparent;
    border: none;
    outline: none;
    color: #d1d7db;
    font-size: 13.5px;
    line-height: 1.5;
    resize: none;
    min-height: 24px;
    max-height: 120px;
    font-family: inherit;
}
.msg-textarea::placeholder { color: #8696a0; }
.icon-btn {
    color: #8696a0;
    cursor: pointer;
    background: none;
    border: none;
    padding: 6px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    transition: color .15s, background .15s;
    flex-shrink: 0;
}
.icon-btn:hover { color: #d1d7db; background: #3a4a52; }

/* ─── Welcome ── */
.welcome-screen {
    flex: 1;
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    color: #8696a0;
    gap: 12px;
    text-align: center;
}

/* ─── Skeleton ── */
.skeleton {
    background: linear-gradient(90deg, #202c33 25%, #2a3942 50%, #202c33 75%);
    background-size: 200% 100%;
    animation: shimmer 1.4s infinite;
    border-radius: 6px;
}
@keyframes shimmer { 0%{background-position:200% 0} 100%{background-position:-200% 0} }

/* ─── Toast ── */
#toast {
    position: fixed;
    bottom: 24px;
    left: 50%;
    transform: translateX(-50%) translateY(20px);
    background: #2a3942;
    color: #d1d7db;
    font-size: 12px;
    padding: 8px 18px;
    border-radius: 8px;
    opacity: 0;
    transition: opacity .25s, transform .25s;
    z-index: 9999;
    pointer-events: none;
}
#toast.show { opacity: 1; transform: translateX(-50%) translateY(0); }
</style>
@endpush

@section('content')
<div class="app-wrapper">

    {{-- ═══════ SIDEBAR ═══════ --}}
    <div class="sidebar">
        <div class="sidebar-topbar">
            <span class="text-sm font-semibold" style="color:#e9edef;">Chats</span>
        </div>

        <div class="sidebar-search">
            <div class="search-wrap">
                <svg class="w-4 h-4 flex-shrink-0" fill="#8696a0" viewBox="0 0 24 24">
                    <path d="M15.5 14h-.79l-.28-.27A6.471 6.471 0 0 0 16 9.5 6.5 6.5 0 1 0 9.5 16c1.61 0 3.09-.59 4.23-1.57l.27.28v.79l5 4.99L20.49 19l-4.99-5zm-6 0C7.01 14 5 11.99 5 9.5S7.01 5 9.5 5 14 7.01 14 9.5 11.99 14 9.5 14z"/>
                </svg>
                <input id="searchInput" class="search-input" placeholder="Search conversations" oninput="applyFilters()"/>
            </div>
        </div>

        <div class="filter-tabs">
            <button class="filter-tab active" onclick="setFilter('all',this)">All</button>
            <button class="filter-tab" onclick="setFilter('unread',this)">Unread</button>
            <button class="filter-tab" onclick="setFilter('groups',this)">Groups</button>
        </div>

        <div id="conversationList">
            @for($i=0;$i<6;$i++)
            <div class="flex items-center gap-3 px-4 py-3">
                <div class="skeleton rounded-full w-12 h-12 flex-shrink-0"></div>
                <div class="flex-1 flex flex-col gap-2">
                    <div class="skeleton h-3 w-28"></div>
                    <div class="skeleton h-3 w-44"></div>
                </div>
            </div>
            @endfor
        </div>
    </div>

    {{-- ═══════ CHAT AREA ═══════ --}}
    <div class="chat-area chat-bg">

        <div class="chat-header" id="chatHeader" style="display:none;">
            <div class="avatar-wrap flex-shrink-0">
                <img id="chatAvatar" src="" class="avatar-img" alt=""/>
                <span id="chatOnlineDot" class="online-dot" style="display:none;"></span>
            </div>
            <div class="flex-1 min-w-0">
                <p id="chatName"   class="text-sm font-semibold" style="color:#e9edef;"></p>
                <p id="chatStatus" class="text-xs mt-0.5"        style="color:#8696a0;"></p>
            </div>
        </div>

        <div class="welcome-screen" id="welcomeScreen">
            <svg class="w-20 h-20" style="opacity:.15;" viewBox="0 0 24 24" fill="#8696a0">
                <path d="M20 2H4c-1.1 0-2 .9-2 2v18l4-4h14c1.1 0 2-.9 2-2V4c0-1.1-.9-2-2-2z"/>
            </svg>
            <p class="text-sm font-medium" style="color:#8696a0;">Select a conversation to start chatting</p>
        </div>

        <div id="messageList" style="display:none; flex-direction:column;"></div>

        <div id="typingWrapper">
            <div class="typing-bubble" id="typingBubble">
                <div class="typing-dot"></div>
                <div class="typing-dot"></div>
                <div class="typing-dot"></div>
            </div>
        </div>

        <div class="input-bar" id="inputBar">
            <div class="input-wrap">
                <textarea class="msg-textarea" id="msgInput" rows="1"
                    placeholder="Type a message"
                    oninput="onInput(this)"
                    onkeydown="handleKey(event)"></textarea>
            </div>
            <button class="icon-btn" onclick="sendMessage()" title="Send">
                <svg id="micIcon" class="w-6 h-6" viewBox="0 0 24 24" fill="currentColor">
                    <path d="M12 14c1.66 0 3-1.34 3-3V5c0-1.66-1.34-3-3-3S9 3.34 9 5v6c0 1.66 1.34 3 3 3zm-1-9c0-.55.45-1 1-1s1 .45 1 1v6c0 .55-.45 1-1 1s-1-.45-1-1V5zm6 6c0 2.76-2.24 5-5 5s-5-2.24-5-5H5c0 3.53 2.61 6.43 6 6.92V21h2v-3.08c3.39-.49 6-3.39 6-6.92h-2z"/>
                </svg>
                <svg id="sendIcon" class="w-6 h-6" style="display:none;" viewBox="0 0 24 24" fill="#00a884">
                    <path d="M2.01 21L23 12 2.01 3 2 10l15 2-15 2z"/>
                </svg>
            </button>
        </div>
    </div>
</div>

<div id="toast"></div>
@endsection

@push('scripts')
{{-- ✅ Must match your Node server version exactly --}}
<script src="https://cdn.socket.io/4.7.5/socket.io.min.js"></script>
<script>
// ═══════════════════════════════════════════════════════════════════════════
// CONFIG — must match your existing Node server (CONFIG object in server.js)
// ═══════════════════════════════════════════════════════════════════════════
const NODE_URL   = 'http://192.168.1.50:3000';   // ← CONFIG.BASE_URL in your server.js
const API_TOKEN  = '{{ session("api_token") ?? auth()->user()->api_token ?? "" }}';
const MY_USER_ID = {{ Auth::id() }};              // Laravel auth user id

// ─── State ────────────────────────────────────────────────────────────────
let currentConvId    = null;
let allConversations = [];
let activeFilter     = 'all';
let typingTimer      = null;
let isTyping         = false;
let msgOffset        = 0;           // for pagination
const MSG_LIMIT      = 30;

// ═══════════════════════════════════════════════════════════════════════════
// SOCKET — connects to YOUR existing Node server with JWT token
// ═══════════════════════════════════════════════════════════════════════════
const socket = io(NODE_URL, {
    auth: { token: API_TOKEN },          // ← your server's io.use() reads this
    transports: ['websocket', 'polling'],
    reconnection: true,
    reconnectionDelay: 1000,
    reconnectionAttempts: 10,
});

socket.on('connect',       () => console.log('🔌 Socket connected:', socket.id));
socket.on('connect_error', e  => console.error('❌ Socket error:', e.message));
socket.on('disconnect',    () => console.log('❌ Socket disconnected'));

// ─── Receive new message ──────────────────────────────────────────────────
// Your server emits: io.to("conv_" + msg.conversation_id).emit("new_message", msg)
socket.on('new_message', msg => {
    if (msg.conversation_id == currentConvId) {
        appendMessage(msg);
        scrollBottom();

        // Mark as read immediately
        socket.emit('mark_read', { conversationId: currentConvId });
    } else {
        bumpUnreadBadge(msg.conversation_id);
        updateSidebarLastMsg(msg.conversation_id, msg.content, msg.message_type);
    }
});

// ─── Typing ───────────────────────────────────────────────────────────────
socket.on('typing_start', ({ conversationId }) => {
    if (conversationId == currentConvId) showTyping(true);
});
socket.on('typing_stop', ({ conversationId }) => {
    if (conversationId == currentConvId) showTyping(false);
});

// ─── Online / offline ─────────────────────────────────────────────────────
socket.on('user_status', ({ userId, isOnline }) => {
    // Update sidebar dot if this user is in current conv
    const conv = allConversations.find(c => c.other_user_id == userId);
    if (conv) {
        const item = document.querySelector(`.chat-item[data-id="${conv.id}"]`);
        item?.querySelector('.online-dot')?.style.setProperty('display', isOnline ? 'block' : 'none');
    }

    // Update header if current chat is with this user
    const curConv = allConversations.find(c => c.id === currentConvId);
    if (curConv?.other_user_id == userId) {
        setHeaderStatus(isOnline ? 'online' : 'last seen recently', isOnline);
    }
});

// ─── Read receipts ────────────────────────────────────────────────────────
socket.on('messages_read', ({ conversationId }) => {
    if (conversationId == currentConvId) {
        // Turn all grey ticks blue
        document.querySelectorAll('.tick-icon').forEach(el => {
            el.style.color = '#53bdeb';
        });
    }
});

// ═══════════════════════════════════════════════════════════════════════════
// BOOT
// ═══════════════════════════════════════════════════════════════════════════
document.addEventListener('DOMContentLoaded', () => {
    loadConversations();
});

// ═══════════════════════════════════════════════════════════════════════════
// CONVERSATIONS — calls Node REST API directly
// GET http://192.168.1.50:3000/api/chat/conversations
// ═══════════════════════════════════════════════════════════════════════════
function loadConversations() {
    fetch(`${NODE_URL}/api/chat/conversations`, {
        headers: { 'Authorization': `Bearer ${API_TOKEN}` }
    })
    .then(r => r.json())
    .then(data => {
        allConversations = data;
        applyFilters();
    })
    .catch(e => {
        console.error('Conversations error:', e);
        document.getElementById('conversationList').innerHTML =
            `<p class="text-xs text-center py-6" style="color:#8696a0;">Failed to load conversations.</p>`;
    });
}

function renderConversations(list) {
    const el = document.getElementById('conversationList');

    if (!list.length) {
        el.innerHTML = `<p class="text-xs text-center py-8" style="color:#8696a0;">No conversations found.</p>`;
        return;
    }

    el.innerHTML = list.map(c => {
        // Your Node API returns: other_user_name, other_user_avatar, other_user_online,
        // last_message, last_message_type, last_message_time, unread_count
        const name      = escHtml(c.name || c.other_user_name || 'Chat');
        const avatar    = c.avatar_url || c.other_user_avatar
                          || `https://ui-avatars.com/api/?name=${encodeURIComponent(name)}&background=2a3942&color=8696a0`;
        const lastMsg   = formatLastMsg(c.last_message, c.last_message_type);
        const lastTime  = formatTime(c.last_message_time);
        const isOnline  = c.other_user_online == 1;

        return `
        <div class="chat-item ${currentConvId === c.id ? 'active' : ''}"
             onclick="openChat(${c.id}, this)"
             data-id="${c.id}">
            <div class="avatar-wrap">
                <img src="${avatar}" class="avatar-img" alt=""
                     onerror="this.src='https://ui-avatars.com/api/?name=U&background=2a3942&color=8696a0'"/>
                ${isOnline ? '<span class="online-dot"></span>' : ''}
            </div>
            <div class="flex-1 min-w-0">
                <div class="flex justify-between items-center">
                    <span class="text-sm font-medium truncate" style="color:#e9edef;">${name}</span>
                    <span class="text-xs flex-shrink-0 ml-2"
                          style="color:${c.unread_count > 0 ? '#00a884' : '#8696a0'};">${lastTime}</span>
                </div>
                <div class="flex justify-between items-center mt-0.5" data-meta>
                    <span class="text-xs truncate" style="color:#8696a0; max-width:200px;">${lastMsg}</span>
                    ${c.unread_count > 0 ? `<span class="unread-badge ml-2">${c.unread_count}</span>` : ''}
                </div>
            </div>
        </div>`;
    }).join('');
}

// ─── Filters ──────────────────────────────────────────────────────────────
function setFilter(filter, btn) {
    activeFilter = filter;
    document.querySelectorAll('.filter-tab').forEach(b => b.classList.remove('active'));
    btn.classList.add('active');
    applyFilters();
}
function applyFilters() {
    const q = (document.getElementById('searchInput').value ?? '').toLowerCase().trim();
    let list = allConversations;
    if (activeFilter === 'unread') list = list.filter(c => c.unread_count > 0);
    if (activeFilter === 'groups') list = list.filter(c => c.type === 'group');
    if (q) list = list.filter(c =>
        (c.other_user_name ?? c.name ?? '').toLowerCase().includes(q) ||
        (c.last_message ?? '').toLowerCase().includes(q)
    );
    renderConversations(list);
}

// ═══════════════════════════════════════════════════════════════════════════
// OPEN CHAT
// GET http://192.168.1.50:3000/api/chat/messages/:id?limit=30&offset=0
// ═══════════════════════════════════════════════════════════════════════════
function openChat(id, el) {
    // Leave previous room
    if (currentConvId && currentConvId !== id) {
        // Your server uses "join" event to enter rooms — just rejoin the new one
    }

    currentConvId = id;
    msgOffset     = 0;

    document.querySelectorAll('.chat-item').forEach(i => i.classList.remove('active'));
    el.classList.add('active');
    el.querySelector('.unread-badge')?.remove();

    document.getElementById('welcomeScreen').style.display = 'none';
    document.getElementById('chatHeader').style.display    = 'flex';
    document.getElementById('messageList').style.display   = 'flex';
    document.getElementById('inputBar').style.display      = 'flex';
    showTyping(false);

    // Header
    const conv = allConversations.find(c => c.id === id);
    const name = conv?.name || conv?.other_user_name || 'Chat';
    document.getElementById('chatName').textContent = name;
    document.getElementById('chatAvatar').src =
        conv?.avatar_url || conv?.other_user_avatar ||
        `https://ui-avatars.com/api/?name=${encodeURIComponent(name)}&background=2a3942&color=8696a0`;
    setHeaderStatus(conv?.other_user_online == 1 ? 'online' : 'last seen recently', conv?.other_user_online == 1);

    // ✅ Join room — your server: socket.on("join", (cid) => socket.join("conv_" + cid))
    socket.emit('join', id);

    // Load messages from Node API
    const msgList = document.getElementById('messageList');
    msgList.innerHTML = `
        <div class="flex flex-col gap-3 py-4 px-2">
            ${Array.from({length:5},(_,i)=>`
                <div class="flex ${i%2===0?'justify-end':'justify-start'}">
                    <div class="skeleton h-8 rounded-lg" style="width:${120+i*30}px;"></div>
                </div>`).join('')}
        </div>`;

    fetch(`${NODE_URL}/api/chat/messages/${id}?limit=${MSG_LIMIT}&offset=0`, {
        headers: { 'Authorization': `Bearer ${API_TOKEN}` }
    })
    .then(r => r.json())
    .then(msgs => {
        msgList.innerHTML = '';

        // Your server returns newest first (ORDER BY id DESC) — reverse for display
        const ordered = [...msgs].reverse();

        if (!ordered.length) {
            msgList.innerHTML = `<p class="text-xs text-center py-8" style="color:#8696a0;">No messages yet. Say hello! 👋</p>`;
        } else {
            ordered.forEach(m => appendMessage(m));
        }

        scrollBottom();

        // Mark as read
        socket.emit('mark_read', { conversationId: id });
    })
    .catch(() => {
        msgList.innerHTML = `<p class="text-xs text-center py-4" style="color:#e85c4a;">Failed to load messages.</p>`;
    });

    document.getElementById('msgInput').focus();
}

// ═══════════════════════════════════════════════════════════════════════════
// APPEND MESSAGE
// Your server message shape:
//   { id, conversation_id, sender_id, content, message_type,
//     file_url, file_name, file_size, duration_sec, status, created_at }
// ═══════════════════════════════════════════════════════════════════════════
function appendMessage(msg) {
    const isMe   = msg.sender_id == MY_USER_ID;
    const list   = document.getElementById('messageList');
    list.querySelector('p')?.remove();   // remove placeholder

    const div = document.createElement('div');
    div.className     = `msg-row ${isMe ? 'me' : 'you'}`;
    div.dataset.msgId = msg.id;

    const isDeleted = !!msg.deleted_at;
    const bubClass  = isMe ? 'bubble-out' : 'bubble-in';
    const extraCls  = isDeleted ? 'msg-deleted' : '';

    let bodyHtml = '';
    if (isDeleted) {
        bodyHtml = `<p class="bubble-text">🚫 This message was deleted</p>`;
    } else if (msg.message_type === 'voice' || msg.message_type === 'audio') {
        bodyHtml = `<audio controls src="${msg.file_url}" style="max-width:200px;"></audio>`;
    } else if (msg.message_type === 'image') {
        bodyHtml = `<img src="${msg.file_url}" style="max-width:220px;border-radius:6px;" alt="image"/>`;
    } else if (msg.file_url) {
        bodyHtml = `
            <a class="bubble-file" href="${msg.file_url}" target="_blank">
                <svg class="w-5 h-5" fill="#8696a0" viewBox="0 0 24 24">
                    <path d="M14 2H6c-1.1 0-2 .9-2 2v16c0 1.1.9 2 2 2h12c1.1 0 2-.9 2-2V8l-6-6zm4 18H6V4h7v5h5v11z"/>
                </svg>
                ${escHtml(msg.file_name ?? 'Download file')}
            </a>`;
    } else {
        bodyHtml = `<p class="bubble-text">${escHtml(msg.content ?? '')}</p>`;
    }

    const time  = formatTime(msg.created_at);
    const ticks = isMe ? `
        <svg class="w-3 h-3 tick-icon flex-shrink-0"
             style="color:${msg.status === 'seen' ? '#53bdeb' : '#8696a0'};"
             viewBox="0 0 16 11" fill="currentColor">
            <path d="M11.071.653a.45.45 0 0 0-.624 0L4.1 7l-2.247-2.247a.45.45 0 0 0-.624.648l2.56 2.56a.45.45 0 0 0 .624 0L11.07 1.3a.45.45 0 0 0 0-.648zm3 0a.45.45 0 0 0-.624 0L7.1 7l-.7-.7-.648.624.7.7a.45.45 0 0 0 .624 0l6.619-6.323a.45.45 0 0 0 0-.648z"/>
        </svg>` : '';

    const actions = !isDeleted ? `
        <div class="bubble-actions">
            <button class="action-btn" onclick="reportMessage(${msg.id},${msg.conversation_id??currentConvId})">🚩</button>
        </div>` : '';

    div.innerHTML = `
        <div class="bubble ${bubClass} ${extraCls}">
            ${bodyHtml}
            <div class="bubble-meta">
                <span class="bubble-time">${time}</span>
                ${ticks}
            </div>
            ${actions}
        </div>`;

    list.appendChild(div);
}

// ═══════════════════════════════════════════════════════════════════════════
// SEND MESSAGE
// Your server: socket.on("send_message", async (data, ack) => ...)
// data shape: { conversationId, content, messageType, fileUrl, fileName, fileSize, durationSec }
// ═══════════════════════════════════════════════════════════════════════════
function sendMessage() {
    const input = document.getElementById('msgInput');
    const text  = input.value.trim();
    if (!text || !currentConvId) return;

    // Optimistic UI
    const tempId = 'tmp-' + Date.now();
    const now    = new Date();
    appendMessage({
        id: tempId,
        conversation_id: currentConvId,
        sender_id:  MY_USER_ID,
        content:    text,
        message_type: 'text',
        status:     'sent',
        created_at: now.toISOString(),
    });
    scrollBottom();

    input.value        = '';
    input.style.height = 'auto';
    toggleSendIcon(false);
    stopTypingSignal();

    // ✅ Emit to YOUR server — it saves to DB + broadcasts
    socket.emit('send_message', {
        conversationId: currentConvId,
        content:        text,
        messageType:    'text',
    }, ack => {
        // Server acknowledges with { ok: true, messageId: ... }
        if (ack?.ok) {
            const tempEl = document.querySelector(`[data-msg-id="${tempId}"]`);
            if (tempEl) tempEl.dataset.msgId = ack.messageId;

            // Update sidebar preview
            updateSidebarLastMsg(currentConvId, text, 'text');
        } else {
            markFailed(tempId);
            showToast('Failed to send.');
        }
    });
}

// ═══════════════════════════════════════════════════════════════════════════
// REPORT — calls Laravel (since report is stored in your Laravel DB)
// ═══════════════════════════════════════════════════════════════════════════
function reportMessage(msgId, convId) {
    fetch(`/company/chat/report/${msgId}`, {
        method: 'POST',
        headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}' }
    })
    .then(r => r.json())
    .then(() => showToast('Message reported.'))
    .catch(() => showToast('Could not report.'));
}

// ─── Helpers ──────────────────────────────────────────────────────────────
function updateSidebarLastMsg(convId, content, type) {
    const conv = allConversations.find(c => c.id == convId);
    if (conv) {
        conv.last_message      = content;
        conv.last_message_type = type;
        conv.last_message_time = new Date().toISOString();
    }
    applyFilters();
}

function bumpUnreadBadge(convId) {
    const item = document.querySelector(`.chat-item[data-id="${convId}"]`);
    if (!item) return;
    let badge = item.querySelector('.unread-badge');
    if (!badge) {
        badge = document.createElement('span');
        badge.className   = 'unread-badge ml-2';
        badge.textContent = '1';
        item.querySelector('[data-meta]')?.appendChild(badge);
    } else {
        badge.textContent = parseInt(badge.textContent || '0') + 1;
    }
}

function markFailed(tempId) {
    const el = document.querySelector(`[data-msg-id="${tempId}"] .bubble-text`);
    if (el) { el.style.opacity = '.4'; el.title = '⚠️ Failed'; }
}

function setHeaderStatus(text, online) {
    document.getElementById('chatStatus').textContent = text;
    document.getElementById('chatStatus').style.color = online ? '#00a884' : '#8696a0';
    document.getElementById('chatOnlineDot').style.display = online ? 'block' : 'none';
}

function formatLastMsg(content, type) {
    if (!content && !type) return '';
    if (type === 'voice' || type === 'audio') return '🎤 Voice message';
    if (type === 'image') return '📷 Image';
    if (type === 'file')  return '📎 File';
    return escHtml(content ?? '');
}

function formatTime(ts) {
    if (!ts) return '';
    const d = new Date(ts);
    if (isNaN(d)) return ts;
    return d.getHours().toString().padStart(2,'0') + ':' + d.getMinutes().toString().padStart(2,'0');
}

// ─── Typing ───────────────────────────────────────────────────────────────
function onInput(el) {
    el.style.height = 'auto';
    el.style.height = Math.min(el.scrollHeight, 120) + 'px';
    const hasText = el.value.trim().length > 0;
    toggleSendIcon(hasText);

    if (hasText && !isTyping && currentConvId) {
        isTyping = true;
        socket.emit('typing_start', { conversationId: currentConvId });
    }
    clearTimeout(typingTimer);
    typingTimer = setTimeout(stopTypingSignal, 2500);
}
function stopTypingSignal() {
    if (isTyping && currentConvId) {
        isTyping = false;
        socket.emit('typing_stop', { conversationId: currentConvId });
    }
    clearTimeout(typingTimer);
}
function handleKey(e) {
    if (e.key === 'Enter' && !e.shiftKey) { e.preventDefault(); sendMessage(); }
}
function toggleSendIcon(show) {
    document.getElementById('micIcon').style.display  = show ? 'none'  : 'block';
    document.getElementById('sendIcon').style.display = show ? 'block' : 'none';
}
function showTyping(visible) {
    document.getElementById('typingWrapper').style.display = visible ? 'block' : 'none';
    document.getElementById('typingBubble').style.display  = visible ? 'flex'  : 'none';
    if (visible) scrollBottom();
}
function scrollBottom() {
    const el = document.getElementById('messageList');
    el.scrollTop = el.scrollHeight;
}
function escHtml(str) {
    if (!str) return '';
    return str.replace(/&/g,'&amp;').replace(/</g,'&lt;').replace(/>/g,'&gt;').replace(/"/g,'&quot;');
}
let toastTimer = null;
function showToast(msg, dur = 3000) {
    const el = document.getElementById('toast');
    el.textContent = msg;
    el.classList.add('show');
    clearTimeout(toastTimer);
    toastTimer = setTimeout(() => el.classList.remove('show'), dur);
}
</script>
@endpush