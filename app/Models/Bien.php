<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Enums\BienStatus;
use App\Enums\BienType;
use Illuminate\Database\Eloquent\Relations\HasMany;

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

    /**
     * Bien a une categorie
     * 
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    /**
     * Many To Many
     * 
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function options()
    {
        return $this->belongsToMany(Option::class);
    }

    /**
     * 
     * Un bien peut avoir 1 ou plusieurs image
     * 
     * @return HasMany
     */
    public function images()
    {
        return $this->hasMany(Image::class);
    }

    public function attachFiles(array $files)
    {
        $pictures = [];

        foreach ($files as $file) {
            if ($file->getError()) {
                continue;
            }
            $pathname = $file->store('biens/' . $this->id, 'public');
            $pictures[] = [
                "path" => $pathname
            ];
        }
        if (count($pictures) > 0) {
            $this->images()->createMany($pictures);
        }
    }

}
