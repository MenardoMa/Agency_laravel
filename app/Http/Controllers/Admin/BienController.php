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
        $biens = Bien::with('category', 'options')->orderBy("created_at", "Desc")->paginate(10);
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
        $images = $data['images'] ?? [];

        unset($data['options']);
        unset($data['images']);

        $bien = Bien::create($data);
        $bien->options()->sync($options);
        $bien->attachFiles($images);

        return response()->json([
            'status' => true,
            'message' => "Le bien a été créé avec succès",
            'bien' => $bien
        ]);
    }

    /**
     * 
     * Retourne la formulaire avec les données du bien
     * 
     * @param Bien $bien
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function edit(Bien $bien)
    {
        $categories = Category::all();
        $statues = BienStatus::cases();
        $types = BienType::cases();
        $options = Option::all();

        return view("admin.back.bien.form", [
            'bien' => $bien,
            'categories' => $categories,
            'statues' => $statues,
            'types' => $types,
            'options' => $options,
            'defaultStatus' => BienStatus::Disponible,
        ]);
    }

    /**
     * 
     * Edit bien
     * 
     * @param BienFormRequest $request
     * @param Bien $bien
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(BienFormRequest $request, Bien $bien)
    {

        $data = $request->validated();
        $options = $data['options'] ?? [];
        $images = $data['images'] ?? [];

        unset($data['options']);
        unset($data['images']);

        try {
            $bien->update($data);
            $bien->options()->sync($options);
            $bien->attachFiles($images);

            return response()->json([
                'status' => true,
                'message' => "Le bien a été modifié avec succès",
                'bien' => $bien
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => "Impossible de modifier le bien",
                'error' => $e->getMessage()
            ]);
        }
    }


    /**
     * 
     * DELETE BIEN
     * 
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
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
