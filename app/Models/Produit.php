<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Produit extends Model
{
    use HasFactory;
    /**
     * Les attributs qui peuvent être assignés en masse.
     *
     * @var array
     */
    protected $table = 'produit';
    public $timestamps = false;
    protected $fillable = [
        'nomprod',
        'type_emballage',
        'poids',
        'nature',
        'utilisation',
        'fabricant',
        'photo',
        'fds',
        'risque'

    ];

    public function atelier()
    {
        return $this->belongsToMany(Atelier::class, 'contenir', 'produit_id', 'atelier_id');
    }
    public function danger()
    {
        return $this->belongsToMany(Danger::class, 'possede', 'produit_id', 'danger_id');
    }

    public function infofds()
    {
        return $this->hasOne(FDS::class, 'produit_id', 'id');
    }
}