<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;

class Authenticate extends Middleware
{
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return string|null
     */
    protected function redirectTo($request): ?string
    {
        if (!$request->expectsJson()) {
            $url = $request->url();

            // Check for specific keywords in the URL and redirect accordingly
            if (strpos($url, '/admin') !== false) {
                return route('admin.loginPage');
            } elseif (strpos($url, '/seller') !== false) {
                return route('seller.loginPage');
            } elseif (strpos($url, '/customer') !== false) {
                return route('customer.loginPage');
            }

            // Default route if no specific keyword is found
            return route('customer.loginPage');
        }

        return null;
    }
}
