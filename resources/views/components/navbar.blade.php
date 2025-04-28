<div class="px-4 pt-3">
    <nav class="navbar text-secondary navbar-expand-lg rounded-3 shadow bg-white px-1">
        <div class="container-fluid">
            <a class="navbar-brand fw-bold text-secondary">Hello, {{ $user->name }}</a>
            <div class="collapse navbar-collapse">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <form action="{{ route('logout') }}" method="POST">
                            @csrf
                            <button type="submit" class="btn text-secondary">Logout</button>
                        </form>
                    </li>
                    <li class="nav-item">
                        @if ($user->avatar)
                        <a href="{{ route('profile') }}">
                            <img src="{{ asset('storage/' . $user->avatar) }}" width="35" height="35" class="rounded-circle" alt="">
                        </a>
                        @else
                        <a href="{{ route('profile') }}">
                            <img src="{{ asset('images/profile-default.png') }}" width="35" height="35" class="rounded-circle" alt="">
                        </a>
                        @endif
                    </li>
                </ul>
            </div>
        </div>
    </nav>
</div>
