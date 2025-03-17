<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Drug;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

use Barryvdh\DomPDF\Facade\Pdf as DomPDF;

class DrugController extends Controller
{
    public function generatePdf($id)
    {
        // Busca el medicamento por ID
        $my_drug = Drug::findOrFail($id); // Cambiamos el nombre a `$my_drug` para coincidir con la vista

        // Genera el PDF desde la vista `drugs.show`
        $pdf = DomPDF::loadView('drugs.show', compact('my_drug')); // Pasamos `$my_drug` correctamente

        // Devuelve el PDF para descarga
        return $pdf->download("medicamento_{$id}.pdf");
    }

    public function index()
    {
        $drugs = Drug::all();
        return response()->json($drugs);
    }

    public function find($id)
    {
        $my_drug = Drug::find($id);

        return response()->json($my_drug);
    }

    public function search(Request $request)
    {
        $search = $request->input('search');
        $drugs = Drug::where('name', 'LIKE', "%{$search}%")->get();
        return response()->json($drugs);
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric',
            'quantity' => 'required|integer',
            'img' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048', // Validación para la imagen
        ], [
            'name.required' => 'El nombre del medicamento es obligatorio.',
            'description.required' => 'La descripción del medicamento es obligatoria.',
            'price.required' => 'El precio del medicamento es obligatorio.',
            'quantity.required' => 'La cantidad por paquete es obligatoria.',
            'img.required' => 'La imagen es obligatoria.',
            'img.image' => 'El archivo debe ser una imagen.',
            'img.mimes' => 'La imagen debe ser de tipo: jpeg, png, jpg, o gif.',
            'imf.max' => 'La imagen no debe exceder los 2 MB.',
        ]);

        // Encuentra el valor más alto en la columna "order"
        $lastOrder = Drug::latest('id')->first();
        $validatedData['order'] = $lastOrder->order + 1;

        if ($request->hasFile('img')) {
            // Almacenar la imagen en la carpeta 'images' dentro de 'storage/app/public'
            $path = $request->file('img')->store('images', 'public');
            $validatedData['img'] = $path; // Guarda la ruta relativa en la base de datos
        }


        $drug = Drug::create($validatedData);

        return response()->json($drug, 201);
    }


    public function update(Request $request, $id)
    {
        // Depura los datos recibidos
        Log::info($request->all());

        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric',
            'quantity' => 'required|integer',
            'img' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // Procesa el resto como antes
        $drug = Drug::findOrFail($id);

        if ($request->hasFile('img')) {
            if ($drug->img && Storage::exists($drug->img)) {
                Storage::delete($drug->img);
            }
            $validatedData['img'] = $request->file('img')->store('drugs', 'public');
        }

        $drug->update($validatedData);

        return response()->json([
            'message' => 'El medicamento se ha actualizado exitosamente.',
            'drug' => $drug,
        ], 200);
    }

    public function updateOrder(Request $request)
    {
        $orders = $request->input('orders');

        // Actualizar el orden en la base de datos
        foreach ($orders as $order) {
            Drug::where('id', $order['id'])->update(['order' => $order['position']]);
        }

        // Obtener los datos actualizados y devolverlos
        $updatedDrugs = Drug::orderBy('order', 'asc')->get(); // Obtén los registros en el nuevo orden

        return response()->json(['success' => true, 'updatedDrugs' => $updatedDrugs]);
    }

    public function destroy(Request $request, $id)
    {
        $drug = Drug::find($id);

        if (!$drug) {
            // Si no se encuentra el registro, retorna una respuesta con error 404
            return response()->json([
                'message' => 'El medicamento no existe o ya ha sido eliminado.'
            ], 404);
        }

        // Elimina el registro si existe
        $drug->delete();

        // Retorna una respuesta de éxito
        return response()->json([
            'message' => 'Medicamento eliminado exitosamente.'
        ], 200);
    }
}
