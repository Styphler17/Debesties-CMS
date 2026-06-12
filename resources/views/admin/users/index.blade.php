@extends('admin.layouts.app')

@section('title', 'Users — Debesties Studio')
@section('page_title', 'Users')

@section('content')

@if(session('success'))
    <div class="badge badge-success" style="width: 100%; padding: 12px 18px; margin-bottom: 20px; font-size: 13.5px; border-radius: var(--cms-r-md);">
        <i data-lucide="check-circle" style="width: 16px; height: 16px; margin-right: 8px;"></i>
        {{ session('success') }}
    </div>
@endif

{{-- Toolbar --}}
<div style="display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 14px; margin-bottom: 20px;">
    {{-- Status Tabs --}}
    <div style="display: flex; gap: 2px; background: var(--cms-surface); border: 1px solid var(--cms-border); border-radius: var(--cms-r-md); padding: 3px; flex-shrink: 0; box-shadow: var(--cms-sh-card);">
        @foreach(['all' => 'All', 'active' => 'Active', 'suspended' => 'Suspended'] as $statusVal => $tabLabel)
            @php
                $isActiveTab = request('status', 'all') === $statusVal;
                $tabCount = $statusVal === 'all' ? $allCount : ($statusVal === 'active' ? $activeCount : $suspendedCount);
            @endphp
            <a href="{{ route('admin.users.index', array_merge(request()->query(), ['status' => $statusVal])) }}"
               style="display: inline-flex; align-items: center; gap: 6px; padding: 6px 14px; border-radius: 7px; font-family: var(--cms-font-ui); font-size: 13px; font-weight: {{ $isActiveTab ? '700' : '500' }}; color: {{ $isActiveTab ? 'var(--cms-fg1)' : 'var(--cms-fg3)' }}; background: {{ $isActiveTab ? 'var(--cms-bg)' : 'transparent' }}; text-decoration: none; box-shadow: {{ $isActiveTab ? 'var(--cms-sh-card)' : 'none' }}; transition: all 140ms ease;">
                {{ $tabLabel }} 
                <span style="font-size: 11px; font-weight: 700; color: {{ $isActiveTab ? 'var(--cms-fg3)' : 'var(--cms-fg4)' }}; background: {{ $isActiveTab ? 'rgba(0,0,0,0.06)' : 'var(--cms-border)' }}; padding: 1px 6px; border-radius: 999px;">{{ $tabCount }}</span>
            </a>
        @endforeach
    </div>

    {{-- Filters & Add Button --}}
    <div style="display: flex; align-items: center; gap: 10px; flex-wrap: wrap;">
        <form method="GET" action="{{ route('admin.users.index') }}" style="display: flex; align-items: center; gap: 10px; flex-wrap: wrap;">
            @if(request('status'))
                <input type="hidden" name="status" value="{{ request('status') }}" />
            @endif
            <div class="cms-search-bar" style="display: flex; align-items: center; gap: 8px; width: 220px; height: 38px; background: var(--cms-surface); border: 1.5px solid var(--cms-border); border-radius: var(--cms-r-md); padding: 0 12px; transition: all 140ms ease;">
                <i data-lucide="search" style="width: 15px; height: 15px; color: var(--cms-fg4); flex-shrink: 0;"></i>
                <input name="search" value="{{ request('search') }}" placeholder="Search users…" style="border: none; outline: none; background: none; flex: 1; font-family: var(--cms-font-ui); font-size: 13.5px; color: var(--cms-fg1);" />
            </div>
            <select name="role" onchange="this.form.submit()" class="form-select" style="width: auto; height: 38px; padding: 0 32px 0 12px;">
                <option value="All">All Roles</option>
                @foreach($roles as $role)
                    <option value="{{ $role->slug }}" {{ request('role') === $role->slug ? 'selected' : '' }}>{{ $role->name }}</option>
                @endforeach
            </select>
        </form>

        <a href="{{ route('admin.users.create') }}" class="btn-primary">
            <i data-lucide="user-plus" style="width: 16px; height: 16px; stroke-width: 2.5;"></i>
            Add User
        </a>
    </div>
</div>

