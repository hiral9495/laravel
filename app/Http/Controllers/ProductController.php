<?php

namespace App\Http\Controllers;
use App\Models\Product;
use Illuminate\Http\Request;


class ProductController extends Controller
{
   public function index() {
    $products = Product::orderBy('id', 'desc')->paginate(10);
    return view('index', compact('products'));
   }

   public function create() {
    return view('create');
   }

   public function store(Request $request) {
    $request->validate([
        'name' => 'required',
        'emails.*' => 'required|email',
        'address' => 'required',
        'phone' => 'required|numeric',
        'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048'
    ]);

    if ($request->hasFile('image')) {
        $image = $request->file('image');
        $imageName = time() . '.' . $image->getClientOriginalExtension();
        $image->move(public_path('images'), $imageName);

        // Add the image path to the request data
        $request->merge(['image' => 'images/' . $imageName]);
    }
    $emails = $request->input('emails', []);
    $emailsJson = json_encode($emails);
    // Create the product with additional emails
   // $student = Product::create($request->only(['name', 'email', 'address', 'phone', 'image']));
    Product::create(array_merge(
        $request->only(['name', 'address', 'phone', 'image']),
        ['email' => $emailsJson]
    ));


    return redirect()->route('products.index')->with('success', 'Student has been created successfully.');
}

   public function destroy(Product $product) {
    $product->delete();
    return redirect()->route('products.index')->with('success','Product delete successfully.');
   }

   public function edit(Product $product) {
    return view('edit',compact('product'));
   }

   public function update(Request $request, Product $product) {
    $request->validate([
        'name' => 'required',
    'email' => 'required',
    ]);
    $product->fill($request->post())->save();
    return redirect()->route('products.index')->with('success', 'Student has been created successfully.');
   }
}
