<?php

namespace App\Http\Controllers\Admin;

use App\Enums\BienStatus;
use App\Enums\BienType;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\BienFormRequest;
use App\Models\Bien;
use App\Models\Category;

class BienController extends Controller
{
    //Home Page
    public function index()
    {
        return view("admin.back.bien.index");
    }

    /**
     * 
     * Form Create
     * 
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function formCreate()
    {
        $categories = Category::all();
        $statues = BienStatus::cases();
        $types = BienType::cases();

        return view("admin.back.bien.form", [
            'bien' => new Bien(),
            'categories' => $categories,
            'statues' => $statues,
            'types' => $types,
            'defaultStatus' => BienStatus::Disponible,
        ]);
    }

    /**
     * 
     * Creation d'un bien
     * 
     * @param BienFormRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(BienFormRequest $request)
    {
        try {
            $bien = Bien::create($request->validated());
            return response()->json([
                'status' => true,
                'message' => "Le bien a été créé avec succès",
                'bien' => $bien
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => "Impossible de créer le bien",
                'error' => $e->getMessage()
            ]);
        }

    }
}
