<nav class="custom-navbar">
    <div class="flex items-center">
        <!-- Logo -->
        <div class="logo mr-6">
            <h1 class="text-white text-lg font-bold">
                MyBlog
            </h1>
        </div>

        <!-- Navigation Links -->
        <div>
            <a href="{{ route('profile.myprofile') }}">My Profile</a>
            <a href="{{ route('posts.index') }}">Feed</a>
            <a href="{{ route('posts.create') }}">Create Post</a>
        </div>
    </div>

    <!-- Settings Dropdown -->
    <div class="flex items-center">
        <div class="dropdown">
            <button class="text-white font-medium">
                {{ optional(Auth::user())->name }}
                <span>&#9662;</span> <!-- Down arrow -->
            </button>
            <!-- Dropdown menu -->
            <div class="dropdown">
                <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                    <!-- Add logout button -->
                    <form action="{{ route('logout') }}" method="POST" class="dropdown-item">
                        @csrf
                        @method('POST')
                        <button type="submit" class="logout-button">Logout</button>
                    </form>
                </div>
            </div>

        </div>
    </div>
</nav>