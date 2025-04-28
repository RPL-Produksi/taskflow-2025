<div class="py-3 ps-4 text-secondary">
    <div class="position-fixed py-3 rounded-3 bg-white shadow" style="width: 250px; height: 96vh;">
        <h5 class="text-center fw-bold">Todo List</h5>
        <div class="px-4 py-2 mb-2">
            <div class="bg-secondary" style="height: 2px;"></div>
        </div>
        <div class="px-4">
            <ul class="navbar-nav">
                @if ($user->role == 'admin')
                <small>Home</small>
                    <li class="nav-item px-2">
                        <a href="{{ route('dashboard.admin') }}" class="nav-link"><i class="fa-solid fa-home me-1"></i> Dashboard</a>
                    </li>
                    <small class="mt-4">Menu</small>
                    <li class="nav-item px-2">
                        <a href="{{ route('manage.tasker') }}" class="nav-link"><i class="fa-solid fa-user me-1"></i> Kelola Tasker</a>
                    </li>
                    <li class="nav-item px-2">
                        <a href="{{ route('manage.worker') }}" class="nav-link"><i class="fa-solid fa-user me-1"></i> Kelola Worker</a>
                    </li>
                @endif
                @if ($user->role == 'tasker')
                <small>Home</small>
                    <li class="nav-item px-2">
                        <a href="{{ route('dashboard.tasker') }}" class="nav-link"><i class="fa-solid fa-home me-1"></i> Dashboard</a>
                    </li>
                    <small class="mt-4">Menu</small>
                    <li class="nav-item px-2">
                        <a href="{{ route('manage.task') }}" class="nav-link"><i class="fa-solid fa-clipboard me-1"></i> Kelola Task</a>
                    </li>
                @endif
                @if ($user->role == 'worker')
                <small>Home</small>
                    <li class="nav-item px-2">
                        <a href="{{ route('dashboard.worker') }}" class="nav-link"><i class="fa-solid fa-home me-1"></i> Dashboard</a>
                    </li>
                    <small class="mt-3">Menu</small>
                    <li class="nav-item px-2">
                        <a href="{{ route('task') }}" class="nav-link"><i class="fa-solid fa-clipboard me-1"></i> My Task</a>
                    </li>
                @endif
            </ul>
        </div>
    </div>
</div>
