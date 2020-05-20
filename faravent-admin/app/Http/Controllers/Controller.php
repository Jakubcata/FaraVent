<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use DispatchesJobs, ValidatesRequests;

    /**
     * @var User static
     */
    protected $currentUser;
    /**
     * @var bool
     */
    protected $signedIn;


    public function __construct()
    {
        $this->middleware(function ($request, $next) {

            // Get a user instance for the current user
            $user = user();

            // Share variables with controllers
            $this->currentUser = $user;
            $this->signedIn = auth()->check();

            // Share variables with views
            view()->share('signedIn', $this->signedIn);
            view()->share('currentUser', $user);

            return $next($request);
        });
    }


    public function setPageTitle($title)
    {
        view()->share('pageTitle', $title);
    }
}
