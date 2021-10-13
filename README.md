# laravel_basic
Exemple de creació d'un projecte Laravel sense complicacions
# Crear projecte Laravel

Crear un nou projecte Laravel:

```bash
composer create-project --prefer-dist laravel/laravel test
```

Provar que funciona:

```bash
php artisan serve
```

![Untitled](docs/Untitled%202.png)

![Untitled](docs/Untitled%203.png)

Ara modificarem les variables d'entorn per apuntar a la nostra base de dades en local. Suposarem que voldrem tenir una BD anomenada **Institut** on dins tindrem la taula **Alumnes** per la gestió d'aquests.

Crea tu mateix/a la base de dades **Institut** usant **phpMyAdmin** per exemple.

```bash
nano .env
```

![Untitled](docs/Untitled%204.png)

Ja que hem configurat la BD, podem generar el Model per l'objecte Alumnes:

```bash
php artisan make:model Alumne --migration
```

Ara modifiquem l'arxiu de migracions i afegim alguns camps més:

```bash
nano database/migrations/[arxiu de migració]
```

Afegirem els camps nom, cognoms i data_naixement:

```bash
$table->string('nom');
$table->string('cognoms');
$table->date('data_naixement');
```

![Untitled](docs/Untitled%205.png)

Provem que la migració funciona correctament i que l'aplicació és capaç de trobar la BD:

```bash
php artisan migrate
```

![Untitled](docs/Untitled%206.png)

Si tot ha anat bé haurem de tenir la taula d'alumnes (i les altres que Laravel ens inclou per defecte) a la nostra base de dades:

![Untitled](docs/Untitled%207.png)

Per no haver d'entrar manualment dades de prova, utilitzarem les **Factories** i els **Seeders** que ens brinda Laravel.

Creem una **Factory** per l'objecte Alumne:

```bash
php artisan make:factory AlumneFactory --model=Alumne
```

Editem aquesta **Factory** per dir-li quines dades s'ha d'inventar:

```bash
nano database/factories/AlumneFactory.php
```

I fem que s'inventi el nom, els cognoms i la data de naixement:

```bash
public function definition()
{
    return [
        "nom" => $this->faker->firstName,
        "cognoms" => $this->faker->lastName . " " . $this->faker->lastName, 
        "data_naixement" => $this->faker->date($format = 'Y-m-d', $max = 'now')
    ]; 
}
```

![Untitled](docs/Untitled%208.png)

Ara cal editar la classe **Seeders** per dir-li quants objectes s'ha d'inventar:

```bash
nano database/seeders/DatabaseSeeder.php
```

A la capçalera de la classe hem d'importar el model Alumne:

```bash
use App\Models\Alumne;
```

I dins de la funció run() li hem de dir quants alumnes s'ha d'inventar:

```bash
Alumne::factory()->times(50)->create();
```

![Untitled](docs/Untitled%209.png)

Ara cal llençar la comanda que ens omplirà la taula Alumnes de dades aleatòries:

```bash
php artisan db:seed
```

Si tot ha anat bé ja tindrem 50 alumnes creats amb dades aleatòries:

![Untitled](docs/Untitled%2010.png)

Ara crearem el controlador d'Alumnes. Serà un controlador molt bàsic on en la seva funció **index()** ens recuperarà el llistat de tots els alumnes i ens l'enviarà a una vista:

```bash
php artisan make:controller AlumneController --resource
```

```bash
nano app/Http/Controllers/AlumneController.php
```

Recorda importar el model:

```bash
use App\Models\Alumne;
```

Modifiquem la funció **index()** perquè quedi així:

```bash
public function index()
{
   $alumnes = Alumne::paginate(10);
   return view("alumne", compact("alumnes")); 
}
```

![Untitled](docs/Untitled%2011.png)

Tot seguit haurem de crear la vista

```bash
nano resources/views/alumne.blade.php
```

```bash
<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>
    
    <!-- Styles -->
    <link href="{{ mix('css/app.css') }}" rel="stylesheet">
</head>
<body>
    <div id="app">
        <main class="container">
            <div>
                <div>
                    <div class="text-center my-3">
                        <h1>{{ __("Llistat d'alumnes") }}</h1>
                    </div>
                </div>

                <table class="table">
                    <thead>
                    <tr>
                        <th scope="col">{{ __("Id") }}</th>
                        <th scope="col">{{ __("Nom") }}</th>
                        <th scope="col">{{ __("Cognoms") }}</th>
                        <th scope="col">{{ __("Data naixement") }}</th>
                    </tr>
                    </thead>
                    <tbody>
                        @forelse($alumnes as $alumne)
                            <tr>
                                <td>{{ $alumne->id }}</td>
                                <td>{{ $alumne->nom }}</td>
                                <td>{{ $alumne->cognoms }}</td>
                                <td>{{ date_format(new DateTime($alumne->data_naixement), "d/m/Y") }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4">
                                    <div>
                                        <p><strong>{{ __("No hi ha alumnes") }}</strong></p>
                                        <span>{{ __("No hi ha cap dada a mostrar") }}</span>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>

                <div class="d-flex justify-content-center">
                    {{ $alumnes->links() }}
                </div>
            </div>
        </main>
    </div>
</body>
</html>
```

Finalment canviarem l'enrutament per defecte, i en comptes d'anar a buscar la vista **welcome** anirem a buscar el controlador **AlumneController**:

```bash
nano routes/web.php
```

```bash
Route::resource('/', AlumneController::class);
```

Recorda també d'importar el controlador, sinó el sistema no el trobarà:

```bash
use App\Http\Controllers\AlumneController;
```

![Untitled](docs/Untitled%2012.png)

Ja tenim la nostra aplicació acabada. Si anem a veure com ens ha quedat veiem quelcom semblant a:

![Untitled](docs/Untitled%2013.png)

És correcte, però no té cap tipus d'estil. Anem a posar-hi bootstrap. A l'arrel del projecte executem:

```bash
composer require laravel/ui
```

I tot seguit:

```bash
php artisan ui bootstrap
```

Finalment empaquetem l'aplicació:

```bash
npm install && run production
```

Si ho hem fet bé quedaria semblant a:

![Untitled](docs/Untitled%2014.png)

Si veus que la paginació no es veu de forma correcta, cal indicar-li a Laravel que ha de fer servir bootstrap. Edita `app/Providers/AppServiceProvider.php` perquè quedi així:

```bash
<?php

namespace App\Providers;
use Illuminate\Support\ServiceProvider;

use Illuminate\Pagination\Paginator;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Paginator::useBootstrap();
    }
}
```
