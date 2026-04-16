<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Enums\BienStatus;
use App\Enums\BienType;

class Bien extends Model
{
    use HasFactory;

    /**
     * 
     * Accepte save champs
     * 
     * @var array
     */
    protected $fillable = [
        'title',
        'slug',
        'surface',
        'prix',
        'description',
        'nombre_pieces',
        'nombre_chambres',
        'nombre_salles_bain',
        'etage',
        'adresse',
        'ville',
        'code_postal',
        'category_id',
        'status',
        'type',
    ];

    /**
     * 
     * Enums Status de bien
     * 
     * @var array
     */
    protected $casts = [
        'statut' => BienStatus::class,
        'type' => BienType::class,
    ];

}
