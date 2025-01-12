@foreach ($comments as $comment)
    <div class="comment-item mb-2">
        <div class="d-flex align-items-start">
            <img src="https://img.myloview.com/stickers/default-avatar-profile-icon-vector-social-media-user-photo-700-205577532.jpg" alt="User Avatar" class="rounded-circle me-3" style="width: 50px; height: 50px;">

            <div>
                <h6><strong>{{ $comment->user->name ?? 'Người dùng' }}</strong></h6>
                <p>{{ $comment->description }}</p>

                @if ($comment->images)
                    <div class="comment-images">
                        @foreach ($comment->images as $imagePath)
                            <img src="{{ asset('storage/' . $imagePath) }}" alt="Bình luận ảnh" class="img-thumbnail me-2" style="width: 100px; height: auto;">
                        @endforeach
                    </div>
                @endif

                <small class="text-muted">{{ $comment->created_at->diffForHumans() }}</small>
            </div>
        </div>
    </div>
    <hr>
@endforeach
