@extends('main')
@push('css')
@endpush
@section('title', 'View Worker')
@section('content')
    <div class="d-flex text-secondary">
        @include('components.sidebar')
        <div class="container-fluid" style="padding-left: 250px">
            @include('components.navbar')
            <div class="px-4">
                <div class="card border-0 shadow p-3 mt-4">
                    <div class="d-flex justify-content-between">
                        <h5>View Worker</h5>
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
                    <table class="table table-bordered text-secondary text-secondary" id="dataTable">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Title</th>
                                <th>Progress</th>
                                <th>Image</th>
                                <th>Keterangan</th>
                                <th>Comment</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($subtask as $item)
                                @php
                                    $progress = $item->subtaskWorker->where('user_id', $worker->id)->first();
                                @endphp
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $item->title }}</td>
                                    <td>
                                        @php
                                            if (!$progress) {
                                                $status = 'pending';
                                            } else {
                                                $status = $progress->status;
                                            }

                                            if (!$progress) {
                                                $image = 'Belum upload image';
                                            } else {
                                                $image = $progress->image;
                                            }

                                            if (!$progress) {
                                                $comment = 'Belum ada komen';
                                            } else {
                                                $comment = $progress->comment;
                                            }

                                            if (!$progress) {
                                                $keterangan = '';
                                            } else {
                                                $keterangan = $progress->information;
                                            }
                                        @endphp
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
                                    <td>
                                        {{ $keterangan }}
                                    </td>
                                    <td>
                                        {{ $comment }}
                                    </td>
                                    <td>
                                        @if ($status == 'in_review')
                                            <form action="{{ route('acc', $progress->id) }}" method="POST" class="d-flex">
                                                @csrf
                                                <button type="submit" onclick="return confirm('Acc subtask ini?')"
                                                    class="btn btn-success me-2"><i class="fa-solid fa-check"></i></button>
                                                <input placeholder="Masukan komentar" type="text" name="comment"
                                                    class="form-control">
                                            </form>
                                            <form action="{{ route('cancel', $progress->id) }}" method="POST"
                                                class="d-flex mt-3">
                                                @csrf
                                                <button type="submit" onclick="return confirm('Tolak subtask ini?')"
                                                    class="btn btn-danger me-2"><i class="fa-solid fa-xmark"></i></button>
                                                <input type="text" placeholder="Masukan komentar" name="comment"
                                                    class="form-control">
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
