<?php

namespace App\Listeners;

use Illuminate\Auth\Events\Login;
use Quantic\SessionOut\Classes\AuthState;

class SuccessfulLogin
{
    /**
     * Handle the event.
     *
     * @param  Login  $event
     * @return void
     */
    public function handle(Login $user)
    {
        AuthState::sessionAvailable();
    }
}