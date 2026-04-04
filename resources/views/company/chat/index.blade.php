@extends('layouts.mobile-layout')
@push('styles')
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600&display=swap" rel="stylesheet" />
    <style>
        ::-webkit-scrollbar { width: 6px; }
        ::-webkit-scrollbar-track { background: transparent; }
        ::-webkit-scrollbar-thumb { background: #374151; border-radius: 4px; }

        .sidebar {
            width: 380px;
            min-width: 380px;
            height: 100vh;
            background: #111b21;
            border-right: 1px solid #222d34;
            display: flex;
            flex-direction: column;
        }

        .chat-area {
            flex: 1;
            display: flex;
            flex-direction: column;
            height: 100vh;
            background: #0b141a;
            position: relative;
        }

        .chat-bg {
            background-color: #0b141a;
            background-image: url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' fill-rule='evenodd'%3E%3Cg fill='%23182229' fill-opacity='0.6'%3E%3Cpath d='M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E");
        }

        .msg-bubble-out {
            background: #005c4b;
            border-radius: 8px 0 8px 8px;
        }

        .msg-bubble-in {
            background: #202c33;
            border-radius: 0 8px 8px 8px;
        }

        .chat-item:hover { background: #202c33; cursor: pointer; }
        .chat-item.active { background: #2a3942; }

        .search-input {
            background: #202c33;
            border: none;
            outline: none;
            color: #d1d7db;
        }
        .search-input::placeholder { color: #8696a0; }

        .input-box {
            background: #202c33;
            border: none;
            outline: none;
            color: #d1d7db;
            resize: none;
        }
        .input-box::placeholder { color: #8696a0; }

        .status-dot {
            width: 10px;
            height: 10px;
            background: #00a884;
            border-radius: 50%;
            border: 2px solid #111b21;
            position: absolute;
            bottom: 0;
            right: 0;
        }

        .icon-btn { color: #8696a0; cursor: pointer; transition: color 0.15s; }
        .icon-btn:hover { color: #d1d7db; }

        .typing-dot {
            width: 7px;
            height: 7px;
            background: #8696a0;
            border-radius: 50%;
            animation: bounce 1.2s infinite;
        }
        .typing-dot:nth-child(2) { animation-delay: 0.2s; }
        .typing-dot:nth-child(3) { animation-delay: 0.4s; }

        @keyframes bounce {
            0%, 80%, 100% { transform: translateY(0); }
            40%            { transform: translateY(-6px); }
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
        }

        .app-wrapper {
            display: flex;
            width: 95%;
            height: 85%;
            overflow: hidden;
        }

        /* Message list scroll area */
        #messageList {
            flex: 1;
            overflow-y: auto;
            padding: 16px 12px;
            display: flex;
            flex-direction: column;
            gap: 2px;
        }

        /* Chat header */
        .chat-header {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 10px 16px;
            background: #202c33;
            min-height: 60px;
            border-bottom: 1px solid #2a3942;
            flex-shrink: 0;
        }

        /* Empty state */
        .welcome-screen {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            flex: 1;
            color: #8696a0;
            gap: 12px;
        }

        /* Skeleton loader for conversation list */
        .skeleton {
            background: linear-gradient(90deg, #202c33 25%, #2a3942 50%, #202c33 75%);
            background-size: 200% 100%;
            animation: shimmer 1.4s infinite;
            border-radius: 6px;
        }
        @keyframes shimmer { 0% { background-position: 200% 0; } 100% { background-position: -200% 0; } }

        /* Reported / deleted message style */
        .msg-deleted { opacity: 0.45; font-style: italic; }
        .msg-reported { border-left: 2px solid #e85c4a; }

        /* Typing indicator bubble */
        #typingIndicator {
            background: #202c33;
            border-radius: 0 8px 8px 8px;
            padding: 10px 14px;
            display: none;
            align-items: center;
            gap: 4px;
            width: fit-content;
        }
    </style>
@endpush

@section('content')
<div class="app-wrapper rounded-lg">

    {{-- ===================== SIDEBAR ===================== --}}
    <div class="sidebar">

        {{-- Top bar --}}
        <div class="flex items-center justify-between px-4 py-3" style="background:#202c33; min-height:60px;">
            <div class="flex justify-right gap-5">
                <a href="#" class="text-xs text-gray-400 hover:text-white transition-colors">
                    <i class="bi bi-plus"></i> New Group
                </a>
                <a href="#" class="text-xs text-gray-400 hover:text-white transition-colors">
                    <i class="bi bi-tag"></i> New Label
                </a>
            </div>
        </div>

        {{-- Search --}}
        <div class="px-3 py-2" style="background:#111b21;">
            <div class="flex items-center gap-2 px-3 py-2 rounded-lg" style="background:#202c33;">
                <svg class="w-4 h-4 flex-shrink-0" fill="#8696a0" viewBox="0 0 24 24">
                    <path d="M15.5 14h-.79l-.28-.27A6.471 6.471 0 0 0 16 9.5 6.5 6.5 0 1 0 9.5 16c1.61 0 3.09-.59 4.23-1.57l.27.28v.79l5 4.99L20.49 19l-4.99-5zm-6 0C7.01 14 5 11.99 5 9.5S7.01 5 9.5 5 14 7.01 14 9.5 11.99 14 9.5 14z"/>
                </svg>
                <input id="searchInput" class="search-input w-full text-sm" placeholder="Search or start new chat"
                       oninput="filterConversations(this.value)" />
            </div>
        </div>

        {{-- Filter tabs --}}
        <div class="flex gap-2 px-3 pb-2" style="background:#111b21;">
            <button onclick="setFilter('all', this)"   class="filter-tab text-xs px-3 py-1 rounded-full font-medium" style="background:#00a884; color:#111b21;">All</button>
            <button onclick="setFilter('unread', this)" class="filter-tab text-xs px-3 py-1 rounded-full font-medium text-gray-400" style="background:#202c33;">Unread</button>
            <button onclick="setFilter('groups', this)" class="filter-tab text-xs px-3 py-1 rounded-full font-medium text-gray-400" style="background:#202c33;">Groups</button>
        </div>

        {{-- Conversation list --}}
        <div class="overflow-y-auto flex-1" id="conversationList">
            {{-- Skeleton placeholders while loading --}}
            @for ($i = 0; $i < 6; $i++)
            <div class="flex items-center gap-3 px-4 py-3">
                <div class="skeleton rounded-full w-12 h-12 flex-shrink-0"></div>
                <div class="flex-1 flex flex-col gap-2">
                    <div class="skeleton h-3 w-32"></div>
                    <div class="skeleton h-3 w-48"></div>
                </div>
            </div>
            @endfor
        </div>
    </div>

    {{-- ===================== CHAT AREA ===================== --}}
    <div class="chat-area chat-bg" id="chatArea">

        {{-- Header (hidden until chat selected) --}}
        <div class="chat-header" id="chatHeader" style="display:none;">
            <div class="relative flex-shrink-0">
                <img id="chatAvatar" src="" class="rounded-full w-10 h-10" alt="" />
                <span id="chatOnlineDot" class="status-dot" style="display:none;"></span>
            </div>
            <div class="flex-1 min-w-0">
                <p id="chatName"   class="text-sm font-semibold" style="color:#e9edef;"></p>
                <p id="chatStatus" class="text-xs"               style="color:#8696a0;"></p>
            </div>
            {{-- Header actions --}}
            <div class="flex gap-4">
                <button class="icon-btn">
                    <svg class="w-5 h-5" viewBox="0 0 24 24" fill="currentColor">
                        <path d="M15.5 14h-.79l-.28-.27A6.471 6.471 0 0 0 16 9.5 6.5 6.5 0 1 0 9.5 16c1.61 0 3.09-.59 4.23-1.57l.27.28v.79l5 4.99L20.49 19l-4.99-5zm-6 0C7.01 14 5 11.99 5 9.5S7.01 5 9.5 5 14 7.01 14 9.5 11.99 14 9.5 14z"/>
                    </svg>
                </button>
                <button class="icon-btn">
                    <svg class="w-5 h-5" viewBox="0 0 24 24" fill="currentColor">
                        <path d="M12 8c1.1 0 2-.9 2-2s-.9-2-2-2-2 .9-2 2 .9 2 2 2zm0 2c-1.1 0-2 .9-2 2s.9 2 2 2 2-.9 2-2-.9-2-2-2zm0 6c-1.1 0-2 .9-2 2s.9 2 2 2 2-.9 2-2-.9-2-2-2z"/>
                    </svg>
                </button>
            </div>
        </div>

        {{-- Welcome / empty state --}}
        <div class="welcome-screen" id="welcomeScreen">
            <svg class="w-16 h-16 opacity-20" viewBox="0 0 24 24" fill="#8696a0">
                <path d="M20 2H4c-1.1 0-2 .9-2 2v18l4-4h14c1.1 0 2-.9 2-2V4c0-1.1-.9-2-2-2z"/>
            </svg>
            <p class="text-sm">Select a conversation to start chatting</p>
        </div>

        {{-- Message list --}}
        <div id="messageList" style="display:none;"></div>

        {{-- Typing indicator --}}
        <div class="px-4 pb-1" id="typingWrapper" style="display:none;">
            <div id="typingIndicator">
                <div class="typing-dot"></div>
                <div class="typing-dot"></div>
                <div class="typing-dot"></div>
            </div>
        </div>

        {{-- Input bar --}}
        <div class="flex items-center gap-3 px-4 py-3 flex-shrink-0" id="inputBar" style="display:none; background:#202c33;">
            <button class="icon-btn flex-shrink-0">
                <svg class="w-6 h-6" viewBox="0 0 24 24" fill="currentColor">
                    <path d="M11.99 2C6.47 2 2 6.48 2 12s4.47 10 9.99 10C17.52 22 22 17.52 22 12S17.52 2 11.99 2zM12 20c-4.42 0-8-3.58-8-8s3.58-8 8-8 8 3.58 8 8-3.58 8-8 8zm3.5-9c.83 0 1.5-.67 1.5-1.5S16.33 8 15.5 8 14 8.67 14 9.5s.67 1.5 1.5 1.5zm-7 0c.83 0 1.5-.67 1.5-1.5S9.33 8 8.5 8 7 8.67 7 9.5 7.67 11 8.5 11zm3.5 6.5c2.33 0 4.31-1.46 5.11-3.5H6.89c.8 2.04 2.78 3.5 5.11 3.5z"/>
                </svg>
            </button>
            <button class="icon-btn flex-shrink-0">
                <svg class="w-6 h-6" viewBox="0 0 24 24" fill="currentColor">
                    <path d="M16.5 6v11.5c0 2.21-1.79 4-4 4s-4-1.79-4-4V5c0-1.38 1.12-2.5 2.5-2.5s2.5 1.12 2.5 2.5v10.5c0 .55-.45 1-1 1s-1-.45-1-1V6H10v9.5c0 1.38 1.12 2.5 2.5 2.5s2.5-1.12 2.5-2.5V5c0-2.21-1.79-4-4-4S7 2.79 7 5v12.5c0 3.04 2.46 5.5 5.5 5.5s5.5-2.46 5.5-5.5V6h-1.5z"/>
                </svg>
            </button>
            <div class="flex-1 rounded-lg px-4 py-2" style="background:#2a3942;">
                <textarea class="input-box w-full text-sm leading-relaxed"
                    style="background:transparent; max-height:120px; min-height:24px; line-height:1.5;"
                    rows="1"
                    placeholder="Type a message"
                    id="msgInput"
                    oninput="autoResize(this); handleTyping();"
                    onkeydown="handleKey(event)"></textarea>
            </div>
            <button class="icon-btn flex-shrink-0" id="sendBtn" onclick="sendMessage()">
                <svg id="micIcon" class="w-6 h-6" viewBox="0 0 24 24" fill="currentColor">
                    <path d="M12 14c1.66 0 3-1.34 3-3V5c0-1.66-1.34-3-3-3S9 3.34 9 5v6c0 1.66 1.34 3 3 3zm-1-9c0-.55.45-1 1-1s1 .45 1 1v6c0 .55-.45 1-1 1s-1-.45-1-1V5zm6 6c0 2.76-2.24 5-5 5s-5-2.24-5-5H5c0 3.53 2.61 6.43 6 6.92V21h2v-3.08c3.39-.49 6-3.39 6-6.92h-2z"/>
                </svg>
                <svg id="sendIcon" class="w-6 h-6 hidden" viewBox="0 0 24 24" fill="currentColor">
                    <path d="M2.01 21L23 12 2.01 3 2 10l15 2-15 2z"/>
                </svg>
            </button>
        </div>

    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdn.socket.io/4.0.0/socket.io.min.js"></script>
<script>
// ─── State ───────────────────────────────────────────────────────────────────
let currentConversation = null;
let allConversations    = [];
let activeFilter        = 'all';
const ADMIN_ID          = {{ Auth::id() }};
const socket            = io("http://localhost:3000");

// ─── Boot ─────────────────────────────────────────────────────────────────────
document.addEventListener('DOMContentLoaded', () => {
    loadConversations();
});

// ─── Conversations ────────────────────────────────────────────────────────────
function loadConversations() {
    fetch('/company/chat/conversations')
        .then(res => res.json())
        .then(data => {
            allConversations = data;
            renderConversations(data);
        })
        .catch(() => {
            document.getElementById('conversationList').innerHTML =
                `<p class="text-xs text-center text-gray-500 py-6">Failed to load conversations.</p>`;
        });
}

function renderConversations(list) {
    const container = document.getElementById('conversationList');

    if (!list.length) {
        container.innerHTML = `<p class="text-xs text-center py-6" style="color:#8696a0;">No conversations found.</p>`;
        return;
    }

    container.innerHTML = list.map(c => `
        <div class="chat-item flex items-center gap-3 px-4 py-3 ${currentConversation === c.id ? 'active' : ''}"
             onclick="openChat(${c.id}, this)"
             data-id="${c.id}"
             data-name="${escapeHtml(c.name)}"
             data-unread="${c.unread_count}">
            <div class="relative flex-shrink-0">
                <img src="${c.avatar ?? 'https://i.pravatar.cc/40?u=' + c.id}"
                     class="rounded-full w-12 h-12" alt="" />
            </div>
            <div class="flex-1 min-w-0">
                <div class="flex justify-between items-center">
                    <span class="text-sm font-medium" style="color:#e9edef;">${escapeHtml(c.name)}</span>
                    <span class="text-xs" style="color:${c.unread_count > 0 ? '#00a884' : '#8696a0'};">${c.last_time}</span>
                </div>
                <div class="flex justify-between items-center mt-0.5">
                    <span class="text-xs truncate" style="color:#8696a0; max-width:200px;">${escapeHtml(c.last_message)}</span>
                    ${c.unread_count > 0
                        ? `<span class="unread-badge">${c.unread_count}</span>`
                        : ''}
                </div>
            </div>
        </div>
    `).join('');
}

// ─── Filter & Search ──────────────────────────────────────────────────────────
function setFilter(filter, btn) {
    activeFilter = filter;

    document.querySelectorAll('.filter-tab').forEach(b => {
        b.style.background = '#202c33';
        b.style.color      = '#9ca3af';
    });
    btn.style.background = '#00a884';
    btn.style.color      = '#111b21';

    applyFilters();
}

function filterConversations(query) {
    applyFilters(query);
}

function applyFilters(query = document.getElementById('searchInput').value) {
    let filtered = allConversations;

    if (activeFilter === 'unread') {
        filtered = filtered.filter(c => c.unread_count > 0);
    } else if (activeFilter === 'groups') {
        filtered = filtered.filter(c => c.is_group);
    }

    if (query.trim()) {
        const q = query.toLowerCase();
        filtered = filtered.filter(c =>
            c.name.toLowerCase().includes(q) ||
            c.last_message.toLowerCase().includes(q)
        );
    }

    renderConversations(filtered);
}

// ─── Open Chat ────────────────────────────────────────────────────────────────
function openChat(id, el) {
    if (currentConversation === id) return;
    currentConversation = id;

    // Highlight active item
    document.querySelectorAll('.chat-item').forEach(i => i.classList.remove('active'));
    el.classList.add('active');

    // Clear unread badge on this item
    const badge = el.querySelector('.unread-badge');
    if (badge) badge.remove();

    // Show header + input, hide welcome
    document.getElementById('welcomeScreen').style.display = 'none';
    document.getElementById('chatHeader').style.display    = 'flex';
    document.getElementById('messageList').style.display   = 'flex';
    document.getElementById('inputBar').style.display      = 'flex';
    document.getElementById('typingWrapper').style.display = 'none';

    // Update header info
    const conv = allConversations.find(c => c.id === id);
    document.getElementById('chatName').textContent   = conv?.name   ?? 'Chat';
    document.getElementById('chatAvatar').src         = conv?.avatar ?? `https://i.pravatar.cc/40?u=${id}`;
    document.getElementById('chatStatus').textContent = 'loading…';

    // Load messages
    const list = document.getElementById('messageList');
    list.innerHTML = `<div class="flex justify-center py-4">
        <div class="skeleton h-3 w-24 rounded"></div>
    </div>`;

    fetch(`/company/chat/messages/${id}`)
        .then(res => res.json())
        .then(data => {
            list.innerHTML = '';
            if (!data.length) {
                list.innerHTML = `<p class="text-xs text-center py-6" style="color:#8696a0;">No messages yet.</p>`;
            } else {
                data.forEach(m => renderMessage(m));
            }
            document.getElementById('chatStatus').textContent = 'online';
            document.getElementById('chatStatus').style.color = '#00a884';
            list.scrollTop = list.scrollHeight;
        })
        .catch(() => {
            list.innerHTML = `<p class="text-xs text-center py-4 text-red-400">Failed to load messages.</p>`;
        });

    // Focus input
    document.getElementById('msgInput').focus();
}

// ─── Render a single message ──────────────────────────────────────────────────
function renderMessage(msg) {
    const isMe = msg.sender_id == ADMIN_ID;
    const list = document.getElementById('messageList');

    const div = document.createElement('div');
    div.className = `flex ${isMe ? 'justify-end' : 'justify-start'} mb-1`;
    div.dataset.msgId = msg.id;

    const bubbleClass = isMe ? 'msg-bubble-out' : 'msg-bubble-in';
    const extraClass  = msg.is_deleted ? 'msg-deleted' : (msg.reported ? 'msg-reported' : '');
    const content     = msg.is_deleted ? '🚫 Message deleted' : escapeHtml(msg.content);

    div.innerHTML = `
        <div class="${bubbleClass} ${extraClass} px-3 py-2 max-w-xs group relative" style="min-width:80px;">
            <p class="text-sm" style="color:#e9edef;">${content}</p>
            <div class="flex items-center ${isMe ? 'justify-end' : 'justify-start'} gap-1 mt-1">
                <span class="text-xs" style="color:#8696a0;">${msg.created_at}</span>
                ${isMe ? `<svg class="w-3 h-3" style="color:#53bdeb;" viewBox="0 0 16 11" fill="currentColor">
                    <path d="M11.071.653a.45.45 0 0 0-.624 0L4.1 7l-2.247-2.247a.45.45 0 0 0-.624.648l2.56 2.56a.45.45 0 0 0 .624 0L11.07 1.3a.45.45 0 0 0 0-.648zm3 0a.45.45 0 0 0-.624 0L7.1 7l-.7-.7-.648.624.7.7a.45.45 0 0 0 .624 0l6.619-6.323a.45.45 0 0 0 0-.648z"/>
                </svg>` : ''}
            </div>
            ${!msg.is_deleted ? `
            <div class="absolute ${isMe ? 'left-0 -translate-x-full pl-0 pr-2' : 'right-0 translate-x-full pl-2'} top-1
                        opacity-0 group-hover:opacity-100 transition-opacity flex gap-1">
                <button onclick="deleteMessage(${msg.id}, this)" title="Delete"
                        class="text-xs px-1.5 py-0.5 rounded" style="background:#2a3942; color:#8696a0;">🗑</button>
                <button onclick="reportMessage(${msg.id}, this)" title="Report"
                        class="text-xs px-1.5 py-0.5 rounded" style="background:#2a3942; color:#8696a0;">🚩</button>
            </div>` : ''}
        </div>`;

    list.appendChild(div);
}

// ─── Send Message ─────────────────────────────────────────────────────────────
function sendMessage() {
    const inp  = document.getElementById('msgInput');
    const text = inp.value.trim();
    if (!text || !currentConversation) return;

    // Optimistic render
    const tempId = 'temp-' + Date.now();
    const now    = new Date();
    const time   = now.getHours().toString().padStart(2, '0') + ':' + now.getMinutes().toString().padStart(2, '0');

    renderMessage({
        id: tempId, content: text, sender_id: ADMIN_ID,
        created_at: time, is_deleted: false, reported: false,
    });

    inp.value        = '';
    inp.style.height = 'auto';
    document.getElementById('micIcon').classList.remove('hidden');
    document.getElementById('sendIcon').classList.add('hidden');
    document.getElementById('messageList').scrollTop = document.getElementById('messageList').scrollHeight;

    // Persist via API
    fetch('/company/chat/send', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        },
        body: JSON.stringify({ conversation_id: currentConversation, content: text })
    })
    .then(res => res.json())
    .then(saved => {
        // Swap temp element with real id
        const tempEl = document.querySelector(`[data-msg-id="${tempId}"]`);
        if (tempEl) tempEl.dataset.msgId = saved.id;
    })
    .catch(() => {
        // Mark optimistic message as failed
        const tempEl = document.querySelector(`[data-msg-id="${tempId}"]`);
        if (tempEl) {
            tempEl.querySelector('p').style.opacity = '0.4';
            tempEl.querySelector('p').title = 'Failed to send';
        }
    });

    // Also emit to socket
    socket.emit('send_message', {
        conversationId: currentConversation,
        content: text,
        messageType: 'text',
    });
}

// ─── Delete / Report ──────────────────────────────────────────────────────────
function deleteMessage(id, btn) {
    if (!confirm('Delete this message?')) return;

    fetch(`/company/chat/delete/${id}`, {
        method: 'POST',
        headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}' }
    }).then(() => {
        const row = document.querySelector(`[data-msg-id="${id}"]`);
        if (row) {
            row.querySelector('p').textContent = '🚫 Message deleted';
            row.querySelector('p').classList.add('msg-deleted');
            row.querySelector('.group > div:last-child')?.remove(); // hide action buttons
        }
    });
}

function reportMessage(id, btn) {
    fetch(`/company/chat/report/${id}`, {
        method: 'POST',
        headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}' }
    }).then(() => {
        btn.textContent = '✓';
        btn.disabled    = true;
        const bubble = document.querySelector(`[data-msg-id="${id}"] > div`);
        if (bubble) bubble.classList.add('msg-reported');
    });
}

// ─── Input helpers ────────────────────────────────────────────────────────────
function autoResize(el) {
    el.style.height = 'auto';
    el.style.height = Math.min(el.scrollHeight, 120) + 'px';
}

function handleTyping() {
    const val = document.getElementById('msgInput').value.trim();
    document.getElementById('micIcon').classList.toggle('hidden', val.length > 0);
    document.getElementById('sendIcon').classList.toggle('hidden', val.length === 0);
}

function handleKey(e) {
    if (e.key === 'Enter' && !e.shiftKey) {
        e.preventDefault();
        sendMessage();
    }
}

function escapeHtml(str) {
    if (!str) return '';
    return str.replace(/&/g,'&amp;').replace(/</g,'&lt;').replace(/>/g,'&gt;');
}

// ─── Socket.IO ────────────────────────────────────────────────────────────────
socket.on('new_message', msg => {
    if (msg.conversationId == currentConversation) {
        renderMessage({
            id:         msg.id,
            content:    msg.content,
            sender_id:  msg.sender_id,
            created_at: msg.created_at ?? new Date().toLocaleTimeString([], { hour:'2-digit', minute:'2-digit' }),
            is_deleted: false,
            reported:   false,
        });
        document.getElementById('messageList').scrollTop = document.getElementById('messageList').scrollHeight;
    } else {
        // Bump unread badge on the sidebar item
        const item = document.querySelector(`.chat-item[data-id="${msg.conversationId}"]`);
        if (item) {
            let badge = item.querySelector('.unread-badge');
            if (!badge) {
                badge = document.createElement('span');
                badge.className = 'unread-badge';
                badge.textContent = '1';
                item.querySelector('.flex.justify-between.items-center.mt-0\\.5')?.appendChild(badge);
            } else {
                badge.textContent = parseInt(badge.textContent || '0') + 1;
            }
        }
        // Refresh conversation list to update last_message preview
        loadConversations();
    }
});

socket.on('typing_start', data => {
    if (data?.conversationId == currentConversation) {
        document.getElementById('typingWrapper').style.display = 'block';
        document.getElementById('typingIndicator').style.display = 'flex';
        document.getElementById('messageList').scrollTop = document.getElementById('messageList').scrollHeight;
    }
});

socket.on('typing_stop', data => {
    if (data?.conversationId == currentConversation) {
        document.getElementById('typingWrapper').style.display = 'none';
        document.getElementById('typingIndicator').style.display = 'none';
    }
});

socket.on('user_status', data => {
    if (data?.conversationId == currentConversation) {
        const statusEl = document.getElementById('chatStatus');
        const dotEl    = document.getElementById('chatOnlineDot');
        if (data.status === 'online') {
            statusEl.textContent  = 'online';
            statusEl.style.color  = '#00a884';
            dotEl.style.display   = 'block';
        } else {
            statusEl.textContent  = 'last seen recently';
            statusEl.style.color  = '#8696a0';
            dotEl.style.display   = 'none';
        }
    }
});
</script>
@endpush
