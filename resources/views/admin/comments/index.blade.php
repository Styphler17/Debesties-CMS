@extends('admin.layouts.app')

@section('title', 'Comments Moderation — Debesties Studio')
@section('page_title', 'Comments')

@section('content')

@if(session('success'))
    <div class="badge badge-success" style="width: 100%; padding: 12px 18px; margin-bottom: 20px; font-size: 13.5px; border-radius: var(--cms-r-md);">
        <i data-lucide="check-circle" style="width: 16px; height: 16px; margin-right: 8px;"></i>
        {{ session('success') }}
    </div>
@endif

{{-- Comments Summary / Action Bar --}}
<div style="display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 14px; margin-bottom: 20px;">
    
    {{-- Tabs --}}
    <div style="display: flex; gap: 2px; background: var(--cms-surface); border: 1px solid var(--cms-border); border-radius: var(--cms-r-md); padding: 3px; flex-shrink: 0; box-shadow: var(--cms-sh-card);">
        @foreach(['all' => 'All', 'pending' => 'Pending', 'approved' => 'Approved', 'spam' => 'Spam'] as $statusVal => $tabLabel)
            @php 
                $isActive = (request('status', 'all') === $statusVal);
            @endphp
            <a href="{{ route('admin.comments.index', ['status' => $statusVal]) }}"
               style="display: inline-flex; align-items: center; gap: 6px; padding: 6px 14px; border-radius: 7px; font-family: var(--cms-font-ui); font-size: 13px; font-weight: {{ $isActive ? '700' : '500' }}; color: {{ $isActive ? 'var(--cms-fg1)' : 'var(--cms-fg3)' }}; background: {{ $isActive ? 'var(--cms-bg)' : 'transparent' }}; text-decoration: none; box-shadow: {{ $isActive ? 'var(--cms-sh-card)' : 'none' }}; transition: all 140ms ease;">
                {{ $tabLabel }}
            </a>
        @endforeach
    </div>

    {{-- Bulk Actions Bar --}}
    <div id="bulk-actions-bar" style="display: none; align-items: center; gap: 8px; animation: dsPop 180ms ease;">
        <span style="font-family: var(--cms-font-ui); font-size: 13px; color: var(--cms-fg3); font-weight: 600;" id="selected-count">0 selected</span>
        <button class="badge badge-success" style="height: 30px; cursor: pointer; border: 1px solid rgba(26,138,75,0.1);">Approve</button>
        <button class="badge badge-warning" style="height: 30px; cursor: pointer; border: 1px solid rgba(232,168,0,0.1);">Mark Spam</button>
        <button class="badge badge-danger" style="height: 30px; cursor: pointer; border: 1px solid rgba(200,55,43,0.1);">Delete</button>
    </div>
</div>

