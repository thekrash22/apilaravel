<?php

namespace App\Http\Repositories\Product;

use App\Http\Repositories\Base\BaseRepositoryInterface;

interface ProductRepositoryInterface extends BaseRepositoryInterface {

    public function list(\Illuminate\Http\Request $request);
    public function deleteMyProduct($id);
}
