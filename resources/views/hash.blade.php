<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}" style="padding:0px!important;">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Mail dispatcher</title>

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link rel="icon" type="favicon.ico" href="/storage/images/favicon.ico" />

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}"></script>
</head>
<body style="margin:20px">
  <style>
  table, th, td {
      border: 1px solid black;
      text-align: center;
  }
  </style>
  <form class="" action="/makehash" method="post">
    <input type="hidden" name="_token" value="{{ csrf_token() }}">
    <input type="text" name="password" value="">
    <button type="submit" class="btn btn-sm btn-success">Получить хэш</button>
  </form>

</body>
</html>
