<?php

namespace App\Http\Controllers;

use App\Models\Drug;
use Illuminate\Http\Request;

class DrugController extends Controller
{
    /**
     * Display a listing of the resource.
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
     * Display the specified resource.
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
