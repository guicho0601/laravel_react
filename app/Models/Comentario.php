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

    protected $dateFormat = 'Y-m-d H:i:s';

    protected $dates = ['fh_publicacion'];

    protected $appends = ['tiempo'];

    protected $hidden = ['fh_publicacion','autor'];

    public function post(){
        return $this->belongsTo('App\Models\Post','id_post','id_post');
    }

    public function r_autor(){
        return $this->belongsTo('App\Models\Autor','autor','id_autor');
    }

    public function getTiempoAttribute()
    {
        return $this->fh_publicacion->diffForHumans();
    }
}