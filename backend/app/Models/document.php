<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class document extends Model
{
    use HasFactory;
    protected $fillable = ['title', 'documentType', 'path', 'creationDate', 'categorieId', 'userid'];

    // Relation Between document and categry
    public function category()
    {
        return $this->belongsTo(Category::class, 'categorieId');
    }

    // Add Document
    public static function add($data)
    {
        return self::create($data);
    }

    // Update Document
    public function updateDocument($data)
    {
        return $this->update($data);
    }

    // Delete Document
    public function deleteDocument()
    {
        return $this->delete();
    }
    
}
