<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bonus extends Model
{
    use HasFactory;

    protected $table = 'bonus';
    protected $fillable = ['total_amount'];

    public function buruh()
    {
        return $this->hasMany(Buruh::class);
    }
}
