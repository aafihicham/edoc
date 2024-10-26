<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class category extends Model
{
    use HasFactory;
    protected $fillable = ['label', 'user_id'];

    // Add category method
    public static function add($data)
    {
        return self::create($data);
    }

    // Update category method
    public function updateCategory($data)
    {
        return $this->update($data);
    }

    // Delete category method
    public function deleteCategory()
    {
        return $this->delete();
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function documents()
    {
        return $this->hasMany(Document::class);
    }
}
