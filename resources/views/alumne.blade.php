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
