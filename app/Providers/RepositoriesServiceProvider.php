<?php
namespace App\Providers;

use App\Interfaces\AuthenticationRepositoryInterface;
use App\Interfaces\BaseRepositoryInterface;
use App\Repositories\AuthenticationRepository;
use App\Repositories\BaseRepository;
use Illuminate\Support\ServiceProvider;


class RepositoriesServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {

    }


    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(BaseRepositoryInterface::class, BaseRepository::class);
        $this->app->bind(AuthenticationRepositoryInterface::class, AuthenticationRepository::class);

    }
}
