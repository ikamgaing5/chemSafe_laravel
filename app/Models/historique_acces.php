<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class historique_acces extends Model
{
    use HasFactory;

    protected $table = 'historique_acces';
    protected $fillable = [
        'user_id',
        'created_at',
        'action',
        'time'
    ];

    public function user(){
        return $this->belongsTo(User::class, 'user_id');
    }
}