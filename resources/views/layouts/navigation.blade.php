<nav class="custom-navbar">
    <!-- Left section: logo and links -->
    <div class="flex items-center space-x-6">
        <!-- Nav links -->
        <div class="flex items-center space-x-4">
        <span class="navbar-title">MyBlog</span>
            <a href="{{ route('profile.myprofile') }}">My Profile</a>
            <a href="{{ route('posts.index') }}">Feed</a>
            <a href="{{ route('posts.create') }}">Create Post</a>
        </div>
    </div>

    <!-- Right section: user dropdown -->
    <div class="flex items-center">
        <div class="dropdown relative">
            <button class="text-white font-medium">
                {{ optional(Auth::user())->name }}
                <span>&#9662;</span>
            </button>

            <div class="dropdown-menu absolute hidden mt-2 right-0 bg-white text-black rounded shadow-md">
    <form action="{{ route('logout') }}" method="POST" class="logout-form block px-4 py-2 hover:bg-gray-100">
        @csrf
        <button type="submit" class="logout-button">
            Logout
        </button>
    </form>
</div>


        </div>
    </div>
</nav>
