@extends('layouts.app')

@section('content')
    <div class="container">
        <h2>{{ $video->title }}</h2>
        <hr />

        <div class="col-md-8">
            {{-- video --}}

            <video controls id="video-player">
                <source src="{{ route('video.getVideo', ['filename' => $video->video_path]) }}" />
                Tu navegador no es compatible con html
            </video>

            {{-- descripcion --}}

            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Subido por <strong><a href="{{route('user.channel', ['user_id' => $video->user_id])}}">{{$video->user->name}}</a></strong> hace {{' | '.\FormatTime::LongTimeFilter($video->created_at)}}</h4>
                    <hr />
                    <h5 class="card-title">{{$video->title}}</h5>
                    <p>{{$video->description}}</p>
                    
                </div>
            </div>

            {{-- comentarios --}}
            @include('video.comment')

        </div>
    </div>
@endsection