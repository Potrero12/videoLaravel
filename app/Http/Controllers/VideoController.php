<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Auth;

use Symfony\Component\HttpFoundation\Response;
use Illuminate\Auth\Events\Validated;

use App\Models\Video;
use App\Models\Comment;

class VideoController extends Controller {
    
    public function createVideo() {
        return view('video.createVideo');
    }

    public function saveVideo(Request $request) {

        // validar campos
        $validate = $this->validate($request, [
            "title" => ['required'],
            "description" => ['required'],
            "image" => ['required', 'mimes:jpg,bmp,png,pneg'],
            "video" => ['mimetypes:video/avi,video/mpeg,video/quicktime,video/mp4,video/mp3']
        ]);

        // caputar los datos
        $titulo = $request->input('title');
        $description = $request->input('description');
        $image = $request->file('image');
        $videoName = $request->file('video');

        // instanciamos y asignamos los valores del los campos
        $video = new Video();
        $user = Auth::user();

        $video->user_id = $user->id;
        $video->title = $titulo;
        $video->description = $description;

        // subida de imagen
        if($image) {
            $image_path = time().$image->getClientOriginalName();
            Storage::disk('images')->put($image_path, File::get($image));
            $video->image = $image_path;
        }

        // subida de video
        if($videoName) {
            $video_path = time().$videoName->getClientOriginalName();
            Storage::disk('videos')->put($video_path, File::get($videoName));
            $video->video_path = $video_path;
        }

        // guardar el video
        $video->save();
        
        // redirigirmos a la pagina principal
        return redirect()->route('home')->with(["message" => "El video se subio correctamente"]);

    }

    // metodo para obtener la imagen del archivo
    public function getImage($filename) {

        $file = Storage::disk('images')->get($filename);

        return new Response($file, 200);

    }

    public function getVideoPage($video_id) {

        $video = Video::find($video_id);

        return view('video.detail', [
            "video" => $video
        ]);

    }

    public function getVideo($filename) {

        $file = Storage::disk('videos')->get($filename);

        return new Response($file, 200);

    }

    public function delete($video_id) {

        $user = Auth::user();
        $video = Video::find($video_id);
        $comments = Comment::where('video_id', $video_id)->get();

        if($user && $video->user_id == $user->id) {

            // eliminar comentarios
            if($comments && count($comments) >= 1) {
                foreach($comments as $commnet) {
                    $commnet->delete();
                }
            }

            // eliminar imagen del disco
            Storage::disk('images')->delete($video->image);
            Storage::disk('videos')->delete($video->video_path);

            // eliminar registros
            $video->delete();

            $message = ["messae" => "Video Eliminado Correctamente"];

        } else {
            $message = ["messae" => "Error al eliminar el video"];
        }

        return redirect()->route('home')->with($message);

    }

    public function edit($video_id) {
        $user = Auth::user();
        $video = Video::findOrFail($video_id);

        if($user && $video->user_id == $user->id) {

            return view('video.edit',[
                "video" => $video
            ]);

        } else {
            return redirect()->route('home');
        }

    }
    
    public function update($video_id, Request $request){

        // validar campos
        $validate = $this->validate($request, [
            "title" => ['required'],
            "description" => ['required'],
            "image" => ['required', 'mimes:jpg,bmp,png,pneg'],
            "video" => ['mimetypes:video/avi,video/mpeg,video/quicktime,video/mp4,video/mp3']
        ]);

        $user = Auth::user();
        $video = Video::find($video_id);
        $video->user_id = $user->id;
        $video->title = $request->input('title');
        $video->description = $request->input('description');

        $image = $request->file('image');
        // subida de imagen
        if($image) {
            // Delete image
            if($video->image) {
                Storage::disk('images')->delete($video->image);
            }

            $image_path = time().$image->getClientOriginalName();
            Storage::disk('images')->put($image_path, File::get($image));
            $video->image = $image_path;
        }

        $videoNuevo = $request->file('video');
        // subida de video
        if($videoNuevo) {
            if($video->video_path) {
                Storage::disk('videos')->delete($video->video_path);
            }
            $video_path = time().$videoNuevo->getClientOriginalName();
            Storage::disk('videos')->put($video_path, File::get($videoNuevo));
            $video->video_path = $video_path;
        }

        $video->update();

        return redirect()->route('home')->with(["message" => "El video se actualizo Correctamente"]);
    }

    // buscador
    public function search($search = null, $filter = null, Request $request){

        if(is_null($search)) {
            $search = $request->get('search');

            if(is_null($search)) {
                return redirect()->route('home', [
                    "search" => $search
                ]);
            }

            return redirect()->route('video.search', [
                "search" => $search
            ]);
        }

        if(is_null($filter) && $request->get('filter') && !is_null($search)) {
            $filter = $request->get('filter');

            return redirect()->route('video.search', [
                "search" => $search,
                "filter" => $filter
            ]);
        }

        $column = 'id';
        $order = 'desc';
        if(!is_null($filter)) {

            if($filter == 'new'){
                $column = 'id';
                $order = 'desc';
            }

            if($filter == 'old'){
                $column = 'id';
                $order = 'asc';
            }
            if($filter == 'alfa') {
                $column = 'title';
                $order = 'asc';
            }
        }

        $videos = Video::where('title', 'LIKE', '%'.$search.'%')
                       ->orderBy($column, $order)
                       ->paginate(5);

        return view('video.search', [
            "videos" => $videos,
            "search" => $search
        ]);

    }

}
