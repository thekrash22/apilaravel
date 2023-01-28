<?php


namespace App\Http\Repositories\User;

use App\Http\Repositories\Base\BaseRepository;
use App\Models\User;

use App\Http\Repositories\User\UserRepositoryInterface;
use App\Utils\Constants\ResponseMessages;
use App\Utils\Enums\HttpResponseEnum;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;




class UserRepository extends BaseRepository implements UserRepositoryInterface {
    /**
     * Repository constructor.
     * @param User $model
     */
    public function __construct(User $model) {
        parent::__construct($model);
        $this->model = $model;
    }
    public function searchByName($name) {
        $product = $this->model->where('name',$name)->first();
        return $product;
    }

    public function register(array $data) {
        $user = $this->create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
        ]);

        return $user->createToken('auth_token')->plainTextToken;
    }

    public function login($email, $password) {
        $user = $this->model->where('email', $email)->firstOrFail();
        if (!Auth::attempt(['email' => $email, 'password' => $password])) {
            throw new HttpResponseException(
                \ResponseHelper::GetErrorFromRequest(
                    ResponseMessages::REQUEST_MODEL_ERROR_RESPONSE,
                    ['message' => 'Username or password invalid'],
                    HttpResponseEnum::HTTP_UNAUTHORIZED
                )
            );
        }
        $user = $this->model->where('email', $email)->firstOrFail();
        $token = $user->createToken('auth_token')->plainTextToken;
        return $token;
    }
}
