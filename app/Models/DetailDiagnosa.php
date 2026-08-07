<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetailDiagnosa extends Model
{
    use HasFactory;

    protected $fillable = [
        'diagnosa_id',
        'gejala_id',
    ];

    public function diagnosa()
    {
        return $this->belongsTo(Diagnosa::class);
    }

    public function gejala()
    {
        return $this->belongsTo(Gejala::class);
    }
}
