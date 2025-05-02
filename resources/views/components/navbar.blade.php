<div class="px-4 pt-3">
    <nav class="navbar text-secondary navbar-expand-lg rounded-3 shadow bg-white px-1">
        <div class="container-fluid">
            <a class="navbar-brand fw-bold text-secondary">Hello, {{ $user->name }}</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent"
                aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav ms-auto d-none d-xl-block">
                    <div class="d-flex">
                        <li class="nav-item">
                            <form action="{{ route('logout') }}" method="POST">
                                @csrf
                                <button type="submit" class="btn text-secondary">Logout</button>
                            </form>
                        </li>
                        <li class="nav-item">
                            @if ($user->avatar)
                                <a href="{{ route('profile') }}">
                                    <img src="{{ asset('storage/' . $user->avatar) }}" width="35" height="35"
                                        class="rounded-circle" alt="">
                                </a>
                            @else
                                <a href="{{ route('profile') }}">
                                    <img src="{{ asset('images/profile-default.png') }}" width="35" height="35"
                                        class="rounded-circle" alt="">
                                </a>
                            @endif
                        </li>
                    </div>
                </ul>
                <ul class="navbar-nav ms-auto mb-2 mb-lg-0 d-block d-xl-none">
                    <hr>
                    @if ($user->role == 'admin')
                        <small>Home</small>
                        <li class="nav-item px-2">
                            <a href="{{ route('dashboard.admin') }}" class="nav-link"><i
                                    class="fa-regular fa-home me-1"></i> Dashboard</a>
                        </li>
                        <li class="nav-item px-2">
                            <a href="{{ route('profile') }}" class="nav-link"><i
                                    class="fa-regular fa-user me-1"></i> Profile</a>
                        </li>
                        <small class="mt-4">Menu</small>
                        <li class="nav-item px-2">
                            <a href="{{ route('manage.tasker') }}" class="nav-link"><i
                                    class="fa-regular fa-user me-1"></i> Kelola Guru</a>
                        </li>
                        <li class="nav-item px-2">
                            <a href="{{ route('manage.worker') }}" class="nav-link"><i
                                    class="fa-regular fa-user me-1"></i> Kelola Murid</a>
                        </li>
                    @endif
                    @if ($user->role == 'tasker')
                        <small>Home</small>
                        <li class="nav-item px-2">
                            <a href="{{ route('dashboard.tasker') }}" class="nav-link"><i
                                    class="fa-regular fa-home me-1"></i> Dashboard</a>
                        </li>
                        <li class="nav-item px-2">
                            <a href="{{ route('profile') }}" class="nav-link"><i
                                    class="fa-regular fa-user me-1"></i> Profile</a>
                        </li>
                        <small class="mt-4">Menu</small>
                        <li class="nav-item px-2">
                            <a href="{{ route('manage.task') }}" class="nav-link"><i
                                    class="fa-regular fa-clipboard me-1"></i> Kelola Task</a>
                        </li>
                        <li class="nav-item px-2">
                            <a href="{{ route('manage.tes') }}" class="nav-link"><i
                                    class="fa-regular fa-pen-to-square me-1"></i> Kelola Tes</a>
                        </li>
                    @endif
                    @if ($user->role == 'worker')
                        <small>Home</small>
                        <li class="nav-item px-2">
                            <a href="{{ route('dashboard.worker') }}" class="nav-link"><i
                                    class="fa-regular fa-home me-1"></i> Dashboard</a>
                        </li>
                        <li class="nav-item px-2">
                            <a href="{{ route('profile') }}" class="nav-link"><i
                                    class="fa-regular fa-user me-1"></i> Profile</a>
                        </li>
                        <small class="mt-3">Menu</small>
                        <li class="nav-item px-2">
                            <a href="{{ route('task') }}" class="nav-link"><i class="fa-regular fa-clipboard me-1"></i>
                                Task</a>
                        </li>
                        <li class="nav-item px-2">
                            <a href="{{ route('tes') }}" class="nav-link"><i
                                    class="fa-regular fa-pen-to-square me-1"></i> Tes</a>
                        </li>
                    @endif
                    <li class="nav-item px-2">
                        <form action="{{ route('logout') }}" method="POST">
                            @csrf
                            <button type="submit" class="nav-link btn w-100 text-start"><i class="fa-regular fa-sign-out me-1"></i> Logout</button>
                        </form>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
</div>
