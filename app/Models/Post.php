<?php

/**
 * Created by PhpStorm.
 * User: Luis
 * Date: 25/01/16
 * Time: 8:50 PM
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    protected $table = 'post';

    public $timestamps = false;

    protected $primaryKey = 'id_post';

    public function r_autor(){
        return $this->belongsTo('App\Models\Autor','autor','id_autor');
    }

    public function comentarios(){
        return $this->hasMany('App\Models\Comentario','id_post','id_post')->orderBy('comentario.fh_publicacion','asc');
    }
}