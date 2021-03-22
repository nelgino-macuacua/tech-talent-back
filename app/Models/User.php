<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    use HasFactory;
    protected $fillable = [
        'nome',
        'titulo',
        'email',
        'password',
        'taxa',
        'disponibilidade',
        'github',
        'linkedin',
        'portifolio',
        'skills',
        'imagem'
    ];

    public function skills()
    {
        return $this->belongsToMany(Skill::class, 'user_skills');
    }
    public function titulos()
    {
        return $this->belongsToMany(Titulo::class, 'user_titulos');
    }


}
