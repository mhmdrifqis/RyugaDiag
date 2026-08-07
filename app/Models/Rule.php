<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rule extends Model
{
    use HasFactory;

    protected $fillable = [
        'kerusakan_id',
    ];

    public function kerusakan()
    {
        return $this->belongsTo(Kerusakan::class);
    }

    public function gejalas()
    {
        return $this->belongsToMany(Gejala::class, 'rule_gejalas');
    }
}
