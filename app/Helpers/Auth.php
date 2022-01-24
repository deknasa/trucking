<?php

namespace App\Helpers;

use App\Http\Controllers\Controller;

class Auth {
    public function hasPermission($class, $method): bool
    {
        $controller = new Controller();

        return $controller->hasPermission($class, $method);
    }
}