<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Department extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'director',
        'director_type',
        'budget',
    ];

    public function users()
    {
        return $this->hasMany(User::class);
    }   

    public function department()
    {
        return $this->hasOne(Department::class);
    }  

    public function company()
    {
        return $this->belongsTo(Company::class);
    } 
}
