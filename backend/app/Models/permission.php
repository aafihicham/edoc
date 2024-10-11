<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class permission extends Model
{
    use HasFactory;

    protected $fillable = [
        'permissionName',
        'description',
    ];

    // Users relationship
    public function users()
    {
        return $this->belongsToMany(User::class, 'user_permission');
    }

    // Grant permission method
    public function grant($user)
    {
        // Grant this permission to a user
        return $this->users()->attach($user);
    }

    // Revoke permission method
    public function revoke($user)
    {
        // Revoke this permission from a user
        return $this->users()->detach($user);
    }
}
