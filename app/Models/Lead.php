<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Lead extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'email', 'phone', 'message', 'agent_id'];

    public function agent()
    {
        return $this->belongsTo(User::class, 'agent_id');
    }
}
