<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class AvatarComplet extends Model
{
    protected $table = 'avatar_complet'; // Spécifie le nom de la table
    protected $fillable = ['avatar_id', 'user_id', 'avatar_svg'];

    protected static function boot()
    {
        parent::boot();
        static::creating(function ($avatar) {
            $avatar->avatar_id = Str::uuid(); // Génère un UUID pour avatar_id
        });
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}