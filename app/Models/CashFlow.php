<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CashFlow extends Model
{
    use HasFactory;
    protected $guarded = ['id'];
    protected $table = 'cashflow';
    public function coa()
    {
        return $this->belongsTo(Coa::class);
    }
    public function users()
    {
        // created by, foreign key di cashflow, id pk di user.
        return $this->belongsTo(User::class, 'created_by', 'id');
    }
}