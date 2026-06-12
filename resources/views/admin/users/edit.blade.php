@extends('admin.layouts.app')

@section('title', 'Edit User — Debesties Studio')
@section('page_title', 'Edit User')

@section('content')
<div style="background: var(--cms-surface); border: 1px solid var(--cms-border); border-radius: var(--cms-r-xl); padding: 28px; max-width: 600px; box-shadow: var(--cms-sh-card);">
    <form method="POST" action="{{ route('admin.users.update', $user->id) }}" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        
        <div style="display: flex; flex-direction: column; gap: 20px;">
            <div>
                <label style="font-family: var(--cms-font-ui); font-size: 12px; font-weight: 700; color: var(--cms-fg3); text-transform: uppercase; display: block; margin-bottom: 6px;">Full Name</label>
                <input type="text" name="name" value="{{ old('name', $user->name) }}" required
                       style="width: 100%; height: 42px; padding: 0 12px; font-family: var(--cms-font-ui); font-size: 13.5px; color: var(--cms-fg1); background: var(--cms-bg); border: 1.5px solid var(--cms-border); border-radius: var(--cms-r-md); outline: none;" />
                @error('name') <span style="color: var(--cms-red); font-size: 12px; display: block; margin-top: 4px;">{{ $message }}</span> @enderror
            </div>

            <div>
                <label style="font-family: var(--cms-font-ui); font-size: 12px; font-weight: 700; color: var(--cms-fg3); text-transform: uppercase; display: block; margin-bottom: 6px;">Email Address</label>
                <input type="email" name="email" value="{{ old('email', $user->email) }}" required
                       style="width: 100%; height: 42px; padding: 0 12px; font-family: var(--cms-font-ui); font-size: 13.5px; color: var(--cms-fg1); background: var(--cms-bg); border: 1.5px solid var(--cms-border); border-radius: var(--cms-r-md); outline: none;" />
                @error('email') <span style="color: var(--cms-red); font-size: 12px; display: block; margin-top: 4px;">{{ $message }}</span> @enderror
            </div>

            <div>
                <label style="font-family: var(--cms-font-ui); font-size: 12px; font-weight: 700; color: var(--cms-fg3); text-transform: uppercase; display: block; margin-bottom: 6px;">Password (Leave blank to keep current)</label>
                <input type="password" name="password"
                       style="width: 100%; height: 42px; padding: 0 12px; font-family: var(--cms-font-ui); font-size: 13.5px; color: var(--cms-fg1); background: var(--cms-bg); border: 1.5px solid var(--cms-border); border-radius: var(--cms-r-md); outline: none;" />
                @error('password') <span style="color: var(--cms-red); font-size: 12px; display: block; margin-top: 4px;">{{ $message }}</span> @enderror
            </div>

            <div>
                <label style="font-family: var(--cms-font-ui); font-size: 12px; font-weight: 700; color: var(--cms-fg3); text-transform: uppercase; display: block; margin-bottom: 6px;">Roles</label>
                <div style="display: flex; flex-direction: column; gap: 8px;">
                    @foreach($roles as $role)
                        <label style="display: inline-flex; align-items: center; gap: 8px; font-family: var(--cms-font-ui); font-size: 13.5px; color: var(--cms-fg2); cursor: pointer;">
                            <input type="checkbox" name="roles[]" value="{{ $role->id }}" style="accent-color: var(--cms-gold);"
                                   {{ $user->roles->contains($role->id) ? 'checked' : '' }} />
                            {{ $role->name }}
                        </label>
                    @endforeach
                </div>
                @error('roles') <span style="color: var(--cms-red); font-size: 12px; display: block; margin-top: 4px;">{{ $message }}</span> @enderror
            </div>

            <div>
                <label style="font-family: var(--cms-font-ui); font-size: 12px; font-weight: 700; color: var(--cms-fg3); text-transform: uppercase; display: block; margin-bottom: 6px;">Status</label>
                <select name="status" style="width: 100%; height: 42px; padding: 0 12px; font-family: var(--cms-font-ui); font-size: 13.5px; color: var(--cms-fg1); background: var(--cms-bg); border: 1.5px solid var(--cms-border); border-radius: var(--cms-r-md); outline: none; cursor: pointer;">
                    <option value="active" {{ $user->status === 'active' ? 'selected' : '' }}>Active</option>
                    <option value="suspended" {{ $user->status === 'suspended' ? 'selected' : '' }}>Suspended</option>
                </select>
            </div>

            <div>
                <label style="font-family: var(--cms-font-ui); font-size: 12px; font-weight: 700; color: var(--cms-fg3); text-transform: uppercase; display: block; margin-bottom: 6px;">Avatar</label>
                @if($user->avatar)
                    <img src="{{ $user->avatar }}" alt="avatar" style="width: 50px; height: 50px; border-radius: 999px; object-fit: cover; display: block; margin-bottom: 8px;" />
                @endif
                <input type="file" name="avatar" accept="image/*"
                       style="font-family: var(--cms-font-ui); font-size: 13.5px; color: var(--cms-fg2);" />
                @error('avatar') <span style="color: var(--cms-red); font-size: 12px; display: block; margin-top: 4px;">{{ $message }}</span> @enderror
            </div>

            <div>
                <label style="font-family: var(--cms-font-ui); font-size: 12px; font-weight: 700; color: var(--cms-fg3); text-transform: uppercase; display: block; margin-bottom: 6px;">Biography</label>
                <textarea name="bio" style="width: 100%; height: 80px; padding: 10px 12px; font-family: var(--cms-font-ui); font-size: 13.5px; color: var(--cms-fg1); background: var(--cms-bg); border: 1.5px solid var(--cms-border); border-radius: var(--cms-r-md); outline: none; resize: none;">{{ old('bio', $user->bio) }}</textarea>
                @error('bio') <span style="color: var(--cms-red); font-size: 12px; display: block; margin-top: 4px;">{{ $message }}</span> @enderror
            </div>

            <div style="display: flex; align-items: center; gap: 8px;">
                <input type="checkbox" name="newsletter" value="1" {{ $user->newsletter ? 'checked' : '' }} style="accent-color: var(--cms-gold);" id="newsletter-cb" />
                <label for="newsletter-cb" style="font-family: var(--cms-font-ui); font-size: 13.5px; color: var(--cms-fg2); cursor: pointer;">Subscribe to newsletter</label>
            </div>

            <div style="display: flex; gap: 12px; margin-top: 10px;">
                <a href="{{ route('admin.users.index') }}" style="flex: 1; height: 40px; display: inline-flex; align-items: center; justify-content: center; font-family: var(--cms-font-ui); font-size: 13.5px; font-weight: 600; background: var(--cms-bg); color: var(--cms-fg2); border: 1.5px solid var(--cms-border); border-radius: var(--cms-r-md); text-decoration: none;">Cancel</a>
                <button type="submit" style="flex: 2; height: 40px; font-family: var(--cms-font-ui); font-size: 13.5px; font-weight: 700; background: var(--cms-gold); color: #1A1410; border: none; border-radius: var(--cms-r-md); cursor: pointer; transition: background 150ms;"
                        onmouseover="this.style.background='#D69B00'" onmouseout="this.style.background='var(--cms-gold)'">Update User</button>
            </div>
        </div>
    </form>
</div>
@endsection
