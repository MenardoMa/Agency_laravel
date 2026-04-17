<?php

namespace App\Http\Controllers\Admin;

use App\Enums\BienStatus;
use App\Enums\BienType;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\BienFormRequest;
use App\Models\Bien;
use App\Models\Category;
use App\Models\Option;

class BienController extends Controller
{
    //Home Page
    public function index()
    {
        $biens = Bien::with('category')->orderBy("created_at", "Desc")->paginate(10);
        return view("admin.back.bien.index", [
            'biens' => $biens
        ]);
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
        $options = Option::all();

        return view("admin.back.bien.form", [
            'bien' => new Bien(),
            'categories' => $categories,
            'statues' => $statues,
            'types' => $types,
            'options' => $options,
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

        $data = $request->validated();
        $options = $data['options'] ?? [];

        // On retire options dans nos validation
        unset($data['options']);

        try {
            $bien = Bien::create($data);
            // Create options
            $bien->options()->sync($options);

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

    public function destroy(int $id)
    {
        $bien = Bien::find($id);
        if (!$bien) {
            return response()->json([
                'status' => false,
                'message' => "Impossible de supprimé le bien",
            ]);
        }

        $bien->delete();
        return response()->json([
            'status' => true,
            'message' => "Le bien a été supprimé avec succès",
        ]);

    }

}
