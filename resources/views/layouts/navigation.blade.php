<nav class="custom-navbar">
    <div class="flex items-center">
        <!-- Logo -->
        <div class="logo mr-6">
            <a href="{{ route('dashboard') }}" class="text-white text-lg font-bold">
                MyBlog
            </a>
        </div>

        <!-- Navigation Links -->
        <div>
            <a href="{{ route('dashboard') }}">Dashboard</a>
            <a href="{{ route('posts.index') }}">Posts</a>
            <a href="{{ route('posts.create') }}">Create Post</a>
        </div>
    </div>

    <!-- Settings Dropdown -->
    <div class="flex items-center">
        <div class="dropdown">
            <button class="text-white font-medium">
                {{ Auth::user()->name }}
                <span>&#9662;</span> <!-- Down arrow -->
            </button>
            <div class="dropdown-menu">
                <a href="{{ route('profile.edit') }}">Profile</a>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="block w-full text-left">Log Out</button>
                </form>
            </div>
        </div>
    </div>
</nav>
