<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Lead extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'email', 'phone', 'message', 'agent_id', 'stage'];

    public function agent()
    {
        return $this->belongsTo(User::class, 'agent_id');
    }

    public function deal()
    {
        return $this->hasOne(Deal::class, 'lead_id');
    }
}
