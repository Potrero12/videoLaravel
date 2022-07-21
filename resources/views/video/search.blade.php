@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="container">

            <h2>Busqueda: {{$search}}</h2>

            <form class="col-md-3 pull-rightt"  method="GET" action="{{route('video.search', ["search" => $search])}}">
                <label for="filter">Ordenar</label>
                <select name="filter" class="form-control">
                    <option value="new">Mas nuevos</option>
                    <option value="old">Mas antiguos</option>
                    <option value="alfa">De la A a la Z</option>
                </select>
                <br />
                <input type="submit" value="Ordernar" class="btn btn-sm btn-success"/>
            </form>

            <div class="clearfix"></div>
            <br />
            @include('video.videosList')
        </div>
    </div>
</div>
@endsection