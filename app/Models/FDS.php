<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FDS extends Model
{
    use HasFactory;

    protected $table = 'infofds';
    public $timestamps = false;
    protected $fillable = [
        'produit_id',
        'physique',
        'sante',
        'ppt',
        'stabilite',
        'eviter',
        'incompatible',
        'reactivite',
        'stockage',
        'secours',
        'epi'
    ];

    public function produit()  {
        return $this->belongsTo(Produit::class, 'produit_id');
    }

}