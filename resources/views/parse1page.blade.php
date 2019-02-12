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
<body>
  <?php $lpage = $_GET['lpage'];?>
  <a class="btn btn-primry" href="/parse1?page={{$lpage}}">Назад</a>
  @if(!empty($html->html))
    {!! $html->html !!}
  @endif
</body>
</html>
