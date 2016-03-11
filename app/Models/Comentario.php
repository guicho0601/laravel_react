<?php
/**
 * Created by PhpStorm.
 * User: Luis
 * Date: 26/01/16
 * Time: 1:01 PM
 */

namespace App\Models;


use Illuminate\Database\Eloquent\Model;

class Comentario extends Model
{
    protected $table = 'comentario';

    public $timestamps = false;

    protected $primaryKey = 'id_comentario';

    public function post(){
        return $this->belongsTo('App\Models\Post','id_post','id_post');
    }

    public function r_autor(){
        return $this->belongsTo('App\Models\Autor','autor','id_autor');
    }
}