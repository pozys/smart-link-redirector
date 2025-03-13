<?php

declare(strict_types=1);

namespace App\Domain\Models;

use Illuminate\Auth\Authenticatable as AuthAuthenticatable;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Foundation\Auth\Access\Authorizable;
use Illuminate\Support\Fluent;

class User extends Fluent implements Authenticatable
{
    use AuthAuthenticatable, Authorizable;
}
