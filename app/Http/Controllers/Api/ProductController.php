<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Repositories\Product\ProductRepositoryInterface;
use App\Http\Requests\CreateproductRequest;
use Illuminate\Http\Request;
use Exception;
use OutOfBoundsException;
use App\Helpers\ResponseHelper;
use App\Utils\Enums\HttpResponseEnum;
use App\Utils\Constants\ResponseMessages;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class ProductController extends Controller
{
    private $productRepository;

    public function __construct(ProductRepositoryInterface $productRepositoryInterface) {
        $this->productRepository = $productRepositoryInterface;
    }
    public function index(Request $request)
    {
        try {
            $products = $this->productRepository->list($request);
            return \ResponseHelper::GetSuccesResponse($products, HttpResponseEnum::HTTP_OK);
        } catch (OutOfBoundsException $e) {
            return \ResponseHelper::GetErrorResponse(ResponseMessages::NOT_FOUND_ERROR_RESPONSE, $e, HttpResponseEnum::HTTP_NOT_FOUND);
        } catch (ModelNotFoundException $e) {
            return \ResponseHelper::GetErrorResponse(ResponseMessages::NOT_FOUND_ERROR_RESPONSE, $e, HttpResponseEnum::HTTP_NOT_FOUND);
        } catch (Exception $e) {
            return \ResponseHelper::GetErrorResponse(ResponseMessages::GENERIC_ERROR_MESSAGE, $e, HttpResponseEnum::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function store(CreateproductRequest $request){
        try{
            $product = $this->productRepository->create($request->all());
            return \ResponseHelper::GetSuccesResponse($product, HttpResponseEnum::HTTP_CREATED);
        }catch (HttpResponseException $e) {
            return \ResponseHelper::GetErrorResponse(ResponseMessages::UNAUTHORIZED, $e, HttpResponseEnum::HTTP_UNAUTHORIZED);
        }
    }

    public function update(CreateproductRequest $request, $id){
        try {
            $product = $this->productRepository->update($request->all(), $id);
            return \ResponseHelper::GetSuccesResponse($product, HttpResponseEnum::HTTP_OK);
        }
        catch (ModelNotFoundException $e) {
            return \ResponseHelper::GetErrorResponse(ResponseMessages::NOT_FOUND_ERROR_RESPONSE, $e, HttpResponseEnum::HTTP_NOT_FOUND);
        } catch (HttpResponseException $e) {
            return \ResponseHelper::GetErrorResponse(ResponseMessages::UNAUTHORIZED, $e, HttpResponseEnum::HTTP_UNAUTHORIZED);
        }
    }
}
