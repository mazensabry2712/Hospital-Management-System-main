<div>
    <div class="main-chat-list" id="ChatList">
        @foreach ($conversations as $conversation)
            <div class="media new"
                wire:click = "chatuserselected({{ $conversation }},'{{ $this->getUsers($conversation, 'id') }}')">
                <div class="media-body">
                    <div class="media-contact-name">
                        <span>{{ $this->getUsers($conversation, 'name') }}</span>
                        <span>{{ $conversation->messages->last()->created_at->shortAbsoluteDiffForHumans() }}</span>
                    </div>
                    <p>{{ $conversation->messages->last()->body }}</p>
                </div>
            </div>
        @endforeach
    </div><!-- main-chat-list -->
</div>
