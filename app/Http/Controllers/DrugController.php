<?php

namespace App\Http\Controllers;

use App\Models\Drug;
use Illuminate\Http\Request;

class DrugController extends Controller
{
    /**
     * Despliega todas los medicamentos en orden ascendente por el número de orden en la base de datos.
     * Los datos son desplegados en la vista index ubicado en la carpeta views/drugs.
     */
    public function index()
    {
        $my_drugs = Drug::orderBy('order', 'asc')->get();

        return view('drugs.index', compact('my_drugs'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('drugs.create');
    }

    /**
     * Despliega los datos de un medicamento de la base de datos.
     * El medicamento es buscado mediante su id.
     * El medicamento es enviado a la vista show ubicado en la carpeta views/drugs
     */
    public function show(string $id)
    {
        $my_drug = Drug::find($id);

        return view('drugs.show', compact('my_drug'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $my_drug = Drug::find($id);

        return view('drugs.edit', compact('my_drug'));
    }

}
