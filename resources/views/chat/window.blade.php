<div class="chat-fixed-container" id="chat-fixed-container">
    <div class="chat-header-minimized" id="chat-header-minimized" onclick="toggleChatBox()">Chat</div>

    <div class="chat-wrapper" id="chat-wrapper">
        <div class="chat-friend-panel">
            <div class="chat-toggle-friends" onclick="toggleFriendList()">
                <span>Friends</span>
                <span class="chat-toggle-arrow" id="chat-toggle-arrow">&#9654;</span>
            </div>

            <div class="chat-friend-list" id="chat-friend-list">
                <input type="text" class="chat-friend-search" placeholder="Search friends..." onkeyup="filterFriendList(this.value)">
                <div class="chat-friend-items" id="chat-friend-items">
                    @foreach ($friends as $f)
                        <div class="chat-friend-card" onclick="openChat({{ $f->id }})">
                            <img src="{{ asset('storage/' . ($f->profile_picture ?? 'profile_pictures/defaultpfp.jpg')) }}" class="chat-friends-avatar">
                            <span class="chat-friend-name-list">{{ $f->name }}</span>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>

        <div class="chat-container">
            <div class="chat-header" onclick="toggleChatBox()">
                @if($friend)
                    <div class="chat-friend-avatar">
                        <img src="{{ asset('storage/' . ($friend->profile_picture ?? 'profile_pictures/defaultpfp.jpg')) }}" alt="Profile Picture" class="friends-avatar">
                    </div>
                    <div class="chat-friend-name">{{ $friend->name }}</div>
                @else
                    <div class="chat-friend-name">Choose a friend to chat</div>
                @endif
            </div>

            <div class="chat-body" id="chat-body">
                <div class="chat-messages" id="chat-messages">
                    @foreach ($messages as $message)
                        <div class="chat-message {{ $message->sender_id === auth()->id() ? 'chat-message-outgoing' : 'chat-message-incoming' }}">
                            <div class="chat-message-body">
                                <p>{{ $message->message }}</p>
                                <span class="chat-timestamp">{{ $message->created_at->format('H:i') }}</span>
                            </div>
                        </div>
                    @endforeach
                </div>

                <form class="chat-form" id="chat-form">
                    @csrf
                    <input type="text" name="message" placeholder="Type a message..." class="chat-input" required>
                    <button type="submit" class="chat-send-button">Send</button>
                </form>
            </div>
        </div>
    </div>
</div>



<script>
    let isChatVisible = true;

    function toggleChatBox() {
        const chatWrapper = document.getElementById('chat-wrapper');
        const minimizedHeader = document.getElementById('chat-header-minimized');

        isChatVisible = !isChatVisible;

        if (isChatVisible) {
            chatWrapper.style.display = 'flex';
            minimizedHeader.style.display = 'none';
        } else {
            chatWrapper.style.display = 'none';
            minimizedHeader.style.display = 'block';
        }
    }

    function toggleFriendList() {
        const list = document.getElementById('chat-friend-list');
        const arrow = document.getElementById('chat-toggle-arrow');
        if (list.style.display === "none") {
            list.style.display = "block";
            arrow.style.transform = "rotate(90deg)";
        } else {
            list.style.display = "none";
            arrow.style.transform = "rotate(0deg)";
        }
    }

    document.addEventListener('DOMContentLoaded', () => {
        toggleChatBox();
    });
</script>
