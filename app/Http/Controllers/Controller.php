<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

abstract class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public $module;
    public $parent_module;
    public function __construct()
    {
        \View::share('active',[$this->module=>'active']);
        \View::share('parent_active',[$this->parent_module=>'active']);
    }
}
