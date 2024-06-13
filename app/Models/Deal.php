<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Deal extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 'email', 'phone', 'message', 'agent_id', 'lead_id', 'deal_value'
    ];

    public function agent()
    {
        return $this->belongsTo(User::class, 'agent_id');
    }

    public function lead()
    {
        return $this->belongsTo(Lead::class, 'lead_id');
    }
}