{{-- Users Table --}}
<div class="cms-card">
    <table class="cms-table">
        <thead>
            <tr>
                <th style="padding-left: 16px; width: 40px;"><input type="checkbox" onchange="toggleAll(this)" style="cursor: pointer; accent-color: var(--cms-gold); width: 14px; height: 14px;" /></th>
                <th style="padding-left: 0;">User</th>
                <th>Role</th>
                <th style="text-align: center;">Status</th>
                <th style="text-align: center;">Posts</th>
                <th style="text-align: right;">Last Login</th>
                <th style="width: 120px;"></th>
            </tr>
        </thead>
        <tbody>
            @forelse($users as $user)
                @php
                    $words = explode(' ', $user->name);
                    $initials = collect($words)->map(fn($w) => strtoupper(substr($w, 0, 1)))->take(2)->join('');

                    $role = $user->roles->first();
                    $roleName = $role ? $role->name : 'Subscriber';
                    $roleSlug = $role ? $role->slug : 'subscriber';

                    // Assign badge classes based on role
                    $roleClass = 'badge-info';
                    if ($roleSlug === 'super_admin') $roleClass = 'badge-warning';
                    elseif (in_array($roleSlug, ['editor', 'author'])) $roleClass = 'badge-success';

                    // Avatar color
                    $avatarBgs = ['#E8A800', '#2F6BD8', '#B14FD8', '#1A8A4B', '#C8372B'];
                    $avatarBg = $avatarBgs[abs(crc32($user->email)) % count($avatarBgs)];
                @endphp
                <tr class="user-row">
                    <td style="padding-left: 16px;">
                        <input type="checkbox" class="user-cb" style="cursor: pointer; accent-color: var(--cms-gold); width: 14px; height: 14px;" />
                    </td>
                    <td style="padding-left: 0;">
                        <div style="display: flex; align-items: center; gap: 12px;">
                            @if($user->avatar)
                                <img src="{{ $user->avatar }}" alt="avatar" style="width: 36px; height: 36px; border-radius: 999px; object-fit: cover; flex-shrink: 0; border: 1.5px solid var(--cms-border);" />
                            @else
                                <div style="width: 36px; height: 36px; border-radius: 999px; background: {{ $avatarBg }}1A; border: 1.5px solid {{ $avatarBg }}40; color: {{ $avatarBg }}; display: flex; align-items: center; justify-content: center; font-family: var(--cms-font-ui); font-size: 13px; font-weight: 800; flex-shrink: 0;">
                                    {{ $initials }}
                                </div>
                            @endif
                            <div>
                                <div style="font-weight: 700; color: var(--cms-fg1); font-size: 14px;">{{ $user->name }}</div>
                                <div style="font-size: 12px; color: var(--cms-fg4); font-weight: 500;">{{ $user->email }}</div>
                            </div>
                        </div>
                    </td>
                    <td>
                        <span class="badge {{ $roleClass }}">{{ $roleName }}</span>
                    </td>
                    <td style="text-align: center;">
                        @if($user->status === 'active')
                            <span style="color: var(--cms-green); font-weight: 700; font-size: 12.5px; display: inline-flex; align-items: center; gap: 5px;">
                                <span style="width: 6px; height: 6px; border-radius: 999px; background: var(--cms-green);"></span> Active
                            </span>
                        @else
                            <span style="color: var(--cms-red); font-weight: 700; font-size: 12.5px; display: inline-flex; align-items: center; gap: 5px;">
                                <span style="width: 6px; height: 6px; border-radius: 999px; background: var(--cms-red);"></span> Suspended
                            </span>
                        @endif
                    </td>
                    <td style="text-align: center;">
                        <a href="{{ route('admin.posts.index', ['author_id' => $user->id]) }}"
                           style="font-weight: 700; color: var(--cms-blue); text-decoration: none; font-size: 13.5px;">{{ $user->posts_count ?? $user->posts()->count() }}</a>
                    </td>
                    <td style="text-align: right; color: var(--cms-fg3); font-size: 12.5px;">
                        {{ $user->last_login_at ? $user->last_login_at->diffForHumans() : 'Never' }}
                    </td>
                    <td>
                        <div style="display: flex; gap: 6px; justify-content: flex-end;">
                            <a href="{{ route('admin.users.edit', $user->id) }}" class="btn-secondary" style="width: 32px; height: 32px; padding: 0;" title="Edit user">
                                <i data-lucide="edit-2" style="width: 14px; height: 14px;"></i>
                            </a>
                            
                            <form method="POST" action="{{ route('admin.users.update', $user->id) }}" style="display: inline;">
                                @csrf @method('PUT')
                                <input type="hidden" name="name" value="{{ $user->name }}" />
                                <input type="hidden" name="email" value="{{ $user->email }}" />
                                <input type="hidden" name="status" value="{{ $user->status === 'active' ? 'suspended' : 'active' }}" />
                                
                                <button type="submit" class="btn-secondary" style="width: 32px; height: 32px; padding: 0; color: {{ $user->status === 'active' ? 'var(--cms-gold-deep)' : 'var(--cms-green)' }};" title="{{ $user->status === 'active' ? 'Suspend' : 'Activate' }}">
                                    <i data-lucide="{{ $user->status === 'active' ? 'pause-circle' : 'play-circle' }}" style="width: 15px; height: 15px;"></i>
                                </button>
                            </form>

                            @if($user->id !== auth()->id())
                                <button onclick="confirmDelete({{ $user->id }}, '{{ $user->name }}')" class="btn-secondary" style="width: 32px; height: 32px; padding: 0; color: var(--cms-red); border-color: rgba(200,55,43,0.15);" title="Delete">
                                    <i data-lucide="trash-2" style="width: 14px; height: 14px;"></i>
                                </button>
                            @endif
                        </div>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="7" style="padding: 64px 20px; text-align: center;">
                        <div style="display: flex; flex-direction: column; align-items: center; gap: 12px;">
                            <div style="width: 48px; height: 48px; border-radius: 999px; background: var(--cms-bg); display: flex; align-items: center; justify-content: center; color: var(--cms-fg4);">
                                <i data-lucide="users" style="width: 24px; height: 24px;"></i>
                            </div>
                            <div style="font-family: var(--cms-font-ui); font-size: 15px; font-weight: 700; color: var(--cms-fg2);">No users found</div>
                            <button onclick="window.location.href='{{ route('admin.users.create') }}'" class="btn-primary" style="margin-top: 8px;">Add your first user</button>
                        </div>
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>

