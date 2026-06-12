@extends('public.layouts.app')

@section('title', $post->title . ' - ' . \App\Services\SettingsService::get('site_name', 'Debesties CMS'))

@section('styles')
<style>
    .article-container {
        max-width: 760px;
        margin: 0 auto;
    }

    .article-header {
        text-align: center;
        margin-bottom: 2.5rem;
    }

    .article-category {
        font-family: 'Space Mono', monospace;
        font-size: 0.85rem;
        font-weight: 700;
        text-transform: uppercase;
        color: var(--accent-gold);
        letter-spacing: 1.5px;
        margin-bottom: 0.8rem;
        display: inline-block;
    }

    .article-title {
        font-size: 2.8rem;
        color: var(--text-color);
        margin-bottom: 1rem;
        line-height: 1.15;
    }

    .article-subtitle {
        font-family: 'Outfit', sans-serif;
        font-size: 1.25rem;
        color: var(--text-muted);
        margin-bottom: 1.5rem;
        font-weight: 300;
        line-height: 1.4;
    }

    .article-meta {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 1.5rem;
        font-size: 0.9rem;
        color: var(--text-muted);
    }

    .meta-item {
        display: flex;
        align-items: center;
        gap: 0.4rem;
    }

    .featured-image-wrapper {
        width: 100%;
        margin-bottom: 3rem;
        border-radius: var(--radius-lg);
        overflow: hidden;
        box-shadow: var(--shadow-md);
        background: linear-gradient(135deg, #1A5C2E, #E8A800);
        min-height: 250px;
    }

    .featured-image-wrapper img {
        width: 100%;
        height: auto;
        display: block;
    }

    .article-body {
        font-size: 1.125rem;
        line-height: 1.85;
        color: #2C2520;
        font-weight: 400;
        margin-bottom: 3.5rem;
    }

    .article-body p {
        margin-bottom: 1.6rem;
    }

    .article-body p:first-of-type::first-letter {
        font-family: 'Playfair Display', Georgia, serif;
        font-size: 3.5rem;
        float: left;
        line-height: 0.9;
        margin-right: 0.5rem;
        margin-top: 0.2rem;
        font-weight: 700;
        color: var(--accent-green);
    }

    .article-body blockquote {
        font-family: 'Playfair Display', Georgia, serif;
        font-size: 1.4rem;
        font-style: italic;
        line-height: 1.6;
        color: var(--accent-green);
        border-left: 3px solid var(--accent-gold);
        padding-left: 1.5rem;
        margin: 2.5rem 0;
    }

    .article-body h2 {
        font-size: 1.8rem;
        margin: 2.5rem 0 1.2rem;
    }

    .article-body h3 {
        font-size: 1.4rem;
        margin: 2rem 0 1rem;
    }

    /* Tag Pills */
    .tags-container {
        display: flex;
        flex-wrap: wrap;
        gap: 0.6rem;
        margin-bottom: 3.5rem;
        border-bottom: 1px solid var(--border-color);
        padding-bottom: 2rem;
    }

    .tag-badge {
        font-size: 0.85rem;
        padding: 0.35rem 0.9rem;
        border-radius: 15px;
        background-color: var(--card-bg);
        border: 1px solid var(--border-color);
        color: var(--text-muted);
        font-weight: 500;
    }

    .tag-badge:hover {
        background-color: var(--accent-green);
        color: #FFFFFF;
        border-color: var(--accent-green);
    }

    /* Author Bio Card */
    .author-card {
        background-color: #F0EDE6;
        border-radius: var(--radius-lg);
        padding: 2rem;
        display: flex;
        align-items: center;
        gap: 1.5rem;
        margin-bottom: 4rem;
    }

    .author-card-avatar {
        width: 72px;
        height: 72px;
        border-radius: 50%;
        object-fit: cover;
        flex-shrink: 0;
        background-color: var(--border-color);
    }

    .author-card-info h5 {
        font-size: 1.2rem;
        margin-bottom: 0.4rem;
    }

    .author-card-info p {
        font-size: 0.95rem;
        color: var(--text-muted);
        line-height: 1.5;
    }

    /* Comments Section */
    .comments-section {
        border-top: 1px solid var(--border-color);
        padding-top: 3.5rem;
    }

    .comments-title {
        font-size: 1.6rem;
        margin-bottom: 2rem;
        display: flex;
        align-items: center;
        justify-content: space-between;
    }

    .comments-count-badge {
        font-family: 'Space Mono', monospace;
        font-size: 0.85rem;
        padding: 0.2rem 0.6rem;
        background-color: var(--accent-green);
        color: #FFFFFF;
        border-radius: 4px;
    }

    .comment-form-wrapper {
        background-color: var(--card-bg);
        border: 1px solid var(--border-color);
        border-radius: var(--radius-lg);
        padding: 1.5rem;
        margin-bottom: 3rem;
    }

    .comment-form-title {
        font-size: 1.1rem;
        font-weight: 600;
        margin-bottom: 1rem;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .comment-textarea {
        font-family: 'Outfit', sans-serif;
        font-size: 0.95rem;
        width: 100%;
        min-height: 100px;
        padding: 1rem;
        border: 1px solid var(--border-color);
        border-radius: var(--radius-md);
        background-color: var(--bg-color);
        outline: none;
        resize: vertical;
        margin-bottom: 1rem;
        transition: border-color 0.2s ease;
    }

    .comment-textarea:focus {
        border-color: var(--accent-gold);
    }

    .comments-list {
        display: flex;
        flex-direction: column;
        gap: 2rem;
    }

    .comment-item {
        display: flex;
        gap: 1rem;
    }

    .comment-avatar {
        width: 44px;
        height: 44px;
        border-radius: 50%;
        object-fit: cover;
        flex-shrink: 0;
        background-color: var(--border-color);
    }

    .comment-bubble {
        background-color: var(--card-bg);
        border: 1px solid var(--border-color);
        border-radius: var(--radius-md);
        padding: 1.2rem;
        flex-grow: 1;
        position: relative;
    }

    .comment-meta {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 0.5rem;
        font-size: 0.85rem;
    }

    .comment-author-name {
        font-weight: 600;
    }

    .comment-date {
        font-family: 'Space Mono', monospace;
        color: var(--text-muted);
    }

    .comment-content {
        font-size: 0.95rem;
        color: var(--text-color);
        white-space: pre-wrap;
    }

    .comment-actions {
        display: flex;
        justify-content: flex-end;
        margin-top: 0.5rem;
    }

    .btn-reply {
        background: none;
        border: none;
        color: var(--accent-green);
        font-size: 0.85rem;
        font-weight: 600;
        cursor: pointer;
        display: flex;
        align-items: center;
        gap: 0.2rem;
    }

    .btn-reply:hover {
        color: var(--accent-green-hover);
        text-decoration: underline;
    }

    /* Nesting */
    .comment-replies-list {
        margin-left: 3rem;
        border-left: 2px solid var(--border-color);
        padding-left: 1.5rem;
        display: flex;
        flex-direction: column;
        gap: 1.5rem;
        margin-top: 1.5rem;
    }

    .reply-form-container {
        margin-top: 1rem;
        border-top: 1px dashed var(--border-color);
        padding-top: 1rem;
    }

    @media (max-width: 768px) {
        .article-title {
            font-size: 2.2rem;
        }

        .author-card {
            flex-direction: column;
            text-align: center;
        }

        .comment-replies-list {
            margin-left: 1.5rem;
            padding-left: 1rem;
        }
    }
</style>
@endsection

@section('content')

    <div class="article-container">
        
        <!-- Article Header -->
        <header class="article-header">
            @if($post->category)
                <a href="{{ route('categories.show', $post->category->slug) }}" class="article-category">{{ $post->category->name }}</a>
            @endif
            
            <h1 class="article-title">{{ $post->title }}</h1>
            
            @if($post->subtitle)
                <p class="article-subtitle">{{ $post->subtitle }}</p>
            @endif

            <div class="article-meta">
                <div class="meta-item">
                    @if($post->user && $post->user->avatar)
                        <img src="{{ $post->user->avatar }}" alt="{{ $post->user->name }}" style="width: 24px; height: 24px; border-radius: 50%;">
                    @endif
                    @if($post->user)
                        <a href="{{ route('authors.show', $post->user->slug) }}" style="font-weight: 600;">{{ $post->user->name }}</a>
                    @else
                        <span>Editor</span>
                    @endif
                </div>
                <div class="meta-item" style="font-family: 'Space Mono', monospace;">
                    {{ $post->published_at ? $post->published_at->format('M d, Y') : $post->created_at->format('M d, Y') }}
                </div>
                <div class="meta-item" style="font-family: 'Space Mono', monospace;">
                    <span>{{ $post->view_count }} views</span>
                </div>
            </div>
        </header>

        <!-- Featured Image -->
        @if($post->featuredImage)
            <div class="featured-image-wrapper">
                <img src="{{ $post->featuredImage->file_url }}" alt="{{ $post->title }}">
            </div>
        @endif

        <!-- Article Body -->
        <article class="article-body">
            {!! $post->body !!}
        </article>

        <!-- Tag Pills -->
        @if($post->tags->count() > 0)
            <div class="tags-container">
                @foreach($post->tags as $tag)
                    <a href="{{ route('tags.show', $tag->slug) }}" class="tag-badge">#{{ $tag->name }}</a>
                @endforeach
            </div>
        @endif

        <!-- Author Card -->
        @if($post->user)
            <div class="author-card">
                @if($post->user->avatar)
                    <img src="{{ $post->user->avatar }}" alt="{{ $post->user->name }}" class="author-card-avatar">
                @else
                    <div class="author-card-avatar" style="display: flex; align-items: center; justify-content: center; background-color: var(--accent-green); color: white; font-weight: bold; font-size: 1.5rem;">
                        {{ substr($post->user->name, 0, 1) }}
                    </div>
                @endif
                <div class="author-card-info">
                    <h5>
                        <a href="{{ route('authors.show', $post->user->slug) }}">{{ $post->user->name }}</a>
                    </h5>
                    <p>{{ $post->user->bio ?: 'Contributor and editorial writer for Debesties.' }}</p>
                </div>
            </div>
        @endif

        <!-- Comments Section -->
        <section class="comments-section" id="comments">
            <h3 class="comments-title">
                Discussion
                <span class="comments-count-badge">{{ $comments->count() }} comments</span>
            </h3>

            <!-- New Comment Form -->
            <div class="comment-form-wrapper">
                @auth
                    <form action="{{ route('posts.comments.store', $post->id) }}" method="POST">
                        @csrf
                        <div class="comment-form-title">
                            Share your thoughts as <span>{{ Auth::user()->name }}</span>
                        </div>
                        <textarea name="body" placeholder="Write a comment..." class="comment-textarea" required minlength="2"></textarea>
                        <button type="submit" class="btn btn-green">Post Comment</button>
                    </form>
                @else
                    <div style="text-align: center; padding: 1rem 0;">
                        <p style="color: var(--text-muted); margin-bottom: 1rem;">You must be logged in to write a comment.</p>
                        <a href="{{ route('login') }}" class="btn btn-outline" style="margin-right: 0.5rem;">Log In</a>
                        <a href="{{ route('register') }}" class="btn btn-gold">Sign Up</a>
                    </div>
                @endauth
            </div>

            <!-- Comments List -->
            @if($comments->count() > 0)
                <div class="comments-list">
                    @foreach($comments as $comment)
                        <div class="comment-block">
                            <!-- Top-Level Comment -->
                            <div class="comment-item">
                                @if($comment->user && $comment->user->avatar)
                                    <img src="{{ $comment->user->avatar }}" alt="{{ $comment->name }}" class="comment-avatar">
                                @else
                                    <div class="comment-avatar" style="display: flex; align-items: center; justify-content: center; background-color: var(--accent-gold); color: white; font-weight: bold; font-size: 1rem;">
                                        {{ substr($comment->name, 0, 1) }}
                                    </div>
                                @endif
                                <div class="comment-bubble">
                                    <div class="comment-meta">
                                        <span class="comment-author-name">{{ $comment->name }}</span>
                                        <span class="comment-date">{{ $comment->created_at->diffForHumans() }}</span>
                                    </div>
                                    <div class="comment-content">{{ $comment->comment }}</div>
                                    
                                    @auth
                                        <div class="comment-actions">
                                            <button type="button" onclick="toggleReplyForm({{ $comment->id }})" class="btn-reply">
                                                <svg width="12" height="12" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M3 10h10a8 8 0 018 8v2M3 10l6 6m-6-6l6-6"/></svg>
                                                Reply
                                            </button>
                                        </div>

                                        <!-- Reply Form -->
                                        <div class="reply-form-container" id="reply-form-{{ $comment->id }}" style="display: none;">
                                            <form action="{{ route('posts.comments.store', $post->id) }}" method="POST">
                                                @csrf
                                                <input type="hidden" name="parent_id" value="{{ $comment->id }}">
                                                <textarea name="body" placeholder="Reply to {{ $comment->name }}..." class="comment-textarea" style="min-height: 70px;" required minlength="2"></textarea>
                                                <div style="display: flex; gap: 0.5rem; justify-content: flex-end;">
                                                    <button type="button" onclick="toggleReplyForm({{ $comment->id }})" class="btn btn-outline" style="padding: 0.35rem 0.8rem; font-size: 0.8rem; border-radius: 15px;">Cancel</button>
                                                    <button type="submit" class="btn btn-green" style="padding: 0.35rem 0.8rem; font-size: 0.8rem; border-radius: 15px;">Submit Reply</button>
                                                </div>
                                            </form>
                                        </div>
                                    @endauth
                                </div>
                            </div>

                            <!-- Replies List -->
                            @if($comment->children->count() > 0)
                                <div class="comment-replies-list">
                                    @foreach($comment->children as $reply)
                                        <div class="comment-item">
                                            @if($reply->user && $reply->user->avatar)
                                                <img src="{{ $reply->user->avatar }}" alt="{{ $reply->name }}" class="comment-avatar" style="width: 36px; height: 36px;">
                                            @else
                                                <div class="comment-avatar" style="width: 36px; height: 36px; display: flex; align-items: center; justify-content: center; background-color: var(--accent-gold); color: white; font-weight: bold; font-size: 0.9rem;">
                                                    {{ substr($reply->name, 0, 1) }}
                                                </div>
                                            @endif
                                            <div class="comment-bubble" style="padding: 1rem;">
                                                <div class="comment-meta">
                                                    <span class="comment-author-name">{{ $reply->name }}</span>
                                                    <span class="comment-date">{{ $reply->created_at->diffForHumans() }}</span>
                                                </div>
                                                <div class="comment-content" style="font-size: 0.9rem;">{{ $reply->comment }}</div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            @endif
                        </div>
                    @endforeach
                </div>
            @else
                <div style="text-align: center; padding: 3rem 1.5rem; border: 1px dashed var(--border-color); border-radius: var(--radius-lg); background-color: var(--card-bg);">
                    <p style="color: var(--text-muted);">No comments yet. Be the first to start the conversation!</p>
                </div>
            @endif
        </section>

    </div>

@endsection

@section('scripts')
<script>
    function toggleReplyForm(commentId) {
        const form = document.getElementById('reply-form-' + commentId);
        if (form) {
            form.style.display = form.style.display === 'none' ? 'block' : 'none';
        }
    }
</script>
@endsection
