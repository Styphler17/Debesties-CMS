@extends('admin.layouts.app')

@section('title', 'Users — Debesties Studio')
@section('page_title', 'Users')

@section('content')

@if(session('success'))
    <div style="background: var(--cms-green-soft); color: var(--cms-green-deep); padding: 12px 18px; border-radius: var(--cms-r-md); border: 1px solid rgba(26,138,75,0.2); margin-bottom: 16px; font-family: var(--cms-font-ui); font-size: 14px; font-weight: 600;">
        {{ session('success') }}
    </div>
@endif
@if(session('error'))
    <div style="background: var(--cms-red-soft); color: var(--cms-red-deep); padding: 12px 18px; border-radius: var(--cms-r-md); border: 1px solid rgba(200,55,43,0.2); margin-bottom: 16px; font-family: var(--cms-font-ui); font-size: 14px; font-weight: 600;">
        {{ session('error') }}
    </div>
@endif

{{-- Toolbar --}}
<div style="display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 12px; margin-bottom: 20px;">
    {{-- Status Tabs --}}
    <div style="display: flex; gap: 2px; background: var(--cms-surface); border: 1.5px solid var(--cms-border); border-radius: var(--cms-r-lg); padding: 4px;">
        @foreach(['all' => 'All', 'active' => 'Active', 'suspended' => 'Suspended'] as $statusVal => $tabLabel)
            @php
                $isActiveTab = request('status', 'all') === $statusVal;
                $tabCount = $statusVal === 'all' ? $allCount : ($statusVal === 'active' ? $activeCount : $suspendedCount);
            @endphp
            <a href="{{ route('admin.users.index', array_merge(request()->query(), ['status' => $statusVal])) }}"
               style="height: 30px; padding: 0 14px; font-family: var(--cms-font-ui); font-size: 13px; font-weight: 600; border: none; border-radius: var(--cms-r-md); text-decoration: none; cursor: pointer; background: {{ $isActiveTab ? 'var(--cms-gold)' : 'transparent' }}; color: {{ $isActiveTab ? '#1A1410' : 'var(--cms-fg3)' }}; display: flex; align-items: center; gap: 5px; transition: all 150ms;">
                {{ $tabLabel }} 
                <span style="font-size: 11px; background: {{ $isActiveTab ? 'rgba(0,0,0,0.15)' : 'var(--cms-border)' }}; padding: 0 5px; border-radius: 999px;">{{ $tabCount }}</span>
            </a>
        @endforeach
    </div>

    {{-- Filters & Add Button --}}
    <div style="display: flex; align-items: center; gap: 10px; flex-wrap: wrap;">
        <form method="GET" action="{{ route('admin.users.index') }}" style="display: flex; align-items: center; gap: 10px; flex-wrap: wrap;">
            @if(request('status'))
                <input type="hidden" name="status" value="{{ request('status') }}" />
            @endif
            <div style="display: flex; align-items: center; gap: 8px; width: 200px; height: 38px; background: var(--cms-surface); border: 1.5px solid var(--cms-border); border-radius: var(--cms-r-md); padding: 0 12px;">
                <i data-lucide="search" style="width: 15px; height: 15px; color: var(--cms-fg4); flex-shrink: 0;"></i>
                <input name="search" value="{{ request('search') }}" placeholder="Search users…" style="border: none; outline: none; background: none; flex: 1; font-family: var(--cms-font-ui); font-size: 13.5px; color: var(--cms-fg1);" />
            </div>
            <select name="role" onchange="this.form.submit()"
                    style="height: 38px; padding: 0 12px; font-family: var(--cms-font-ui); font-size: 13px; color: var(--cms-fg1); background: var(--cms-surface); border: 1.5px solid var(--cms-border); border-radius: var(--cms-r-md); cursor: pointer; outline: none;">
                <option value="All">All Roles</option>
                @foreach($roles as $role)
                    <option value="{{ $role->slug }}" {{ request('role') === $role->slug ? 'selected' : '' }}>{{ $role->name }}</option>
                @endforeach
            </select>
        </form>

        <a href="{{ route('admin.users.create') }}"
           style="display: inline-flex; align-items: center; gap: 7px; height: 38px; padding: 0 18px; font-family: var(--cms-font-ui); font-size: 13.5px; font-weight: 600; background: var(--cms-gold); color: #1A1410; border: none; border-radius: var(--cms-r-md); text-decoration: none; cursor: pointer;"
           onmouseover="this.style.background='#D69B00'" onmouseout="this.style.background='var(--cms-gold)'">
            <i data-lucide="user-plus" style="width: 16px; height: 16px;"></i>
            Add User
        </a>
    </div>
