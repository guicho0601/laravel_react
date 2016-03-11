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
        $posts = [];
        foreach (Post::orderBy('fh_publicacion','desc')->get() as $p) {
            $fh_publicacion = Carbon::createFromFormat('Y-m-d H:i:s',$p->fh_publicacion);
            $p->fh_publicacion = Carbon::now()->diffForHumans($fh_publicacion);
            $p->autor = $p->r_autor->nickname;
            $comentarios = [];
            foreach ($p->comentarios as $c) {
                $fh_publicacion = Carbon::createFromFormat('Y-m-d H:i:s',$c->fh_publicacion);
                $c->fh_publicacion = Carbon::now()->diffForHumans($fh_publicacion);
                $c->autor = $c->r_autor->nickname;
                array_push($comentarios,$c);
            }
            $p->comentarios = $comentarios;
            array_push($posts,$p);
        }
        return response()->json($posts);
    }
}
