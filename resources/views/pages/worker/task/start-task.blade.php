@extends('main')
@push('css')
@endpush
@section('title', 'Start Task')
@section('content')
    <div class="d-flex text-secondary">
        @include('components.sidebar')

        <div class="container-fluid" style="margin-left: 250px">
            @include('components.navbar')
            <div class="px-4">
                <div class="card border-0 shadow p-3 mt-4">
                    <div class="d-flex justify-content-between">
                        <h5>Start Task</h5>
                    </div>
                </div>
                <div class="card border-0 shadow p-3 mt-4">
                    <h5>List Subtask yg ditugaskan</h5>
                    <hr>
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
                    <table class="table table-bordered text-secondary" id="dataTable">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Title</th>
                                <th>Progress</th>
                                <th>Image</th>
                                <th>Comment</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($subtask as $item)
                                @php
                                    $progress = $item->subtaskWorker->where('user_id', $user->id)->first();

                                    if (!$progress) {
                                        $status = 'pending';
                                    } else {
                                        $status = $progress->status;
                                    }

                                    if (!$progress) {
                                        $image = 'belum upload image';
                                    } else {
                                        $image = $progress->image;
                                    }

                                    if (!$progress) {
                                        $comment = '';
                                    } else {
                                        $comment = $progress->comment;
                                    }
                                @endphp
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $item->title }}</td>
                                    <td>
                                        @if ($status == 'pending')
                                        <p class="btn btn-danger">{{ $status }}</p>
                                        @endif
                                        @if ($status == 'rejected')
                                        <p class="btn btn-danger">{{ $status }}</p>
                                        @endif
                                        @if ($status == 'in_progress')
                                        <p class="btn btn-warning text-white">{{ $status }}</p>
                                        @endif
                                        @if ($status == 'in_review')
                                        <p class="btn btn-primary">{{ $status }}</p>
                                        @endif
                                        @if ($status == 'done')
                                        <p class="btn btn-success">{{ $status }}</p>
                                        @endif
                                    </td>
                                    <td>
                                        @if ($progress && !empty($progress->image))
                                            <a href="{{ asset('storage/' . $image) }}" class="btn btn-primary"><i
                                                    class="fa-solid fa-image"></i></a>
                                        @endif
                                    </td>
                                    <td>{{ $comment }}</td>
                                    <td class="d-flex">
                                        @if ($status == 'pending')
                                            <form action="{{ route('progress') }}" method="POST">
                                                @csrf
                                                <button type="submit"
                                                    onclick="return confirm('Yakin ingin memulai subtask ini?')"
                                                    class="btn btn-danger text-white"><i
                                                        class="fa-solid fa-check"></i></button>
                                                <input type="hidden" name="subtask_id" value="{{ $item->id }}">
                                            </form>
                                        @endif
                                        @if ($status == 'rejected')
                                            <form action="{{ route('ulang', $progress->id) }}" method="POST">
                                                @csrf
                                                <button type="submit"
                                                    onclick="return confirm('Yakin ingin memulai subtask ini?')"
                                                    class="btn btn-danger text-white"><i
                                                        class="fa-solid fa-check"></i></button>
                                                <input type="hidden" name="subtask_id" value="{{ $item->id }}">
                                            </form>
                                        @endif
                                        @if ($status == 'in_progress')
                                            <form action="{{ route('review', $progress->id) }}" method="POST"
                                                class="d-flex" enctype="multipart/form-data">
                                                @csrf
                                                <button type="submit"
                                                    onclick="return confirm('Yakin sudah mengirim foto bukti yg benar?')"
                                                    class="btn btn-warning text-white me-2"><i class="fa-solid fa-check"></i></button>
                                                <input type="file" class="form-control" name="image" required>
                                            </form>
                                        @endif
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
