<div>
    @if ($selected_conversation)
        <form wire:submit.prevent="sendmessage">
            <div class="main-chat-footer">
                <input class="form-control" wire:model="body" placeholder="Type your message here..." type="text">
                <button class="main-msg-send btn btn-link text-primary" type="submit"><i
                        class="far fa-paper-plane"></i></button>
            </div>
        </form>
    @endif
</div>
