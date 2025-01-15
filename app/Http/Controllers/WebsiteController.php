<?php

namespace App\Http\Controllers;

use App\Models\Products;
use Illuminate\Http\Request;

class WebsiteController extends Controller
{
    public function index(){
$articles = Products::latest()->paginate(20);
return view('welcome' , compact('articles'));
    }
}
