@extends('main')
@push('css')

@endpush
@section('title', 'Kelola Tasker')
@section('content')
<div class="d-flex text-secondary">
@include('components.sidebar')
    <div class="container-fluid" style="padding-left: 250px">
        @include('components.navbar')
        <div class="px-4 mt-4">
            <div class="card border-0 shadow p-4">
                <div class="d-flex justify-content-between">
                    <h5>Kelola Tasker</h5>
                    <a href="{{ route('add.tasker') }}" class="btn btn-primary">Tambah Tasker</a>
                </div>
                <hr>
                @if (session('success'))
                    <div class="alert alert-success p-2">
                        {{ session('success') }}
                    </div>
                @endif
                <table class="table table-bordered text-secondary" id="dataTable">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Avatar</th>
                            <th>Name</th>
                            <th>Username</th>
                            <th>Role</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($tasker as $item)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>
                                    @if ($item->avatar)
                                        <img src="{{ asset('storage/' . $item->avatar) }}" height="40" width="40" class="rounded-circle" style="object-fit: cover" alt="">
                                    @else
                                        <img src="{{ asset('images/profile-default.png') }}" height="40" width="40" class="rounded-circle" style="object-fit: cover" alt="">
                                    @endif
                                </td>
                                <td>{{ $item->name }}</td>
                                <td>{{ $item->username }}</td>
                                <td>{{ $item->role }}</td>
                                <td class="d-flex">
                                    <a href="{{ route('edit.tasker', $item->id) }}" class="btn btn-primary me-1"><i class="fa-solid fa-pen-to-square"></i></a>
                                    <form action="{{ route('delete.tasker', $item->id) }}" method="POST">
                                        @csrf
                                        <button type="submit" class="btn btn-danger" onclick="return confirm('Yakin ingin menghapus tasker ini?')"><i class="fa-solid fa-trash"></i></button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
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
