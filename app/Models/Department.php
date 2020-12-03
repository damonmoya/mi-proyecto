<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

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
        'company_id',
        'dependent_id',
        'budget',
    ];

    public function users()
    {
        return $this->hasMany(User::class);
    }   

    public function departments()
    {
        return $this->hasMany(Department::class, 'dependent_id', 'id');
    }  

    public function dependent()
    {
        return $this->belongsTo(Department::class);
    }

    public function company()
    {
        return $this->belongsTo(Company::class);
    } 
}
