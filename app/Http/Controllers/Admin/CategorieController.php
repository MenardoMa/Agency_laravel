<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CategorieController extends Controller
{
    // Rendre la page home (index pour categorie)
    public function index()
    {
        return view('admin.back.categorie.index');
    }
}
