<?php
/**
 * Created by PhpStorm.
 * User: Luis
 * Date: 26/01/16
 * Time: 12:35 PM
 */

namespace App\Models;


use Illuminate\Database\Eloquent\Model;

class Autor extends Model
{
    protected $table = 'autor';

    public $timestamps = false;

    protected $primaryKey = 'id_autor';

    protected $appends = ['no_posts'];

    protected $fillable = ['nickname','correo','id_pais'];

    protected $hidden = ['fh_publicacion','posts'];

    public function posts(){
        return $this->hasMany('App\Models\Post','autor','id_autor');
    }

    public function pais(){
        return $this->belongsTo('App\Models\Pais','id_pais');
    }

    public function getNoPostsAttribute(){
        return count($this->posts);
    }
}