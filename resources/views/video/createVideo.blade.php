@extends('layouts.app')

@section('content');
<div class="container">
    <div class="row">
        <h2>Crear Video</h2>
        <hr />
        <form action="{{ route('video.save') }}" method="POST" enctype="multipart/form-data" class="col-lg-7">
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
                <input type="text" name="title" id="title" class="form-control" value="{{old('title')}}"/>
            </div>


            <div class="form-group">
                <label for="description">Descripcion</label>
                <textarea class="form-control" name="description" id="description" cols="30" rows="10" value="{{old('description')}}"></textarea>
            </div>

            <div class="form-group">
                <label for="image">Miniatura</label>
                <input type="file" class="form-control" name="image" id="image" value="{{old('image')}}"/>
            </div>

            <div class="form-group">
                <label for="video">Archivo de Video</label>
                <input type="file" name="video" id="video" class="form-control" value="{{old('video')}}"/>
            </div>

            <input type="submit" value="Enviar" class="btn btn-success"/>
        </form>
    </div>
</div>
@endsection
