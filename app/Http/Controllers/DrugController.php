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
        $my_drugs = Drug::all();

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
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string'],
            'price' => ['required', 'numeric'],
            'quantity' => ['required', 'integer'],
        ]);

        Drug::create($validatedData);

        return redirect()->route('index');
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

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validatedData = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string'],
            'price' => ['required', 'numeric'],
            'quantity' => ['required', 'integer'],
        ]);

        Drug::find($id)->update($validatedData);

        return redirect()->route('drug.show', $id);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        Drug::find($id)->delete();

        return redirect()->route('index');
    }

    public function search(Request $request)
    {
        $query = $request->input('query');
        $drugs = Drug::where('name', 'LIKE', "%{$query}%")->get();
        return response()->json($drugs);
    }
}
