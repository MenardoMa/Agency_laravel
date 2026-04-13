<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\CategorieFormRequest;
use App\Models\Category;

class CategorieController extends Controller
{
    // Rendre la page home (index pour categorie)
    public function index()
    {
        $categories = Category::orderBy('created_at', 'DESC')->paginate(10);
        return view('admin.back.categorie.index', [
            'categories' => $categories
        ]);
    }

    /**
     * 
     * Create Categorie
     * 
     * @param CategorieFormRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(CategorieFormRequest $request)
    {
        $categorie = Category::create($request->validated());

        if ($categorie) {
            return response()->json([
                "status" => true,
                "message" => "Categorie créér",
                "categorie" => $categorie,
            ]);
        }

        // AU cas ou on a une erreur 
        return response()->json([
            "status" => false,
            "message" => "Erreur lors de la creation d'une categorie",
        ]);
    }

    public function destroy(int $id)
    {

        $categorie = Category::find($id);

        if ($categorie) {
            $categorie->delete();
            return response()->json([
                "status" => true,
                "message" => "Categorie supprimer"
            ]);
        }
        // AU cas ou on a une erreur 
        return response()->json([
            "status" => false,
            "message" => "Erreur lors de la creation d'une categorie"
        ]);
    }

}
