<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JenisTabungan extends Model
{
    use HasFactory;

    protected $table = 'jenis_tabungan';
    public $timestamps = false;
    protected $guarded = [];

    public function tabungan()
    {
        return $this->hasMany(Tabungan::class, 'jenis_tabungan_id');
    }
}
