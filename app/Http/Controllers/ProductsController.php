<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\Products;
use Illuminate\Support\Facades\Route;


class ProductsController extends Controller
{
   public function index(Request $request){
        $products = Products::all();

        return Inertia::render('Products',[
            'canLogin' => Route::has('login'),
            'canRegister' => Route::has('register'),
            'products' => $products,
        ]);
   }
}
