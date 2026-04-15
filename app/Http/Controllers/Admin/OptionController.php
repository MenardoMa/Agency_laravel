<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\OptionFormRequest;
use App\Models\Option;
use Illuminate\Http\Request;

class OptionController extends Controller
{
    //Home Page
    public function index()
    {
        $options = Option::orderBy('created_at', 'DESC')->paginate(8);
        return view('admin.back.option.index', [
            'options' => $options
        ]);
    }

    /**
     * SHOW POST
     * 
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(int $id)
    {
        $option = Option::find($id);
        if (!$option) {
            return response()->json([
                "status" => false,
                "message" => "Option introuvable",
            ]);
        }

        return response()->json([
            "status" => true,
            "option" => $option,
        ]);
    }

    /**
     * 
     * Create option
     * 
     * @param OptionFormRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(OptionFormRequest $request)
    {
        try {
            $option = Option::create($request->validated());
            return response()->json([
                "status" => true,
                "message" => "Option créée avec succès",
                "option" => $option,
            ]);

        } catch (\Exception $e) {
            return response()->json([
                "status" => false,
                "message" => "Une erreur est survenue lors de la création de l'option",
                "error" => $e->getMessage()
            ]);
        }
    }

    /**
     * Option Edit
     * 
     * @param OptionFormRequest $request
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(OptionFormRequest $request, int $id)
    {
        $option = Option::find($id);
        if (!$option) {
            return response()->json([
                "status" => false,
                "message" => "Option introuvable",
            ]);
        }

        // Edit Option
        $option->update($request->validated());
        return response()->json([
            "status" => true,
            "message" => "Option modifier avec succès",
            "option" => $option
        ]);

    }

    /**
     * 
     * Delete option
     * 
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(int $id)
    {
        $option = Option::find($id);

        if (!$option) {
            return response()->json([
                "status" => false,
                "message" => "Option introuvable",
            ]);
        }

        $option->delete();
        return response()->json([
            "status" => true,
            "message" => "Option supprimée avec succès",
        ]);
    }
}
