<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LabaRugi extends Model
{
    use HasFactory;
    protected $guarded = ['id'];
    protected $table = 'laba_rugi';
    public function pendapatan()
    {
        return $this->belongsTo(TipePendapatan::class);
    }
    public function pengeluaran()
    {
        return $this->belongsTo(TipePengeluaran::class);
    }
    public function coa()
    {
        return $this->belongsTo(Coa::class);
    }
}
