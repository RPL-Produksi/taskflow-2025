@extends('main')
@push('css')
<style>
    @media(min-width: 1200px) {
        .wrap {
            padding-left: 250px;
        }
    }
</style>
@endpush
@section('title', 'Dashboard Admin')
@section('content')
    <div class="d-flex text-secondary pb-5">
        @include('components.sidebar')
        <div class="container-fluid wrap">

            @include('components.navbar')
            <div class="px-4 mt-4">
                <div class="card border-0 shadow p-3">
                   <h5>Dashboard Admin</h5>
                </div>
                @if (session('success'))
                    <div class="alert alert-success mt-3 shadow">
                        {{ session('success') }}
                    </div>
                @endif
                <div class="row mt-3">
                    <div class="col-xl-2">
                        <div class="card text-white bg-primary shadow border-0 p-3">
                            <h5>Total Guru :</h5>
                            <h5><i class="fa-solid fa-users"></i> {{ $taskerCount }}</h5>
                        </div>
                    </div>
                    <div class="col-xl-2 mt-3 mt-xl-0">
                        <div class="card text-white bg-success shadow border-0 p-3">
                            <h5>Total Murid :</h5>
                            <h5><i class="fa-solid fa-users"></i> {{ $workerCount }}</h5>
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
