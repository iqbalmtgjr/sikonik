<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Klinik extends Model
{
    use HasFactory;

    protected $guarded = ['id'];
    protected $table = 'klinik';

    public function dokter()
    {
        return $this->hasOne(Dokter::class);
    }

    public function adminklinik()
    {
        return $this->hasOne(Adminklinik::class);
    }
}
