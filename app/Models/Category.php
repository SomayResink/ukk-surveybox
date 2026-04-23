<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'slug', 'description'];

    public function complaints()
    {
        return $this->hasMany(Complaint::class);
    }

    public function admins()
    {
        return $this->hasMany(User::class)->where('role', 'admin');
    }
}
