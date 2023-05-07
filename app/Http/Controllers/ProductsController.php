<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\Products;


class ProductsController extends Controller
{
   public function index(Request $request){
        $products = Products::all();

        return Inertia::render('Products',[
            'products' => $products,
        ]);
   }

   public function products(Request $request){
    $products = Products::all();

    return response()->json($products);
}

   public function update(Request $request, $id)
{
    $product = Product::findOrFail($id);

    $request->validate([
        'name' => 'required|string|max:255',
        'description' => 'required|string',
        'image_url' => 'nullable|image|max:2048', // Asegúrate de que solo se permitan archivos de imagen
    ]);

    $product->name = $request->name;
    $product->description = $request->description;

    // Si se ha enviado un archivo de imagen, actualiza la propiedad "image_url"
    if ($request->hasFile('image_url')) {
        $uploadedFile = $request->file('image_url');
        $path = $uploadedFile->store('public/images'); // Cambia la ruta según tu configuración
        $product->image_url = Storage::url($path);
    }

    $product->save();

    return response()->json(['message' => 'Product updated successfully']);
}


   public function upload(Request $request)
    {
        $file = $request->file('image');

        // Valida si se ha subido un archivo
        if(!$file) {
            return response()->json([
                'message' => 'No se ha subido un archivo'
            ], 422);
        }

        // Valida que el archivo sea de un tipo de imagen permitido
        $allowedMimeTypes = ['image/jpeg', 'image/png', 'image/gif'];
        if(!in_array($file->getClientMimeType(), $allowedMimeTypes)) {
            return response()->json([
                'message' => 'Tipo de archivo no permitido. Los formatos permitidos son JPEG, PNG y GIF.'
            ], 422);
        }

        // Genera un nombre único para el archivo
        $fileName = md5(uniqid() . microtime()) . '.' . $file->getClientOriginalExtension();

        // Almacena el archivo en el disco configurado en tu archivo .env
        $path = Storage::putFileAs('public/images', $file, $fileName);

        // Retorna la URL del archivo almacenado
        return response()->json([
            'url' => Storage::url($path)
        ]);
    }
}
