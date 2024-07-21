<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Adminklinik extends Model
{
    use HasFactory;

    protected $guarded = ['id'];
    protected $table = 'admin_klinik';

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function klinik()
    {
        return $this->belongsTo(Klinik::class);
    }
}
