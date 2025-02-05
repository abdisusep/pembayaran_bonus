<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Buruh extends Model
{
    use HasFactory;

    protected $table = 'buruh';
    protected $fillable = ['bonus_id', 'name', 'percentage', 'amount'];

    public function bonus()
    {
        return $this->belongsTo(Bonus::class);
    }

    protected static function boot()
    {
        parent::boot();
        static::deleting(function ($bonus) {
            $bonus->buruh()->delete();
        });
    }
}
