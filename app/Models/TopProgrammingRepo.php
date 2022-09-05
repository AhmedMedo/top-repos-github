<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TopProgrammingRepo extends Model
{
    use HasFactory;

    protected $fillable = [
        'programming_lagnuage',
        'repo_name',
        'description',
        'github_url'
    ];
}
