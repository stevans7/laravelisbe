<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoriesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        $categories= Category::all();
        //la fonction compact sert a transmettre les variables ver la vue
        return view("admin.categories.index",compact("categories"));
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {

        return view("admin.categories.create");
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
        "name"=>"required|max:100|unique:categories"
        ]);  // die ou exit permettent d'arreter le traintement


        //inserer dans la base de donnée

        Category::create($request->all());
         //redidection ver la page index
        return redirect()->route("categories.index")->with("message","La nouvelle categorie est cree avec succes!!!");
    }

    /**
     * Display the specified resource.
     */
    public function show(Category $category)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Category $category)
    {

        
        //modifier
        return view("admin.categories.edit",compact("category"));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Category $category)
    {
        //modifier
        $request->validate([
            'name'=>'required',
        ]);
        //mise a jour avec eloquent
        $category->update($request->all());
        //rediriger vers l'index
        return redirect()->route("categories.index")->with("message","La categorie a modifier avec succes!!!");
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Category $category)
    {
        //pour supprimer
        $category->delete();
        return redirect()->route("categories.index")->with("message","La nouvelle categorie est supprimer avec succes!!!");
    }
}
