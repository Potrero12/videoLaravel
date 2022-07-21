<hr />

<h2>Comentarios</h2>    
<hr />

@if (session('message'))
    <div class="alert alert-success">
        {{session('message') }}
    </div>
@endif

@if (isset($video->comments))
    
    <div id="comment-list">
        @foreach ($video->comments as $comment)   
            <div class="comment-item col-md-12 pull-left">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">{{$comment->user->name}} hace {{' | '.\FormatTime::LongTimeFilter($comment->created_at)}}</h4>
                        <hr />
                        <p>{{$comment->body}}</p>

                        
                    @if (Auth::check() && (Auth::user()->id == $comment->user_id || Auth::user()->id == $video->user_id))
                            
                        <div class="actions">
                            <a href="" class="btn btn-sm btn-primary">Actualizar</a>
                            <a href="{{ route('comment.delete', ['comment_id' => $comment->id]) }}" class="btn btn-sm btn-danger">Borrar</a>
                        </div>

                    @endif

                    </div>
                </div>

            </div>
        @endforeach
    </div>

@endif
<br />
@if (Auth::check())
    <form action="{{ route('comment.store') }}"  method="POST">
        @csrf

        <input type="hidden" name="video_id"  value="{{$video->id}}" required />
        <p>
            <textarea name="body"class="form-control" required></textarea>
        </p>
        
        <input type="submit" value="Comentar"  class="btn btn-success"/>

    </form>
@endif
