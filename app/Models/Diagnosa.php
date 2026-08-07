<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Diagnosa extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'kerusakan_id',
        'tanggal_diagnosa',
    ];

    protected $casts = [
        'tanggal_diagnosa' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function kerusakan()
    {
        return $this->belongsTo(Kerusakan::class);
    }

    public function detailDiagnosas()
    {
        return $this->hasMany(DetailDiagnosa::class);
    }
}
