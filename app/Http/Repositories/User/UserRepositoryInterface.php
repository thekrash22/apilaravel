<?php


namespace App\Http\Repositories\User;
use App\Http\Repositories\Base\BaseRepositoryInterface;

interface UserRepositoryInterface extends BaseRepositoryInterface
{
    public function register(array $data);
    public function login(string $email, string $password);
    public function searchByName($name);
}
