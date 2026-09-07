<?php
// app/Models/ProgramPhase.php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;

class ProgramPhase extends Model
{
    use HasUuids;

    protected $fillable = [
        'code',
        'name',
        'week_start',
        'week_end',
        'main_tool',
        'description',
    ];

    public function rituals()
    {
        return $this->hasMany(Ritual::class, 'phase_id');
    }
}