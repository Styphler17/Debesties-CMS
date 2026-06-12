@extends('public.layouts.app')

@section('title', 'Your Profile — Debesties')

@section('content')
<div style="max-width: 800px; margin: 0 auto; padding: 2rem 0;">
    <h2 style="font-family: 'Playfair Display', serif; font-size: 2.2rem; margin-bottom: 2rem;">Your Profile</h2>

    @if(session('success'))
        <div style="background-color: #dcfce7; color: #166534; padding: 1rem; border-radius: 8px; margin-bottom: 2rem;">
            {{ session('success') }}
        </div>
    @endif

    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 2.5rem; align-items: start;">
        <!-- Settings Form -->
        <div style="background-color: #fff; border: 1px solid #e5e7eb; border-radius: 12px; padding: 2rem; box-shadow: 0 1px 3px rgba(0,0,0,0.1);">
            <h3 style="font-size: 1.2rem; margin-bottom: 1.5rem; font-weight: 600;">Account Settings</h3>
            <form action="{{ route('profile.update') }}" method="POST">
                @csrf
                <div style="margin-bottom: 1.2rem;">
                    <label style="display: block; font-size: 0.85rem; font-weight: 600; margin-bottom: 0.4rem; color: #6b7280;">Name</label>
                    <input type="text" name="name" value="{{ old('name', $user->name) }}" required style="width: 100%; padding: 0.6rem; border: 1px solid #d1d5db; border-radius: 6px;">
                    @error('name') <span style="color: #ef4444; font-size: 0.75rem;">{{ $message }}</span> @enderror
                </div>
                <div style="margin-bottom: 1.2rem;">
                    <label style="display: block; font-size: 0.85rem; font-weight: 600; margin-bottom: 0.4rem; color: #6b7280;">Email</label>
                    <input type="email" name="email" value="{{ old('email', $user->email) }}" required style="width: 100%; padding: 0.6rem; border: 1px solid #d1d5db; border-radius: 6px;">
                    @error('email') <span style="color: #ef4444; font-size: 0.75rem;">{{ $message }}</span> @enderror
                </div>
                <div style="margin-bottom: 1.2rem;">
                    <label style="display: block; font-size: 0.85rem; font-weight: 600; margin-bottom: 0.4rem; color: #6b7280;">Bio</label>
                    <textarea name="bio" style="width: 100%; height: 80px; padding: 0.6rem; border: 1px solid #d1d5db; border-radius: 6px; resize: none;">{{ old('bio', $user->bio) }}</textarea>
                    @error('bio') <span style="color: #ef4444; font-size: 0.75rem;">{{ $message }}</span> @enderror
                </div>
                <div style="margin-bottom: 1.2rem; display: flex; align-items: center; gap: 8px;">
                    <input type="checkbox" name="newsletter" value="1" {{ old('newsletter', $user->newsletter) ? 'checked' : '' }} style="cursor: pointer;">
                    <span style="font-size: 0.9rem; color: #4b5563;">Subscribe to newsletter digest</span>
                </div>
                
                <div style="border-top: 1px solid #f3f4f6; margin: 1.5rem 0; padding-top: 1.5rem;">
                    <h4 style="font-size: 0.9rem; font-weight: 700; margin-bottom: 1rem;">Change Password</h4>
                    <div style="margin-bottom: 0.8rem;">
                        <input type="password" name="password" placeholder="New Password" style="width: 100%; padding: 0.6rem; border: 1px solid #d1d5db; border-radius: 6px;">
                        @error('password') <span style="color: #ef4444; font-size: 0.75rem;">{{ $message }}</span> @enderror
                    </div>
                    <div style="margin-bottom: 1.5rem;">
                        <input type="password" name="password_confirmation" placeholder="Confirm New Password" style="width: 100%; padding: 0.6rem; border: 1px solid #d1d5db; border-radius: 6px;">
                    </div>
                </div>

                <button type="submit" style="width: 100%; padding: 0.75rem; background-color: #111827; color: #fff; border: none; border-radius: 6px; font-weight: 600; cursor: pointer;">Save Changes</button>
            </form>
        </div>

        <!-- Bookmarked items -->
        <div>
            <h3 style="font-size: 1.2rem; margin-bottom: 1.5rem; font-weight: 600;">Saved Bookmarks</h3>
            @if($bookmarks->count() > 0)
                <div style="display: flex; flex-direction: column; gap: 1rem;">
                    @foreach($bookmarks as $bookmark)
                        @if($bookmark->post)
                            <div style="background-color: #fff; border: 1px solid #e5e7eb; border-radius: 12px; padding: 1.2rem; display: flex; justify-content: space-between; align-items: center; box-shadow: 0 1px 2px rgba(0,0,0,0.05);">
                                <div style="min-width: 0;">
                                    <h4 style="font-size: 1.05rem; font-family: 'Playfair Display', serif; margin: 0; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">
                                        <a href="{{ route('posts.show', $bookmark->post->slug) }}" style="color: #111827; text-decoration: none;">{{ $bookmark->post->title }}</a>
                                    </h4>
                                    <span style="font-size: 0.8rem; color: #6b7280; font-family: 'Space Mono', monospace;">Saved {{ $bookmark->created_at->diffForHumans() }}</span>
                                </div>
                                <form action="{{ route('bookmarks.destroy', $bookmark->post->id) }}" method="POST" style="margin-left: 1rem;">
                                    @csrf 
                                    @method('DELETE')
                                    <button type="submit" style="background: none; border: none; cursor: pointer; color: #b45309; font-size: 0.85rem; font-weight: 600;">Remove</button>
                                </form>
                            </div>
                        @endif
                    @endforeach
                </div>
            @else
                <div style="text-align: center; padding: 3rem 1.5rem; border: 1px dashed #d1d5db; border-radius: 12px; background-color: #f9fafb;">
                    <p style="color: #6b7280; font-size: 0.95rem;">You haven't bookmarked any articles yet.</p>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
