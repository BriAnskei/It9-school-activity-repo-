<?php

namespace App\Http\Controllers;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    // Display All
    public function index() {
        $products = Product::all();

        return view('product.index', [
            'items' => $products
        ]);
    }


    public function store(Request $request) {
        Product::create([
            'name' => $request->name123,
            'price' => $request->price123,
        ]);

        return redirect('/products');
    }
}
