<?php

namespace App\Models;

use App\favoritable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reply extends Model
{
    use HasFactory, favoritable;

    protected $guarded = [];

    protected $with = ['user', 'favorites'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function thread()
    {
        return $this->belongsTo(Reply::class);
    }

}
