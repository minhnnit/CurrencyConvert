<?php namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use DB;

class AppServiceProvider extends ServiceProvider {

	/**
	 * Bootstrap any application services.
	 *
	 * @return void
	 */
	public function boot()
	{
        $settings = DB::table('properties')->whereIn('key',['header','footer','adsense'])->get();
        $adsense = $header = $footer = null;
        foreach ($settings as $s) {
            if($s->key === 'adsense'){
                $adsense = $s->foreign_key_left;
            }else if($s->key === 'header'){
                $header = $s->foreign_key_left;
            }else if($s->key === 'footer'){
                $footer = $s->foreign_key_left;
            }
        }
        view()->share('settings', ['adsense' => $adsense,'header' => $header, 'footer'=>$footer]);
	}

	/**
	 * Register any application services.
	 *
	 * This service provider is a great spot to register your various container
	 * bindings with the application. As you can see, we are registering our
	 * "Registrar" implementation here. You can add your own bindings too!
	 *
	 * @return void
	 */
	public function register()
	{
		$this->app->bind(
			'Illuminate\Contracts\Auth\Registrar',
			'App\Services\Registrar'
		);
	}

}
