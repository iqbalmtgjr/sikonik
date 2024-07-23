<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Janjitemu extends Model
{
    use HasFactory;

    protected $guarded = ['id'];
    protected $table = 'janji_temu';

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function klinik()
    {
        return $this->belongsTo(Klinik::class);
    }
}
