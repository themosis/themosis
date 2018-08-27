<?php

namespace App\Http\Controllers;

use Illuminate\Routing\Controller as BaseController;
use Themosis\Core\Forms\FormHelper;
use Themosis\Core\Validation\ValidatesRequests;

class Controller extends BaseController
{
    use FormHelper, ValidatesRequests;
}
