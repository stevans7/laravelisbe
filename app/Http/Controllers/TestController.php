<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TestController extends Controller
{
   public function affiche(){
        return view("categories.index",compact("categories"));
   }
}
