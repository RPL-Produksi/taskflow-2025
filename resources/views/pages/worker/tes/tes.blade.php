@extends('main')
@push('css')
@endpush
@section('title', 'Tes')
@section('content')
    <div class="d-flex text-secondary">
        @include('components.sidebar')
        <div class="container-fluid" style="padding-left: 250px">
            @include('components.navbar')
            <div class="px-4">
                <div class="card border-0 shadow p-3 mt-4">
                    <div class="d-flex justify-content-between">
                        <h5>Daftar Tes</h5>
                    </div>
                </div>
                @if (session('success'))
                    <div class="alert alert-success mt-4 shadow">
                        {{ session('success') }}
                    </div>
                @endif
                <div class="row">
                    @foreach ($tes as $item)
                        <div class="col-3 mt-3">
                            <div class="card border-0 shadow">
                                <div class="position-relative">
                                    @if ($item->status == 'sudah_mengerjakan' && $item->tes->hasilTes)
                                        <span class="badge bg-success position-absolute top-0 end-0 m-2">
                                            {{ $item->tes->hasilTes->nilai }}%
                                        </span>
                                    @endif
                                
                                    @if ($item->tes->image)
                                        <img src="{{ asset('storage/' . $item->tes->image) }}" height="250"
                                            style="object-fit: cover" class="img-card-top" alt="">
                                    @else
                                        <img src="{{ asset('images/default-image.avif') }}" height="250"
                                            style="object-fit: cover" class="img-card-top" alt=""/>
                                    @endif
                                </div>
                                
                                <div class="card-body">
                                    <h3 class="card-title">{{ Str::limit($item->tes->title, 16) }}</h3>
                                    <p>{{ Str::limit($item->tes->description, 115) }}</p>
                                    <div class="d-flex mb-2">
                                        @php
                                        $isDeadlinePassed = \Carbon\Carbon::now()->gt(\Carbon\Carbon::parse($item->tes->deadline));
                                    @endphp
                                    
                                    @if ($item->status == 'sudah_mengerjakan')
                                        <button class="btn btn-secondary w-100" disabled>Sudah Dikerjakan</button>
                                    @elseif ($isDeadlinePassed)
                                        <button class="btn btn-danger w-100" disabled>Deadline Terlewat</button>
                                    @else
                                        <a href="{{ route('start.tes', $item->tes->id) }}" class="btn btn-primary w-100">Kerjakan</a>
                                    @endif
                                    
                                    </div>
                                    <div>
                                        <small>Deadline : {{ $item->tes->deadline }}</small>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
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