</div>

{{-- Users Table --}}
<div style="background: var(--cms-surface); border: 1px solid var(--cms-border); border-radius: var(--cms-r-lg); overflow: hidden; box-shadow: var(--cms-sh-card);">
    <table style="width: 100%; border-collapse: collapse;">
        <thead>
            <tr style="border-bottom: 1px solid var(--cms-border);">
                <th style="padding: 11px 16px; width: 40px;"><input type="checkbox" onchange="toggleAll(this)" style="cursor: pointer; accent-color: var(--cms-gold); width: 14px; height: 14px;" /></th>
                <th style="padding: 11px 0 11px 0; text-align: left; font-family: var(--cms-font-ui); font-size: 12px; font-weight: 700; color: var(--cms-fg3); text-transform: uppercase; letter-spacing: 0.04em;">User</th>
                <th style="padding: 11px 16px 11px 0; text-align: left; font-family: var(--cms-font-ui); font-size: 12px; font-weight: 700; color: var(--cms-fg3); text-transform: uppercase; letter-spacing: 0.04em;">Role</th>
                <th style="padding: 11px 16px 11px 0; text-align: center; font-family: var(--cms-font-ui); font-size: 12px; font-weight: 700; color: var(--cms-fg3); text-transform: uppercase; letter-spacing: 0.04em;">Status</th>
                <th style="padding: 11px 16px 11px 0; text-align: center; font-family: var(--cms-font-ui); font-size: 12px; font-weight: 700; color: var(--cms-fg3); text-transform: uppercase; letter-spacing: 0.04em;">Posts</th>
                <th style="padding: 11px 16px 11px 0; text-align: right; font-family: var(--cms-font-ui); font-size: 12px; font-weight: 700; color: var(--cms-fg3); text-transform: uppercase; letter-spacing: 0.04em;">Last Login</th>
                <th style="padding: 11px 16px; width: 100px;"></th>
            </tr>
        </thead>
        <tbody>
            @forelse($users as $user)
                @php
                    $words = explode(' ', $user->name);
                    $initials = '';
                    foreach ($words as $w) {
                        if (!empty($w)) {
                            $initials .= strtoupper($w[0]);
                        }
                    }
                    $initials = substr($initials, 0, 2);

                    $role = $user->roles->first();
                    $roleName = $role ? $role->name : 'Subscriber';
                    $roleSlug = $role ? $role->slug : 'subscriber';

                    // Assign badge colors based on role
                    $roleColor = 'var(--cms-fg2)';
                    $roleBg = 'var(--cms-border)';
                    if ($roleSlug === 'super_admin') {
                        $roleColor = 'var(--cms-gold-deep)';
                        $roleBg = 'var(--cms-gold-soft)';
                    } elseif ($roleSlug === 'editor') {
                        $roleColor = 'var(--cms-blue)';
                        $roleBg = 'rgba(74,121,255,0.1)';
                    } elseif ($roleSlug === 'author') {
                        $roleColor = '#9B59B6';
                        $roleBg = 'rgba(155,89,182,0.1)';
                    }

                    // Avatar color hash
                    $avatarBgs = ['#E8A800', '#4A79FF', '#9B59B6', '#2ECC71', '#E67E22', '#1ABC9C'];
                    $bgIndex = abs(crc32($user->email)) % count($avatarBgs);
                    $avatarBg = $avatarBgs[$bgIndex];
                @endphp
                <tr class="user-row" data-status="{{ $user->status }}"
                    style="border-bottom: 1px solid var(--cms-border); transition: background 100ms;"
                    onmouseover="this.style.background='#FDFBF8'" onmouseout="this.style.background='transparent'">
                    <td style="padding: 14px 16px;">
                        <input type="checkbox" class="user-cb" style="cursor: pointer; accent-color: var(--cms-gold); width: 14px; height: 14px;" />
                    </td>
                    <td style="padding: 14px 0;">
                        <div style="display: flex; align-items: center; gap: 12px;">
                            @if($user->avatar)
                                <img src="{{ $user->avatar }}" alt="avatar" style="width: 38px; height: 38px; border-radius: 999px; object-fit: cover; flex-shrink: 0;" />
                            @else
                                <div style="width: 38px; height: 38px; border-radius: 999px; background: {{ $avatarBg }}; display: flex; align-items: center; justify-content: center; font-family: var(--cms-font-ui); font-size: 13px; font-weight: 800; color: #fff; flex-shrink: 0;">
                                    {{ $initials }}
                                </div>
                            @endif
                            <div>
                                <div style="font-family: var(--cms-font-ui); font-size: 14px; font-weight: 600; color: var(--cms-fg1);">{{ $user->name }}</div>
                                <div style="font-family: var(--cms-font-ui); font-size: 12.5px; color: var(--cms-fg4);">{{ $user->email }}</div>
                            </div>
                        </div>
                    </td>
                    <td style="padding: 14px 16px 14px 0;">
                        <span style="font-family: var(--cms-font-ui); font-size: 12.5px; font-weight: 700; padding: 3px 10px; border-radius: 999px; background: {{ $roleBg }}; color: {{ $roleColor }};">{{ $roleName }}</span>
                    </td>
                    <td style="padding: 14px 16px 14px 0; text-align: center;">
                        @if($user->status === 'active')
                            <span style="display: inline-flex; align-items: center; gap: 5px; font-family: var(--cms-font-ui); font-size: 12.5px; font-weight: 700; color: var(--cms-green);">
                                <span style="width: 6px; height: 6px; border-radius: 999px; background: var(--cms-green); display: inline-block;"></span>Active
                            </span>
                        @else
                            <span style="display: inline-flex; align-items: center; gap: 5px; font-family: var(--cms-font-ui); font-size: 12.5px; font-weight: 700; color: var(--cms-red);">
                                <span style="width: 6px; height: 6px; border-radius: 999px; background: var(--cms-red); display: inline-block;"></span>Suspended
                            </span>
                        @endif
                    </td>
                    <td style="padding: 14px 16px 14px 0; text-align: center;">
                        <a href="{{ route('admin.posts.index', ['author_id' => $user->id]) }}"
                           style="font-family: var(--cms-font-ui); font-size: 13px; font-weight: 600; color: var(--cms-blue); text-decoration: none;">{{ $user->posts()->count() }}</a>
                    </td>
                    <td style="padding: 14px 16px 14px 0; text-align: right;">
                        <span style="font-family: var(--cms-font-ui); font-size: 12.5px; color: var(--cms-fg4);">{{ $user->last_login_at ? $user->last_login_at->diffForHumans() : 'Never' }}</span>
                    </td>
                    <td style="padding: 14px 16px;">
                        <div style="display: flex; gap: 5px; justify-content: flex-end;">
                            <a href="{{ route('admin.users.edit', $user->id) }}" title="Edit user"
                               style="width: 30px; height: 30px; border-radius: 6px; border: 1.5px solid var(--cms-border); background: var(--cms-surface); cursor: pointer; display: flex; align-items: center; justify-content: center; color: var(--cms-fg3); text-decoration: none;"
                               onmouseover="this.style.background='var(--cms-bg)'; this.style.color='var(--cms-fg1)'"
                               onmouseout="this.style.background='var(--cms-surface)'; this.style.color='var(--cms-fg3)'">
                                <i data-lucide="edit-2" style="width: 13px; height: 13px;"></i>
                            </a>
                            
                            {{-- Suspend/Activate Toggle Form --}}
                            <form method="POST" action="{{ route('admin.users.update', $user->id) }}" style="display: inline;">
                                @csrf
                                @method('PUT')
                                <input type="hidden" name="name" value="{{ $user->name }}" />
                                <input type="hidden" name="email" value="{{ $user->email }}" />
                                <input type="hidden" name="status" value="{{ $user->status === 'active' ? 'suspended' : 'active' }}" />
                                
                                @if($user->status === 'active')
                                    <button type="submit" title="Suspend user"
                                            style="width: 30px; height: 30px; border-radius: 6px; border: 1.5px solid rgba(232,168,0,0.2); background: var(--cms-gold-soft); cursor: pointer; display: flex; align-items: center; justify-content: center; color: var(--cms-gold-deep);"
                                            onmouseover="this.style.background='rgba(232,168,0,0.2)'" onmouseout="this.style.background='var(--cms-gold-soft)'">
                                        <i data-lucide="pause-circle" style="width: 13px; height: 13px;"></i>
                                    </button>
                                @else
                                    <button type="submit" title="Activate user"
                                            style="width: 30px; height: 30px; border-radius: 6px; border: 1.5px solid rgba(46,204,113,0.25); background: rgba(46,204,113,0.1); cursor: pointer; display: flex; align-items: center; justify-content: center; color: var(--cms-green);"
                                            onmouseover="this.style.background='rgba(46,204,113,0.2)'" onmouseout="this.style.background='rgba(46,204,113,0.1)'">
                                        <i data-lucide="play-circle" style="width: 13px; height: 13px;"></i>
                                    </button>
                                @endif
                            </form>

                            @if($user->id !== auth()->id())
                                <button onclick="confirmDelete({{ $user->id }}, '{{ $user->name }}')" title="Delete"
                                        style="width: 30px; height: 30px; border-radius: 6px; border: 1.5px solid rgba(200,55,43,0.2); background: var(--cms-red-soft); cursor: pointer; display: flex; align-items: center; justify-content: center; color: var(--cms-red);"
                                        onmouseover="this.style.background='#F8D5D2'" onmouseout="this.style.background='var(--cms-red-soft)'">
                                    <i data-lucide="trash-2" style="width: 13px; height: 13px;"></i>
                                </button>
                            @endif
                        </div>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="7" style="padding: 32px; text-align: center; font-family: var(--cms-font-ui); font-size: 14px; color: var(--cms-fg3);">No users found.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>

