<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Carbon\Carbon;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class PostController extends Controller
{
    public function index(){
        return view('index');
    }

    public function listado(){
        return response(PostController::listado_post());
    }

    public static function listado_post(){
        return Post::orderBy('fh_publicacion','desc')
            ->with('r_autor')
            ->with(['comentarios'=>function($query){
                $query->with('r_autor');
            }])
            ->get();
    }
}