{{-- Comments Table --}}
<div class="cms-card">
    <table class="cms-table">
        <thead>
            <tr>
                <th style="padding-left: 16px; width: 40px;"><input type="checkbox" onchange="toggleAll(this)" style="cursor: pointer; accent-color: var(--cms-gold); width: 14px; height: 14px;" /></th>
                <th style="padding-left: 0;">Author</th>
                <th>Comment Content</th>
                <th>On Post</th>
                <th style="text-align: center;">Status</th>
                <th style="text-align: right;">Date</th>
                <th style="width: 100px;"></th>
            </tr>
        </thead>
        <tbody>
            @forelse($comments as $comment)
                @php 
                    $initials = collect(explode(' ', $comment->name))->map(fn($w) => strtoupper(substr($w, 0, 1)))->take(2)->join('');
                    $statusClass = [
                        'approved' => 'badge-success',
                        'pending'  => 'badge-warning',
                        'spam'     => 'badge-danger',
                    ][$comment->status] ?? 'badge-info';
                    $avatarBgs = ['#E8A800', '#2F6BD8', '#B14FD8', '#1A8A4B', '#C8372B'];
                    $avatarBg = $avatarBgs[abs(crc32($comment->email)) % count($avatarBgs)];
                @endphp
                <tr class="comment-row" id="comment-row-{{ $comment->id }}">
                    <td style="padding-left: 16px;">
                        <input type="checkbox" class="comment-cb" onchange="updateCheckedState()" style="cursor: pointer; accent-color: var(--cms-gold); width: 14px; height: 14px;" />
                    </td>
                    <td style="padding-left: 0; vertical-align: top;">
                        <div style="display: flex; align-items: center; gap: 10px;">
                            <div style="width: 32px; height: 32px; border-radius: 999px; background: {{ $avatarBg }}1A; border: 1.5px solid {{ $avatarBg }}40; color: {{ $avatarBg }}; display: flex; align-items: center; justify-content: center; font-family: var(--cms-font-ui); font-size: 11px; font-weight: 800; flex-shrink: 0;">
                                {{ $initials }}
                            </div>
                            <div style="min-width: 0;">
                                <div style="font-weight: 700; color: var(--cms-fg1); font-size: 13.5px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">{{ $comment->name }}</div>
                                <div style="font-size: 11px; color: var(--cms-fg4); font-weight: 500;">{{ $comment->email }}</div>
                            </div>
                        </div>
                    </td>
                    <td style="vertical-align: top; max-width: 400px;">
                        <div style="font-size: 13.5px; color: var(--cms-fg2); line-height: 1.5; display: -webkit-box; -webkit-line-clamp: 3; -webkit-box-orient: vertical; overflow: hidden; word-break: break-word;">
                            {{ $comment->comment }}
                        </div>
                    </td>
                    <td style="vertical-align: top; white-space: nowrap;">
                        @if($comment->post)
                            <a href="{{ route('admin.posts.edit', $comment->post) }}" style="font-weight: 700; color: var(--cms-blue); text-decoration: none; font-size: 13px;">
                                {{ Str::limit($comment->post->title, 24) }}
                            </a>
                        @else
                            <span style="color: var(--cms-fg4); font-style: italic; font-size: 12.5px;">Deleted post</span>
                        @endif
                    </td>
                    <td style="vertical-align: top; text-align: center;">
                        <span class="badge {{ $statusClass }}">{{ ucfirst($comment->status) }}</span>
                    </td>
                    <td style="vertical-align: top; text-align: right; white-space: nowrap; color: var(--cms-fg3); font-size: 12px;">
                        {{ $comment->created_at->diffForHumans() }}
                    </td>
                    <td style="vertical-align: top;">
                        <div style="display: flex; gap: 6px; justify-content: flex-end;">
                            @if($comment->status !== 'approved')
                                <button onclick="updateCommentStatus({{ $comment->id }}, 'approved')" class="btn-secondary" style="width: 30px; height: 30px; padding: 0; color: var(--cms-green);" title="Approve">
                                    <i data-lucide="check" style="width: 14px; height: 14px;"></i>
                                </button>
                            @endif
                            @if($comment->status !== 'spam')
                                <button onclick="updateCommentStatus({{ $comment->id }}, 'spam')" class="btn-secondary" style="width: 30px; height: 30px; padding: 0; color: var(--cms-red);" title="Mark as Spam">
                                    <i data-lucide="slash" style="width: 14px; height: 14px;"></i>
                                </button>
                            @endif
                            <form method="POST" action="{{ route('admin.comments.destroy', $comment->id) }}" onsubmit="return confirm('Delete this comment permanently?')">
                                @csrf @method('DELETE')
                                <button type="submit" class="btn-secondary" style="width: 30px; height: 30px; padding: 0; color: var(--cms-fg3);" title="Delete">
                                    <i data-lucide="trash-2" style="width: 14px; height: 14px;"></i>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="7" style="padding: 64px 20px; text-align: center;">
                        <div style="display: flex; flex-direction: column; align-items: center; gap: 12px;">
                            <div style="width: 48px; height: 48px; border-radius: 999px; background: var(--cms-bg); display: flex; align-items: center; justify-content: center; color: var(--cms-fg4);">
                                <i data-lucide="message-square" style="width: 24px; height: 24px;"></i>
                            </div>
                            <div style="font-family: var(--cms-font-ui); font-size: 15px; font-weight: 700; color: var(--cms-fg2);">No comments in this filter</div>
                        </div>
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>

    @if($comments->hasPages())
        <div style="padding: 16px 20px; border-top: 1px solid var(--cms-border); background: #FDFBF8;">
            {{ $comments->links() }}
        </div>
    @endif
</div>

<script>
    function toggleAll(master) {
        document.querySelectorAll('.comment-cb').forEach(cb => cb.checked = master.checked);
        updateCheckedState();
    }

    function updateCheckedState() {
        const count = document.querySelectorAll('.comment-cb:checked').length;
        const bar = document.getElementById('bulk-actions-bar');
        const countSpan = document.getElementById('selected-count');

        if (count > 0) {
            bar.style.display = 'flex';
            countSpan.textContent = `${count} selected`;
        } else {
            bar.style.display = 'none';
        }
    }

    function updateCommentStatus(id, status) {
        const form = document.createElement('form');
        form.method = 'POST';
        form.action = `{{ route('admin.comments.index') }}/${id}`;
        
        const csrf = document.createElement('input');
        csrf.type = 'hidden'; csrf.name = '_token'; csrf.value = '{{ csrf_token() }}';
        form.appendChild(csrf);

        const method = document.createElement('input');
        method.type = 'hidden'; method.name = '_method'; method.value = 'PUT';
        form.appendChild(method);

        const statusInput = document.createElement('input');
        statusInput.type = 'hidden'; statusInput.name = 'status'; statusInput.value = status;
        form.appendChild(statusInput);

        document.body.appendChild(form);
        form.submit();
    }
</script>
@endsection
