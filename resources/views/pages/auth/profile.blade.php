@extends('main')
@push('css')
<style>
    @media(min-width: 1200px) {
        .wrap {
            padding-left: 270px;
        }
    }
</style>
@endpush
@section('title', 'Profile')
@section('content')
    <div class="d-flex text-secondary pb-5">
        @include('components.sidebar')
        <div class="container-fluid wrap">
            @include('components.navbar')
            <div class="px-4">
                <div class="card border-0 shadow p-3 mt-4">
                    <div class="d-flex justify-content-between">
                        <h5>My Profile</h5>
                    </div>
                </div>
                @if (session('success'))
                    <div class="alert alert-success mt-3 shadow">
                        {{ session('success') }}
                    </div>
                @endif
                <div class="row mt-3">
                    <div class="col-xl-4">
                        <div class="card shadow border-0 p-3" style="min-height: 28rem">
                            <h5>😎Avatar</h5>
                            <hr>
                            <div class="d-flex justify-content-center">
                                @if ($user->avatar)
                                    <img src="{{ asset('storage/' . $user->avatar) }}" height="200" width="200"
                                        class="shadow rounded-circle" alt="" style="object-fit: cover">
                                @else
                                    <img src="{{ asset('images/profile-default.png') }}" height="200" width="200"
                                        class="shadow rounded-circle" alt="" style="object-fit: cover">
                                @endif
                            </div>
                            <form action="{{ route('update.profile', $user->id) }}" method="POST"
                                enctype="multipart/form-data" >
                                @csrf
                                <input name="avatar" type="file" class="form-control mt-4" required>
                                <button class="btn btn-primary mt-3">Ubah avatar</button>
                            </form>
                        </div>
                    </div>
                    <div class="col-xl-4 mt-3">
                        <div class="card shadow border-0 p-3" style="min-height: 28rem">
                            <h5>😊Personal</h5>
                            <hr>
                            <form action="{{ route('update.profile', $user->id) }}" method="POST"
                                enctype="multipart/form-data">
                                @csrf
                                <div>
                                    <label for="">Name</label>
                                    <input name="name" value="{{ $user->name }}" type="text" class="form-control"
                                        required>
                                </div>
                                <div class="mt-3">
                                    <label for="">Username</label>
                                    <input name="username" value="{{ $user->username }}" type="text" class="form-control"
                                        required>
                                </div>
                                <button class="btn btn-primary mt-3">Ubah personal</button>
                            </form>
                        </div>
                    </div>
                    <div class="col-xl-4 mt-3">
                        <div class="card shadow border-0 p-3" style="min-height: 28rem">
                            <h5>🔒Password</h5>
                            <hr>
                            <form action="{{ route('update.profile', $user->id) }}" method="POST"
                                enctype="multipart/form-data">
                                @csrf
                                <label for="">Password</label>
                                <input name="password" type="password" placeholder="Masukan password baru" class="form-control" required>
                                <button class="btn btn-primary mt-3">Ubah password</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('js')
    <script>
        $(document).ready(function() {
            $('#dataTable').DataTable();
        });
    </script>
@endpush
