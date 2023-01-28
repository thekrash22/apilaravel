<?php

namespace App\Utils\Constants;

abstract class ResponseMessages
{
    const REQUEST_MODEL_ERROR_RESPONSE = "Please check the sent values";
    const GENERIC_ERROR_MESSAGE = "An error occurred during the request";
    const NOT_FOUND_ERROR_RESPONSE = "Not found";
    const NOT_VALID = "Bad request";
    const UNAUTHORIZED = "Access Denied You don't have permission to access";
}
