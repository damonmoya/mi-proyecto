<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Profession extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = ['title'];

    public function users()
    {
        return $this->hasMany(User::class);
    }

}
