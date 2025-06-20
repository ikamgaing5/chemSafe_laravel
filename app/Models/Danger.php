<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Danger extends Model
{
    use HasFactory;
    /**
     * Les attributs qui peuvent être assignés en masse.
     *
     * @var array
     */
    protected $table = 'danger';
    protected $fillable = [
        'photo',
        'nomdanger'
    ];
    public $timestamps = false;
    public function produit(){
        return $this->belongsToMany(Produit::class, 'possede','danger_id', 'produit_id')->orderBy('nomprod');
    }
    public function produits()
    {
        return $this->hasMany(Produit::class)->orderBy('nomproduit');
    }
}