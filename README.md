# api-auth
## for passport installation 
```
php artisan migrate
```
```
php artisan passport:install
```
at .env add this lines and replace the values with your own generated from passport install

```
PASSPORT_GRANT_CLIENT_ID=${GRANT_CLIENT_ID}
PASSPORT_GRANT_CLIENT_SECRET=${GRANT_CLIENT_SECRET}
```



## add this code at the api user model
```
<?php
 
namespace App\Models;
 
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;
 
class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;
}
```
## at AuthServiceProvider boot function add this code

```
use Illuminate\Auth\Notifications\ResetPassword;
use Laravel\Passport\Passport;
```

```

    $this->registerPolicies();
    
    if (! $this->app->routesAreCached()) {
        Passport::routes();
    }

    Passport::tokensExpireIn(now()->addHours(6));
    Passport::refreshTokensExpireIn(now()->addDays(7));

    ResetPassword::createUrlUsing(function ($user, string $token) {
        return env('SPA_URL') . '/reset-password?token=' . $token;
    });
```
at routes/api.php add this code
```
use Mmo7amed2010\Apiauth\Apiauth;
```
```
Apiauth::Routes();
```
