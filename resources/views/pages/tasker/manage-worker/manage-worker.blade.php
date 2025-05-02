@extends('main')
@push('css')
<style>
    @media(min-width: 1200px) {
        .wrap {
            padding-left: 250px;
        }
    }
</style>
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
@endpush
@section('title', 'Kelola Worker')
@section('content')
    <div class="d-flex text-secondary pb-5">
        @include('components.sidebar')
        <div class="container-fluid wrap">
            @include('components.navbar')
            <div class="px-4">
                <div class="card border-0 shadow p-3 mt-4">
                    <div class="d-flex justify-content-between">
                        <h5>Assign Worker</h5>
                    </div>
                </div>
                <div class="card border-0 shadow p-3 mt-4">
                    <h5>Tambah Worker</h5>
                    <hr>
                    <form action="{{ route('store.taskworker') }}" method="POST">
                        @csrf
                        <div class="d-flex">
                            <select name="user_id[]" class="form-control me-2 select-worker" multiple>
                                @foreach ($worker as $item)
                                    <option value="{{ $item->id }}">{{ $item->name }}</option>
                                @endforeach
                            </select>
                            <input type="hidden" name="task_id" value="{{ $task->id }}">
                            <button type="submit" class="btn btn-primary ms-2">Tambah</button>
                        </div>
                    </form>

                    @if (session('success'))
                        <div class="alert alert-success mt-4">
                            {{ session('success') }}
                        </div>
                    @endif
                    @if (session('error'))
                        <div class="alert alert-danger mt-4">
                            {{ session('error') }}
                        </div>
                    @endif
                    <div class="table-responsive">
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
                                @foreach ($taskWorker as $item)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>
                                            @if ($item->avatar)
                                                <img src="{{ asset('storage/' . $item->user->avatar) }}" height="40"
                                                    width="40" class="rounded-circle" style="object-fit: cover"
                                                    alt="">
                                            @else
                                                <img src="{{ asset('images/profile-default.png') }}" height="40"
                                                    width="40" class="rounded-circle" style="object-fit: cover"
                                                    alt="">
                                            @endif
                                        </td>
                                        <td>{{ $item->user->name }}</td>
                                        <td>{{ $item->user->username }}</td>
                                        <td>{{ $item->user->role }}</td>
                                        <td class="d-flex">
                                            <a href="{{ route('manage.subtaskworker', ['task' => $task->id, 'worker' => $item->user_id]) }}"
                                                class="btn btn-primary me-1"><i class="fa-solid fa-eye"></i></a>
                                            <form action="{{ route('delete.taskworker', $item->id) }}" method="POST">
                                                @csrf
                                                <button type="submit"
                                                    onclick="return confirm('Yakin ingin menghapus subtask ini?')"
                                                    class="btn btn-danger"><i class="fa-solid fa-trash"></i></button>
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
    </div>
@endsection
@push('js')
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#dataTable').DataTable();
        });

        $(document).ready(function() {
            $('.select-worker').select2({
                placeholder: "Pilih worker",
                allowClear: true
            });
        });
    </script>
@endpush
