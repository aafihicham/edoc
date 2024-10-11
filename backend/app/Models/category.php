<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class category extends Model
{
    use HasFactory;
    protected $fillable = ['label'];

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
}
