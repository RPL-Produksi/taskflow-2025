@extends('main')
@push('css')
@endpush
@section('title', 'Tambah Tes')
@section('content')
    <div class="d-flex text-secondary">
        @include('components.sidebar')
        <div class="container-fluid" style="padding-left: 250px">
            @include('components.navbar')
            <div class="px-4 mt-4">
                <div class="card border-0 shadow p-4">
                    <div class="d-flex justify-content-between">
                        <h5>Tambah Tes</h5>
                    </div>
                    <hr>
                    <form action="{{ route('store.tes') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div>
                            <label for="title">Judul Tes</label>
                            <input type="text" class="form-control" name="title" required>
                        </div>
                        <div class="mt-3">
                            <label for="description">Deskripsi (opsional)</label>
                            <textarea name="description" class="form-control" id=""></textarea>
                        </div>
                        <div class="mt-3">
                            <label for="image">Image (opsional)</label>
                            <input type="file" class="form-control" name="image">
                        </div>
                        <div class="mt-3">
                            <label for="image">Deadline (opsional)</label>
                            <input type="date" class="form-control" name="deadline">
                        </div>
                        <div class="mt-3">
                            <button type="submit" class="btn btn-primary">Tambah</button>
                        </div>
                    </form>
                    {{-- <form action="{{ route('store.task') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <h4>Gambar :</h4>
                        <div class="mb-3">
                            <label>Gambar soal (opsional)</label>
                            <input class="form-control" type="file" name="pertanyaan" required>
                        </div>
                        <hr>
                        <h4>Pertanyaan :</h4>
                        <div class="mb-3">
                            <label>Soal</label>
                            <input class="form-control" type="text" name="pertanyaan" required>
                        </div>
                        <hr>
                        <h4>Pilihan Jawaban:</h4>
                        <div class="mb-3">
                            <label>A</label>
                            <input class="form-control" type="text" name="pilihan[A]" required>
                        </div>
                        <div class="mb-3">
                            <label>B</label>
                            <input class="form-control" type="text" name="pilihan[B]" required>
                        </div>
                        <div class="mb-3">
                            <label>C</label>
                            <input class="form-control" type="text" name="pilihan[C]" required>
                        </div>
                        <div class="mb-3">
                            <label>D</label>
                            <input class="form-control" type="text" name="pilihan[D]" required>
                        </div>
                        <div class="mb-3">
                            <label>Jawaban Benar (A/B/C/D)</label>
                            <input class="form-control" type="text" name="jawaban_benar" maxlength="1" required>
                        </div>
                        <div class="mt-3">
                            <button type="submit" class="btn btn-primary">Simpan Soal</button>
                        </div>
                    </form> --}}
                </div>
            </div>
        </div>
    </div>
@endsection
@push('js')
@endpush
