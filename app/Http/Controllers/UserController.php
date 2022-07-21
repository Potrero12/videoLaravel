<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Auth;

use Symfony\Component\HttpFoundation\Response;
use Illuminate\Auth\Events\Validated;

use App\Models\User;
use App\Models\Video;
use App\Models\Comment;

class UserController extends Controller {
    
    public function channel($user_id) {

        $user = User::find($user_id);

        if(!is_object($user)) {
            return redirect()->route('home');
        }

        $videos = Video::where('user_id', $user_id)->paginate(5);

        return view('user.channel', [
            "user" => $user,
            "videos" => $videos
        ]);

    }

}
