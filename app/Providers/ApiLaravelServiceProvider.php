<?php

namespace App\Providers;

use App\Http\Repositories\Category\CategoryRepository;
use App\Http\Repositories\Category\CategoryRepositoryInterface;
use App\Http\Repositories\Product\ProductRepository;
use App\Http\Repositories\Product\ProductRepositoryInterface;
use App\Http\Repositories\User\UserRepository;
use App\Http\Repositories\User\UserRepositoryInterface;
use Illuminate\Support\ServiceProvider;

class ApiLaravelServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    protected $repositories = [
        UserRepositoryInterface::class => UserRepository::class,
        CategoryRepositoryInterface::class => CategoryRepository::class,
        ProductRepositoryInterface::class => ProductRepository::class,
    ];

    public function register()
    {
        foreach ($this->repositories as $interface => $repository)
        {
            $this->app->bind($interface, $repository);
        }
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
