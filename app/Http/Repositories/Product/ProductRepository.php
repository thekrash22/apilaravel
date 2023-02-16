<?php

namespace App\Http\Repositories\Product;

use App\Http\Repositories\Base\BaseRepository;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;

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
                    break;
                case 'user_id':
                    $query = $query->where('user_id', $value);
                    break;
            }
        }
        return $query;
    }

    public function list(\Illuminate\Http\Request $request)
    {
        $query = $this->model->select('*');
        $query = $this->filterQuery($query, $request->all());
        return $query->paginate($request->paginate);
    }

    public function deleteMyProduct($id)
    {
        $user_id = Auth::id();
        $product = $this->model->where('user_id', $user_id)->where('id', $id)->first();

        if ($product) {
            $this->delete($id);
            return ['Message' => 'El producto fue eliminado exitosamente'];
        }
        else {
            return ['Message' => 'El producto no pudo ser eliminado porque no existe o no te pertenece'];
        }

    }
}
