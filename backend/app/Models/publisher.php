<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class publisher extends Model
{
    use HasFactory;

    protected $table = 'publisher';

    protected $fillable = [
        'user_id',
        'name',
        'email',
    ];

    // Relationship with User
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // A member can have many categories
    public function categories()
    {
        return $this->hasMany(category::class);
    }

    // A member can have many documents
    public function documents()
    {
        return $this->hasMany(document::class, 'user_id');

    }
}
