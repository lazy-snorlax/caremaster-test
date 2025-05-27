<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Company extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'abn',
        'email',
        'address',
    ];

    protected $casts = [
        'updated_at' => 'datetime',
        'created_at' => 'datetime',
    ];

    /**
     * A company has many employees
     * 
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function employees() : HasMany
    {
        return $this->hasMany(Employee::class);
    }
}