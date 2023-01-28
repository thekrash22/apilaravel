<?php

namespace App\Http\Repositories\Product;

use App\Http\Repositories\Base\BaseRepository;
use App\Models\Product;

class ProductRepository extends BaseRepository implements ProductRepositoryInterface {
    /**
     * Repository constructor.
     * @param Product $model
     */
    public function __construct(Product $model)
    {
        parent::__construct($model);
        $this->model = $model;
    }

    private function filterQuery($query, array $data)
    {
        foreach($data as $key => $value){
            switch($key){
                case 'active':
                    $query = $query->where('active',$value);
                    break;
                case 'price':
                    $query = $query->where('price', $value);
                    break;
                case 'name':
                    $query = $query->where('name', $value);
            }
        }
        return $query;
    }
}
