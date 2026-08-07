<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RuleGejala extends Model
{
    use HasFactory;

    protected $fillable = [
        'rule_id',
        'gejala_id',
    ];

    public function rule()
    {
        return $this->belongsTo(Rule::class);
    }

    public function gejala()
    {
        return $this->belongsTo(Gejala::class);
    }
}
