@extends('main')
@section('title', 'Edit Soal')
@section('content')
<div class="d-flex text-secondary pb-5">
    @include('components.sidebar')
    <div class="container-fluid" style="padding-left: 250px">
        @include('components.navbar')
        <div class="px-4 mt-4">
            <div class="card border-0 shadow p-4">
                <div class="d-flex justify-content-between">
                    <h5>Edit Soal</h5>
                </div>
                <hr>
                <form action="{{ route('update.soal', $soal->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <h4>Gambar:</h4>
                    @if ($soal->image)
                        <img src="{{ asset('storage/'.$soal->image) }}" alt="gambar soal" width="200" class="mb-2">
                    @endif
                    <div class="mb-3">
                        <label>Ganti Gambar (opsional)</label>
                        <input class="form-control" type="file" name="image">
                    </div>
                    <hr>
                    <h4>Pertanyaan:</h4>
                    <div class="mb-3">
                        <input class="form-control" type="text" name="pertanyaan" value="{{ $soal->pertanyaan }}" required>
                    </div>
                    <hr>
                    <h4>Pilihan Jawaban:</h4>
                    @foreach (['A', 'B', 'C', 'D'] as $opsi)
                        <div class="mb-3">
                            <label>{{ $opsi }}</label>
                            <input class="form-control" type="text" name="pilihan[{{ $opsi }}]" value="{{ $soal->pilihan->where('opsi', $opsi)->first()->isi_pilihan ?? '' }}" required>
                        </div>
                    @endforeach
                    <div class="mb-3">
                        <label>Jawaban Benar</label>
                        <input class="form-control" type="text" name="jawaban_benar" maxlength="1" value="{{ $soal->jawaban_benar }}" required>
                    </div>
                    <div class="mt-3">
                        <button type="submit" class="btn btn-success">Update Soal</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
