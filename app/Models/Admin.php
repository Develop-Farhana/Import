<?php

// App\Models\Admin.php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Notifications\Notifiable;

class Admin extends Authenticatable implements AuthenticatableContract
{
    use Notifiable;

    // Define the guard for this model
    protected $guard = 'admin';

    // Other model properties and methods
}
