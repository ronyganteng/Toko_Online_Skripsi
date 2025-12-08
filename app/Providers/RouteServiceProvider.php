<?php

namespace App\Providers;

use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Route;
use Illuminate\Auth\Notifications\ResetPassword;
use Illuminate\Support\Facades\URL;

class RouteServiceProvider extends ServiceProvider
{
    public const HOME = '/home';

    public function boot(): void
    {
        $this->configureRateLimiting();

        // ✔ Override link email agar menuju route customer.password.reset
        ResetPassword::toMailUsing(function ($notifiable, $token) {
            $url = url(route('customer.password.reset', [
                'token' => $token,
                'email' => $notifiable->email
            ], false));

            return (new \Illuminate\Notifications\Messages\MailMessage)
                ->subject('Reset Password Account Anda')
                ->line('Anda menerima email ini karena ada permintaan reset password.')
                ->action('Reset Password', $url)
                ->line('Jika Anda tidak meminta reset password, abaikan email ini.');
        });

        $this->routes(function () {
            Route::middleware('api')->prefix('api')
                ->group(base_path('routes/api.php'));

            Route::middleware('web')
                ->group(base_path('routes/web.php'));
        });
    }

    protected function configureRateLimiting(): void
    {
        RateLimiter::for('api', function (Request $request) {
            return Limit::perMinute(60)->by($request->user()?->id ?: $request->ip());
        });
    }
}
