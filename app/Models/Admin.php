<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Admin extends Authenticatable
{
    use HasFactory;

    // Define any additional properties or methods specific to the Admin model
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'users';
}
