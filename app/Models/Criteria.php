<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Criteria extends Model
{
    protected $fillable = ['name', 'type', 'weight', 'bayes_probability'];

    public function scores()
    {
        return $this->hasMany(Score::class);
    }
}