<div style="margin-top: 24px;">
    {{ $users->links() }}
</div>

{{-- Delete Modal --}}
<div id="delete-modal" style="display: none; position: fixed; inset: 0; background: rgba(26,20,16,0.4); backdrop-filter: blur(4px); -webkit-backdrop-filter: blur(4px); z-index: 200; align-items: center; justify-content: center; animation: dsFade 180ms ease;" onclick="closeDelete()">
    <div style="background: var(--cms-surface); border: 1px solid var(--cms-border); border-radius: var(--cms-r-xl); padding: 32px; width: 400px; max-width: calc(100vw - 40px); box-shadow: var(--cms-sh-pop); animation: dsPop 200ms ease;" onclick="event.stopPropagation()">
        <div style="display: flex; flex-direction: column; align-items: center; text-align: center; gap: 16px;">
            <div style="width: 56px; height: 56px; border-radius: 999px; background: var(--cms-red-soft); display: flex; align-items: center; justify-content: center; color: var(--cms-red);">
                <i data-lucide="user-x" style="width: 28px; height: 28px;"></i>
            </div>
            <div>
                <div style="font-family: var(--cms-font-disp); font-size: 20px; font-weight: 700; color: var(--cms-fg1);">Delete User?</div>
                <div id="delete-label" style="font-family: var(--cms-font-ui); font-size: 14px; color: var(--cms-fg3); margin-top: 6px; font-weight: 600;"></div>
                <div style="font-family: var(--cms-font-ui); font-size: 13px; color: var(--cms-fg4); margin-top: 8px; line-height: 1.5; background: #F9F7F3; padding: 10px; border-radius: 8px;">Authorship of existing articles will be reassigned to your account.</div>
            </div>
            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 12px; width: 100%; margin-top: 8px;">
                <button onclick="closeDelete()" class="btn-secondary">Cancel</button>
                <form id="delete-form" method="POST" action="" style="width: 100%;">
                    @csrf @method('DELETE')
                    <button type="submit" class="btn-primary" style="width: 100%; background: var(--cms-red); color: #fff; box-shadow: 0 2px 4px rgba(200,55,43,0.15);">Delete User</button>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    let deleteUserId = null;

    function confirmDelete(id, name) {
        deleteUserId = id;
        document.getElementById('delete-label').textContent = name;
        document.getElementById('delete-form').action = "{{ route('admin.users.destroy', ':id') }}".replace(':id', id);
        document.getElementById('delete-modal').style.display = 'flex';
        lucide.createIcons();
    }
    
    function closeDelete() {
        document.getElementById('delete-modal').style.display = 'none';
    }

    function toggleAll(master) {
        document.querySelectorAll('.user-cb').forEach(cb => cb.checked = master.checked);
    }
</script>

<style>
    .cms-search-bar:focus-within {
        border-color: var(--cms-gold) !important;
        box-shadow: 0 0 0 3px rgba(232, 168, 0, 0.13) !important;
    }
</style>
@endsection
