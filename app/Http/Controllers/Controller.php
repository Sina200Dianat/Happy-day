<?php

namespace App\Http\Controllers;

use Illuminate\Routing\Controller as BaseController;

abstract class Controller extends BaseController
{
    // Base controller now extends the framework controller so middleware()
    // and other helper methods are available. 💕
}
