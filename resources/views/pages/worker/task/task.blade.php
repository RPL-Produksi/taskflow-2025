@extends('main')
@push('css')
@endpush
@section('title', 'Task')
@section('content')
    <div class="d-flex text-secondary">
        @include('components.sidebar')
        <div class="container-fluid" style="padding-left: 250px">
            @include('components.navbar')
            <div class="px-4">
                <div class="card border-0 shadow p-3 mt-4">
                    <div class="d-flex justify-content-between">
                        <h5>Daftar Task</h5>
                    </div>
                </div>
                @if (session('success'))
                    <div class="alert alert-success mt-4 shadow">
                        {{ session('success') }}
                    </div>
                @endif
                <div class="row">
                    @foreach ($task as $item)
                        <div class="col-3 mt-3">
                            <div class="card border-0 shadow">
                                @php
                                    function getYoutubeEmbedUrl($url)
                                    {
                                        if (strpos($url, 'youtu.be/') !== false) {
                                            $videoId = explode('/', parse_url($url, PHP_URL_PATH))[1];
                                        } elseif (strpos($url, 'watch?v=') !== false) {
                                            parse_str(parse_url($url, PHP_URL_QUERY), $query);
                                            $videoId = $query['v'] ?? null;
                                        } else {
                                            $videoId = null;
                                        }

                                        return $videoId ? 'https://www.youtube.com/embed/' . $videoId : null;
                                    }

                                    $videoEmbedUrl = getYoutubeEmbedUrl($item->task->video);
                                @endphp
                                @if ($item->task->video)
                                    @if ($videoEmbedUrl)
                                        <iframe height="250" src="{{ $videoEmbedUrl }}" title="YouTube video player"
                                            frameborder="0"
                                            allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
                                            referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>
                                    @else
                                        <p>Video URL tidak valid.</p>
                                    @endif
                                @elseif ($item->task->image)
                                    <img src="{{ asset('storage/' . $item->task->image) }}" height="250"
                                        style="object-fit: cover" class="img-card-top" alt="">
                                @else
                                    <img src="{{ asset('images/default-image.avif') }}" height="250"
                                        style="object-fit: cover" class="img-card-top" alt="">
                                @endif
                                <div class="card-body">
                                    <h3 class="card-title">{{ Str::limit($item->task->title, 16) }}</h3>
                                    <p>{{ Str::limit($item->task->description, 115) }}</p>
                                    <div class="d-flex mb-2">
                                        <a href="{{ route('subtask', $item->task->id) }}"
                                            class="btn btn-primary w-100">Kerjakan</a>
                                    </div>
                                    <small>Assigned by : {{ $item->task->user->name }}</small>
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
