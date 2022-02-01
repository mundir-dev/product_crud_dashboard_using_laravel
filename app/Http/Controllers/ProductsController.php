<?php

namespace App\Http\Controllers;

use App\Models\products;
use Illuminate\Http\Request;

class ProductsController extends Controller
{
    public function index(){
        return view('products')->with('products', Products::latest()->paginate(15));
    }

    public function newItem(){
        return view('form');
    }

    public function store(Request $request){
        $request->validate([
            'image' => 'required|image|mimes:png,jpg,jpeg|max:1024',
            'title' => 'required|max:255',
            'description' => 'required|min:15',
            'color' => 'required',
            'size' => 'required',
        ]);


        $NewImageName = md5($request->title. microtime()).'-'.$request->file('image')->getClientOriginalName();
        
        $request->image->move(public_path('images'), $NewImageName);

        $status = Products::create([
            "image" => $NewImageName,
            "title" => $request->input('title'),
            "description" => $request->input('description'),
            "color" => json_encode(explode(" ", $request->color)),
            "size" => json_encode(explode(" ", $request->size))
        ]);

        return redirect()->route('all_products')->with('status', $status ? "Product Saved" : "fail");
    }

    public function edit($id) {
        
        $product = Products::findOrFail($id);
        return view('UpdateForm')->with('product', $product);
    }

    public function update(Request $request, $id){
        $validationRules = [
            'title' => 'required|max:255',
            'description' => 'required|min:15',
            'color' => 'required',
            'size' => 'required',
        ];

        if($request->hasFile('image')){
            $validationRules['image'] = 'required|image|mimes:png,jpg,jpeg|max:1024';
        }

        $request->validate($validationRules);
        
        $NewData = [
            "title" => $request->input('title'),
            "description" => $request->input('description'),
            "color" => json_encode(explode(" ", $request->color)),
            "size" => json_encode(explode(" ", $request->size))
        ];

        if($request->hasFile('image')){
            $NewImageName = md5($request->title. microtime()).'-'.$request->file('image')->getClientOriginalName();
            $request->image->move(public_path('images'), $NewImageName);
            $NewData['image'] = $NewImageName;
        }

        $status = Products::Where('id', $id)->update($NewData);
        return redirect()->route('all_products')->with('status', $status ? "Product Details Updated" : "fail");
    }


    public function destroy($id) {
        $product = Products::findOrFail($id);
        $imagePath = public_path(). 'images/' . $product->image;
        $status = $product->delete();
        if($status){
            if(file_exists($imagePath)){
                unlink($imagePath);
            }
            return redirect()->route('all_products')->with('status', "Product Successfully Removed");
        }
        else{
            return redirect()->route('all_products')->with('status', "fail");
        }
    }
}
