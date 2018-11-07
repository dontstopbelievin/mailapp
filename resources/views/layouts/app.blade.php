<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Directmail Kazakhstan</title>

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link rel="icon" type="favicon.ico" href="/storage/images/favicon.ico" />

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}"></script>
</head>
<body>
    <div id="app">
      <div class="container-fluid h-100">
          <div class="row h-100">
              @include('inc.sidebar')
              <div class="container">
                <div class="card">
                  <div class="card-body">
                    <div class="py-4">
                      @include('inc.messages')
                      @yield('content')
                    </div>
                  </div>
                </div>
              </div>>
          </div>
      </div>
    </div>

</body>
</html>
