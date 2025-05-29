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

    public function getAteliersListAttribute()
    {
        return $this->atelier()->pluck('nomatelier')->join(', ');
    }

    public function getNbAteliersAttribute()
    {
        return $this->atelier()->count();
    }

    public function scopeWithWorkshopDetails($query, $idusine = null)
    {
        $query->select([
            'produit.id',
            'produit.nomprod',
            'produit.type_emballage',
            'produit.poids',
            'produit.nature',
            'produit.utilisation',
            'produit.fabricant',
            'produit.photo',
            'produit.fds',
            'produit.risque'
        ])
            ->selectRaw('GROUP_CONCAT(DISTINCT atelier.nomatelier ORDER BY atelier.nomatelier SEPARATOR ", ") AS atelier')
            ->selectRaw('COUNT(DISTINCT atelier.id) AS nb_ateliers')
            ->selectRaw('usine.nomusine as nom_usine')
            ->join('contenir', 'produit.id', '=', 'contenir.produit_id')
            ->join('atelier', 'atelier.id', '=', 'contenir.atelier_id')
            ->join('usine', 'atelier.usine_id', '=', 'usine.id')
            ->where('atelier.active', 'true');

        if ($idusine !== null) {
            $query->where('atelier.usine_id', $idusine);
        }

        return $query->groupBy([
            'produit.id',
            'produit.nomprod',
            'produit.type_emballage',
            'produit.poids',
            'produit.nature',
            'produit.utilisation',
            'produit.fabricant',
            'produit.photo',
            'produit.fds',
            'produit.risque',
            'usine.nomusine'
        ]);
    }

    public function scopeSearch($query, $search)
    {
        return $query->where(function ($q) use ($search) {
            $q->where('nomprod', 'LIKE', "%{$search}%")
                ->orWhere('type_emballage', 'LIKE', "%{$search}%")
                ->orWhere('nature', 'LIKE', "%{$search}%")
                ->orWhere('utilisation', 'LIKE', "%{$search}%");
        });
    }
}