<div style="margin-top: 16px;">
    {{ $users->links() }}
</div>

{{-- Delete Modal --}}
<div id="delete-modal" style="display: none; position: fixed; inset: 0; background: rgba(20,16,12,0.5); z-index: 200; align-items: center; justify-content: center;">
    <div style="background: var(--cms-surface); border-radius: var(--cms-r-xl); padding: 28px; width: 380px; max-width: calc(100vw - 40px); box-shadow: var(--cms-sh-pop); animation: dsPop 200ms ease;">
        <div style="display: flex; align-items: center; gap: 12px; margin-bottom: 10px;">
            <div style="width: 40px; height: 40px; border-radius: var(--cms-r-md); background: var(--cms-red-soft); display: flex; align-items: center; justify-content: center; flex-shrink: 0;">
                <i data-lucide="user-x" style="width: 20px; height: 20px; color: var(--cms-red);"></i>
            </div>
            <div>
                <div style="font-family: var(--cms-font-ui); font-size: 15px; font-weight: 700; color: var(--cms-fg1);">Delete User?</div>
                <div id="delete-label" style="font-family: var(--cms-font-ui); font-size: 13px; color: var(--cms-fg3); margin-top: 2px;"></div>
            </div>
        </div>
        <div style="background: var(--cms-red-soft); border: 1px solid rgba(200,55,43,0.2); border-radius: var(--cms-r-md); padding: 10px 14px; margin: 12px 0; font-family: var(--cms-font-ui); font-size: 12.5px; color: var(--cms-red-deep);">
            Their authored articles will be reassigned to you to preserve them in the system.
        </div>
        <div style="display: flex; gap: 8px; justify-content: flex-end;">
            <button onclick="closeDelete()" style="height: 38px; padding: 0 18px; font-family: var(--cms-font-ui); font-size: 13.5px; font-weight: 600; background: var(--cms-surface); color: var(--cms-fg2); border: 1.5px solid var(--cms-border); border-radius: var(--cms-r-md); cursor: pointer;">Cancel</button>
            <form id="delete-form" method="POST" action="" style="display: inline;">
                @csrf
                @method('DELETE')
                <button type="submit" style="height: 38px; padding: 0 18px; font-family: var(--cms-font-ui); font-size: 13.5px; font-weight: 600; background: var(--cms-red); color: #fff; border: none; border-radius: var(--cms-r-md); cursor: pointer;">Delete User</button>
            </form>
        </div>
    </div>
</div>

<script>
    let deleteUserId = null;

    function confirmDelete(id, name) {
        deleteUserId = id;
        document.getElementById('delete-label').textContent = name;
        
        const deleteForm = document.getElementById('delete-form');
        deleteForm.action = `/admin/users/${id}`;

        document.getElementById('delete-modal').style.display = 'flex';
        lucide.createIcons();
    }
    
    function closeDelete() {
        document.getElementById('delete-modal').style.display = 'none';
        deleteUserId = null;
    }

    function toggleAll(master) {
        document.querySelectorAll('.user-cb').forEach(cb => cb.checked = master.checked);
    }
</script>
@endsection
