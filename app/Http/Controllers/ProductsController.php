<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use App\Models\Category;
class ProductsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        $products= Product::all();
        //la fonction compact sert a transmettre les variables ver la vue
        return view("admin.products.index",compact("products"));
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories= Category::all();

        return view("admin.products.create", compact("categories"));
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            "name"=>"required|max:100|unique:products",
            "description"=>"required",
            "price"=>"numeric|required",
            "photo1"=>"image|required|mimes:jpeg,png,jpg,gif|max:2048",
            "photo2"=>"image|required|mimes:jpeg,png,jpg,gif|max:2048",
            "category_id"=>"required|numeric"
            ]);  // ajouter les informations du produit


            //recuperer les champs du formulaire
            $inputs=$request->all();
            if($photo1=$request->file("photo1")){
                $newfile1=time().".".$photo1->getClientOriginalExtension();
                $photo1->move('images/products/',$newfile1);
                $inputs['photo1']=$newfile1;
            }
            if($photo2=$request->file("photo2")){
                $newfile2=time().".".$photo2->getClientOriginalExtension();
                $photo2->move('images/products/',$newfile2);
                $inputs['photo2']=$newfile2;
            }



            Product::create($inputs);
             //redidection ver la page index produit
            return redirect()->route("products.index")->with("message","Un nouveau produit a été cree avec succes!!!");

        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Product $product)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Product $product)
    {
        $categories= Category::all();
         //modifier
         return view("admin.products.edit",compact("product","categories"));
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Product $product)
    {
        $request->validate([
            "name"=>"required|max:100",
            "description"=>"required",
            "price"=>"numeric",
            "photo1"=>"image|mimes:jpeg,png,jpg,gif|max:2048",
            "photo2"=>"image|mimes:jpeg,png,jpg,gif|max:2048",
            "category_id"=>"required"
            ]);  // ajouter les informations du produit


            $inputs=$request->all();
            if($photo1=$request->file("photo1")){
                $newfile1=time().".".$photo1->getClientOriginalExtension();
                //ecraser l'ancienne photo
                if(file_exists('images/products/'.$product->photo1)){
                unlink ('images/products/'.$product->photo1);
                }
                $photo1->move('images/products/',$newfile1);
                $inputs['photo1']=$newfile1;
            }
            if($photo2=$request->file("photo2")){
                //ecraser l'ancienne photo
                if(file_exists('images/products/'.$product->photo2)){
                unlink ('images/products/'.$product->photo2);
                }
                $newfile2=time().".".$photo2->getClientOriginalExtension();

                $photo2->move('images/products/',$newfile2);
                $inputs['photo2']=$newfile2;
            }



            //mettre a jour les informations du produit
            $product->update($inputs);
             //redidection ver la page index produit
            return redirect()->route("products.index")->with("message","Le produit à été modifier avec succes!!!");

        //

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        if(file_exists('images/products/'.$product->photo1)){
            unlink ('images/products/'.$product->photo1);
            }
            if(file_exists('images/products/'.$product->photo2)){
            unlink ('images/products/'.$product->photo2);
            }
         //pour supprimer
         $product->delete();
         return redirect()->route("products.index")->with("message","Le produit à été supprimer avec succes!!!");
        //
    }
}
