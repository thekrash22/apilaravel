<?php

namespace App\Http\Repositories\Category;

use App\Http\Repositories\Base\BaseRepository;
use App\Models\Category;

class CategoryRepository extends BaseRepository implements CategoryRepositoryInterface {
    /**
     * Repository constructor.
     * @param Category $model
     */
    public function __construct(Category $model)
    {
        parent::__construct($model);
        $this->model = $model;
    }

    public function list($request){
        $query = $this->model->select('*');
        $query = $this->filterQuery($query, $request->all());
        return $query->paginate($request->paginate ?? 10);
    }
    private function filterQuery($query, array $data)
    {
        foreach($data as $key => $value){
            switch($key){
                case 'name':
                    $query = $query->where('name', 'like', '%' . $value . '%');
            }
        }
        return $query;
    }
}
