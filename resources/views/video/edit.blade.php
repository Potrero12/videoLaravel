@extends('layouts.app')

@section('content')
    <div class="container">

        <div class="row">
            <h2>Editando {{$video->title}}</h2>
            <hr />
            <form action="{{ route('video.update', ['video_id' => $video->id]) }}" method="POST" enctype="multipart/form-data" class="col-lg-7">
                @csrf
    
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{$error}}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
    
                <div class="form-group">
                    <label for="title">Titulo</label>
                    <input type="text" name="title" id="title" class="form-control" value="{{$video->title}}"/>
                </div>
    
    
                <div class="form-group">
                    <label for="description">Descripcion</label>
                    <textarea class="form-control" name="description" id="description" cols="30" rows="10" >{{$video->description}}</textarea>
                </div>
    
                <div class="form-group">
                    <label for="image">Miniatura</label>
                    @if (Storage::disk('images')->has($video->image))
                        <div class="video-image-thumb">
                            <div class="video-image-mask">
                                <img src="{{ route('video.getImage', ['filename' => $video->image]) }}" class="video-image"/>
                            </div>
                        </div>
                    @endif
                    <input type="file" class="form-control" name="image" id="image" value="{{old('image')}}"/>
                </div>
    
                <div class="form-group">
                    <label for="video">Archivo de Video</label>
                    <video controls id="video-player">
                        <source src="{{ route('video.getVideo', ['filename' => $video->video_path]) }}" />
                        Tu navegador no es compatible con html
                    </video>
                    <input type="file" name="video" id="video" class="form-control" value="{{old('video')}}"/>
                </div>
    
                <input type="submit" value="Editar" class="btn btn-success"/>
            </form>
        </div>

    </div>
@endsection