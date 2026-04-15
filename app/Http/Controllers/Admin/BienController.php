<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class BienController extends Controller
{
    //Home Page
    public function index()
    {
        return view("admin.back.bien.index");
    }

    public function formCreate()
    {
        return view("admin.back.bien.form");
    }
}
