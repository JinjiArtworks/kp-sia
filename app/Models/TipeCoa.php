<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TipeCoa extends Model
{
    use HasFactory;
    protected $guarded = ['id'];
    protected $table = 'tipe_coa';
    public function coa()
    {
        return $this->hasMany(Coa::class);
    }
}
