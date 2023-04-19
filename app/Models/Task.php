<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Task extends Model
{
    use HasFactory,SoftDeletes;

    protected $fillable=[
        'id', 'name', 'description','status_id','due_date'
    ];
    public function status()
    {
        return $this->hasMany(Status::class);
    }
}
