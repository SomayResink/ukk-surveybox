<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Complaint extends Model
{
    use HasFactory;

    // Tambahkan ini - menentukan field apa saja yang bisa diisi secara massal
    protected $fillable = [
        'student_id',
        'category_id',
        'title',
        'content',
        'status'
    ];

    // Atau bisa juga pake $guarded untuk menentukan field yang TIDAK boleh diisi
    // protected $guarded = ['id', 'created_at', 'updated_at'];

    protected $casts = [
        'status' => 'string',
    ];

    public function student()
    {
        return $this->belongsTo(User::class, 'student_id');
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function feedback()
    {
        return $this->hasOne(Feedback::class);
    }
}
