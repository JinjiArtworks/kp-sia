<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Coa extends Model
{
    use HasFactory;
    protected $guarded = ['id'];
    protected $table = 'coa';
    public function tipe_coa()
    {
        return $this->belongsTo(TipeCoa::class);
    }
    public function cashflow()
    {
        return $this->hasMany(CashFlow::class);
    }
    public function buku_besar()
    {
        return $this->hasMany(BukuBesar::class);
    }
    // foreign key yang dititipkan pada tabel, akan menggunakan relasi belongsTo. Sedangkan tabel utama yang menitipkan, di modelsnya menggunakan relasi hasMany / hasOne!!!!
}
