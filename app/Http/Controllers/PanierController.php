<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PanierController extends Controller
{
    public function addToCart(Request $request){
        //recuperer les information du produit

        $id=$request->id;
        $name=$request->name;
        $photo1=$request->photo1;
        $price=$request->price;
        $qty=1;


        //ajouter un produit dans la session
    if(session()-> has("panier")){

        session()->push('panier',);
    }else{

    }

    }
}
