<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Repositories\Category\CategoryRepositoryInterface;
use App\Http\Requests\CreateCategoryRequest;
use Illuminate\Http\Request;
use Exception;
use OutOfBoundsException;
use App\Helpers\ResponseHelper;
use App\Utils\Enums\HttpResponseEnum;
use App\Utils\Constants\ResponseMessages;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class CategoryController extends Controller
{
    private $categoryRepository;

    public function __construct(CategoryRepositoryInterface $categoryRepositoryInterface){
        $this->categoryRepository = $categoryRepositoryInterface;
    }

    public function index(Request $request)
    {
        try {
            $categories = $this->categoryRepository->list($request);
            return \ResponseHelper::GetSuccesResponse($categories, HttpResponseEnum::HTTP_OK);
        } catch (OutOfBoundsException $e) {
            return \ResponseHelper::GetErrorResponse(ResponseMessages::NOT_FOUND_ERROR_RESPONSE, $e, HttpResponseEnum::HTTP_NOT_FOUND);
        } catch (ModelNotFoundException $e) {
            return \ResponseHelper::GetErrorResponse(ResponseMessages::NOT_FOUND_ERROR_RESPONSE, $e, HttpResponseEnum::HTTP_NOT_FOUND);
        } catch (Exception $e) {
            return \ResponseHelper::GetErrorResponse(ResponseMessages::GENERIC_ERROR_MESSAGE, $e, HttpResponseEnum::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function store(CreateCategoryRequest $request){
        try{
            $category = $this->categoryRepository->create($request->all());
            return \ResponseHelper::GetSuccesResponse($category, HttpResponseEnum::HTTP_CREATED);
        }catch (HttpResponseException $e) {
            return \ResponseHelper::GetErrorResponse(ResponseMessages::UNAUTHORIZED, $e, HttpResponseEnum::HTTP_UNAUTHORIZED);
        }
    }

    public function update(CreateCategoryRequest $request, $id){
        try {
            $category = $this->categoryRepository->update($request->all(), $id);
            return \ResponseHelper::GetSuccesResponse($category, HttpResponseEnum::HTTP_OK);
        }
        catch (ModelNotFoundException $e) {
            return \ResponseHelper::GetErrorResponse(ResponseMessages::NOT_FOUND_ERROR_RESPONSE, $e, HttpResponseEnum::HTTP_NOT_FOUND);
        } catch (HttpResponseException $e) {
            return \ResponseHelper::GetErrorResponse(ResponseMessages::UNAUTHORIZED, $e, HttpResponseEnum::HTTP_UNAUTHORIZED);
        }
    }

}
