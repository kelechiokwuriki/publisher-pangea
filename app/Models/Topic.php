<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Subscriber;

class Topic extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function subscribers()
    {
        return $this->belongsToMany(Subscriber::class);
    }
}
