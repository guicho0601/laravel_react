<?php
/**
 * Created by PhpStorm.
 * User: Luis
 * Date: 10/03/16
 * Time: 8:19 PM
 */

namespace App\Models;


use Illuminate\Database\Eloquent\Model;

class Pais extends Model
{
    protected $table = 'pais';

    public $timestamps = false;

    protected $primaryKey = 'id_pais';

}