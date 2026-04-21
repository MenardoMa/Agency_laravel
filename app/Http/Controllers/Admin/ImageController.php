<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Image;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ImageController extends Controller
{
    /**
     * DELETE IMAGE
     * 
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(int $id)
    {
        $image = Image::findOrFail($id);

        // Delete image depuis le disk
        if ($image->path && Storage::disk('public')->exists($image->path)) {
            Storage::disk('public')->delete($image->path);
        }

        // Delete image depuis la base
        $image->delete();

        return response()->json([
            'status' => true,
            'message' => "Image retirée avec succès",
        ]);
    }
}
