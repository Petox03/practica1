<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Drug;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

use Barryvdh\DomPDF\Facade\Pdf as DomPDF;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

class DrugController extends Controller
{
    /**
     * Función que genera el pdf utilizando la vista show de los medicamentos como base.
     * La función encuentra el medicamento mediante su id.
     * Genera la vista del pdf mediante la vista mencionada mandando los valores necesarios.
     * retorna como respuesta la descarga del pdf y le asiga un nombre dependiendo del medicamento,
     *
     * @param integer $id
     * @return Response
     */
    public function generatePdf(int $id): Response
    {
        $my_drug = Drug::findOrFail($id);

        $pdf = DomPDF::loadView('drugs.show', compact('my_drug'));

        return $pdf->download("medicamento_{$id}_{$my_drug->name}.pdf");
    }

    /**
     * Función que retorna todas los medicamentos almacenados en la base de datos en formato json
     *
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        $drugs = Drug::all();
        return response()->json($drugs);
    }

    /**
     * función que busca un medicamento mediante su id y lo retorna en formato json
     *
     * @param integer $id
     * @return JsonResponse
     */
    public function find(int $id): JsonResponse
    {
        $my_drug = Drug::find($id);

        return response()->json($my_drug);
    }

    /**
     * Función que busca un medicamento con la coincidencia al parámetro recibido en el campo "search" en formato json.
     * Guarda el texto recibido de la petición en el campo "search".
     * Busca en la tabla de medicamentos cualquier medicament que tenga conincidencias con el texto recibido
     * Regresa el resultado en formato json
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function search(Request $request): JsonResponse
    {
        $search = $request->input('search');
        $drugs = Drug::where('name', 'LIKE', "%{$search}%")->orderBy('order', 'asc')->get();
        return response()->json($drugs);
    }

    /**
     * Función que almacena en la base de datos un nuevo medicamento.
     *
     * Valida los datos de la petición y genera mensajes personalizados para cada validación.
     * Encuentra cuál es el último order de el último medicamento.
     * Añade el campo "order" a la petición validada y asigna como order el último order encontrado más uno.
     * Si la petición tiene un archivo, lo almacena en la carpeta images que está dentro de la carpeta public.
     * Añade el campo "img" el path donde se guardó la imagen
     * Crea la medicina con la información validada.
     * Retorna la medicina en formato json
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function store(Request $request): JsonResponse
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric',
            'quantity' => 'required|integer',
            'img' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ], [
            'name.required' => 'El nombre del medicamento es obligatorio.',
            'description.required' => 'La descripción del medicamento es obligatoria.',
            'price.required' => 'El precio del medicamento es obligatorio.',
            'quantity.required' => 'La cantidad por paquete es obligatoria.',
            'img.required' => 'La imagen es obligatoria.',
            'img.image' => 'El archivo debe ser una imagen.',
            'img.mimes' => 'La imagen debe ser de tipo: jpeg, png, jpg, o gif.',
            'img.max' => 'La imagen no debe exceder los 2 MB.',
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


    /**
     * Función que actualiza un medicamento almacenado en la base de datos.
     * 
     * Almacena los datos recibidos en el log para depurarlos en caso de que ocurran errores.
     * Valida los datos recibidos con mensaje personalizado.
     * encuentra el medicamento con el id recibido.
     * si la petición tiene una imagen, valida si la imagen existe y elimina la imagen almacenada.
     * actualiza los datos con la información validada.
     * retorna la respuesta en foramto json.
     *
     * @param Request $request
     * @param integer $id
     * @return JsonResponse
     */
    public function update(Request $request, int $id): JsonResponse
    {
        Log::info($request->all());

        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric',
            'quantity' => 'required|integer',
        ], [
            'name.required' => 'El nombre del medicamento es obligatorio.',
            'description.required' => 'La descripción del medicamento es obligatoria.',
            'price.required' => 'El precio del medicamento es obligatorio.',
            'quantity.required' => 'La cantidad por paquete es obligatoria.',
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

    /**
     * actualiza el orden de los medicametos. Esta función es llamada cuando se usa el drag&drop
     * 
     * recibe el input orders de la petición.
     * para cada order, actualiza el nuevo orden de los medicamentos.
     * Retorna la lista de los medicamentos con el nuevo orden.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function updateOrder(Request $request): JsonResponse
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


    /**
     * Elimina un medicamento de la base de datos.
     * 
     * Busca el medicamento en la base de datos con el id proporcionado.
     * si no existe el medicamento, retorna un json con la respuesta en formato json de que el medicamento no se ha encontrado.
     * si existe, elimina el medicamento.
     * retorna la respuesta en formato json de que el medicamento se ha eliminado.
     *
     * @param integer $id
     * @return JsonResponse
     */
    public function destroy(int $id): JsonResponse
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

        Storage::disk('public')->delete($drug->img);

        // Retorna una respuesta de éxito
        return response()->json([
            'message' => 'Medicamento eliminado exitosamente.'
        ], 200);
    }
}
