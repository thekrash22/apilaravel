<?php

namespace App\Utils\Models;

use App\Utils\Models\BaseResponseModel;

class ErrorResponseModel extends BaseResponseModel
{
    public $message = '';
    public $exceptionMessage = '';
    public $errors = [];
}
