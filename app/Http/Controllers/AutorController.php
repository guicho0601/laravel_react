<?php

namespace App\Http\Controllers;

use App\Models\Autor;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class AutorController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return response(Autor::with('pais')->get());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        Autor::create($request->all());
        return response(1);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  Autor  $autor
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $autor)
    {
        $autor->fill($request->all());
        $autor->save();
        return response($autor);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Autor  $autor
     * @return \Illuminate\Http\Response
     */
    public function destroy($autor)
    {
        $autor->delete();
        return response(1);
    }
}
