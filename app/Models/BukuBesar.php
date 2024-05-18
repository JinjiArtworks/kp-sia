<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BukuBesar extends Model
{
    use HasFactory;
    protected $guarded = ['id'];
    protected $table = 'buku_besar';
    public function coa()
    {
        return $this->belongsTo(Coa::class);
    }
}