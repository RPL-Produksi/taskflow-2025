@extends('main')
@push('css')
    <style>
        .background {
            background-size: cover;
            background-image: url({{ asset('images/login-bg.jpg') }});
        }

        .card {
            backdrop-filter: blur(20px);
        }

        .blur {
            backdrop-filter: blur(20px);
        }
    </style>
@endpush
@section('title', 'Login')
@section('content')
    <div class="d-flex justify-content-center align-items-center background text-white" style="height: 100vh">
        <div class="card border-0 shadow p-4 bg-transparent" style="width: 35%">
            <h2 class="text-center fw-bold">Login</h4>
            <p class="text-center">Lorem ipsum, dolor sit amet consectetur adipisicing elit. Vel commodi quod molestias similique. Atque, rerum.</p>
            <form action="{{ route('login') }}" method="POST" class="mt-4">
                @csrf
                <div>
                    <label for="username"><i class="fa-regular fa-user"></i> Username</label>
                    <input type="text" class="form-control" required name="username">
                </div>
                <div class="mt-3">
                    <label for="password"><i class="fa-regular fa-lock"></i> Password</label>
                    <input type="password" class="form-control" required name="password">
                </div>
                <div class="mt-3">
                    @if (session('error'))
                        <div class="alert alert-danger p-2">
                            {{ session('error') }}
                        </div>
                    @endif
                    @if (session('success'))
                        <div class="alert alert-success p-2">
                            {{ session('success') }}
                        </div>
                    @endif
                </div>
                <div class="mt-3 d-flex">
                    <input type="checkbox" class="form-check me-1">
                    <div>
                        <small>Ingat saya</small>
                    </div>
                </div>
                <div class="mt-3">
                    <button type="submit" class="btn btn-primary w-100">Masuk</button>
                </div>
            </form>
        </div>
    </div>
@endsection
@push('js')

@endpush
