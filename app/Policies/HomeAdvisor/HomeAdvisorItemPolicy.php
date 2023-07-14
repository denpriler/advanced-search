<?php

namespace App\Policies\HomeAdvisor;

use App\Policies\ReadonlyResourcePolicy;
use Illuminate\Auth\Access\HandlesAuthorization;

class HomeAdvisorItemPolicy extends ReadonlyResourcePolicy
{
    use HandlesAuthorization;
}
