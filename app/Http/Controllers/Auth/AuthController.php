<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Repositories\User\UserRepositoryInterface;
use App\Http\Requests\AuthRequest;
use App\Http\Requests\UserStoreRequest;
use Exception;
use Illuminate\Http\Exceptions\HttpResponseException;

use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use OutOfBoundsException;
use App\Utils\Constants\ResponseMessages;
use App\Utils\Enums\HttpResponseEnum;


class AuthController extends Controller
{
    private $userRepository;

    public function __construct(UserRepositoryInterface $userRepositoryInterface)
    {
        $this->userRepository = $userRepositoryInterface;
    }

    public function register(UserStoreRequest $request){
        try{
            $userToken = $this->userRepository->register($request->all());
            return \ResponseHelper::GetSuccesResponse(['access_token' => $userToken, 'token_type' => 'Bearer'], HttpResponseEnum::HTTP_CREATED);
        }catch (HttpResponseException $e) {
            return \ResponseHelper::GetErrorResponse(ResponseMessages::UNAUTHORIZED, $e, HttpResponseEnum::HTTP_UNAUTHORIZED);
        }
    }

    public function login(AuthRequest $request)
    {
        try{
            $userToken = $this->userRepository->login($request['email'], $request['password']);
            return \ResponseHelper::GetSuccesResponse(['access_token' => $userToken, 'token_type' => 'Bearer'], HttpResponseEnum::HTTP_OK);
        }catch (OutOfBoundsException $e) {
            return \ResponseHelper::GetErrorResponse(ResponseMessages::NOT_FOUND_ERROR_RESPONSE, $e,HttpResponseEnum::HTTP_NOT_FOUND);
        }catch (HttpResponseException $e) {
            return \ResponseHelper::GetErrorResponse(ResponseMessages::UNAUTHORIZED, $e, HttpResponseEnum::HTTP_UNAUTHORIZED);
        } catch (ModelNotFoundException $e) {
            return \ResponseHelper::GetErrorResponse(ResponseMessages::NOT_FOUND_ERROR_RESPONSE, $e, HttpResponseEnum::HTTP_NOT_FOUND);
        } catch (Exception $e) {
            return \ResponseHelper::GetErrorResponse(ResponseMessages::GENERIC_ERROR_MESSAGE, $e, HttpResponseEnum::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function me(Request $request)
    {
        return $request->user();
    }

}
