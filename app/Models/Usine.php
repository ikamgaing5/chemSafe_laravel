<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class Usine extends Model
{
    use HasFactory, HasUuids;

    /**
     * Le nom de la table associée au modèle.
     *
     * @var string
     */
    protected $table = 'usine';

    /**
     * Indique si le modèle doit utiliser les timestamps.
     *
     * @var bool
     */
    public $timestamps = false;

    /**
     * Les attributs qui peuvent être assignés en masse.
     *
     * @var array
     */
    protected $fillable = [
        'nomusine',
        'active',
    ];
    public function ateliers()
    {
        return $this->hasMany(Atelier::class, 'usine_id', 'id');
    }
}