<div id="video-list">
    @if(count($videos) >= 1)
        @foreach ($videos as $video)
            <div class="card mb-3">
                <div class="row g-0">
                    <div class="col-md-3">
                        {{-- imagen del video --}}
                        @if (Storage::disk('images')->has($video->image))
                            <div class="video-image-thumb col-md-4 pull-left">
                                <div class="video-image-mask">
                                    <img src="{{ route('video.getImage', ['filename' => $video->image]) }}" class="video-image"/>
                                </div>
                            </div>
                        @endif
                    </div>
                    <div class="col-md-9">
                        <div class="card-body">
                            <h4 class="card-title"><a href="{{route('video.detail', ["video_id" => $video->id])}}">{{$video->title}}</a></h4>
                            <p class="card-text"><a href="{{route('user.channel', ['user_id' => $video->user_id])}}">{{$video->user->name}}</a></p>
                            <p class="card-text">{{$video->description}}</p>

                            <a href="{{ route('video.detail', ["video_id" => $video->id]) }}" class="btn btn-success">Ver</a>
                            @if (Auth::check() && Auth::user()->id == $video->user->id)
                                <a href="{{ route('video.edit', ["video_id" => $video->id]) }}" class="btn btn-warning">Editar</a>
                                <a href="{{route('video.delete', ['video_id' => $video->id])}}" class="btn btn-danger">Eliminar</a>
                            @endif

                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    @else
        <div class="alert alert-warning">No hay videos actualmente!!</div>
    @endif
    <div class="clearfix"></div>
    {{$videos->links()}}
</div>