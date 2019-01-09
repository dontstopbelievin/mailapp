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
      margin:auto;
  }
  </style>
  {{ $kadastr_tables->links() }}
  <table style="border-collapse: collapse;">
    <tr style="background-color:rgba(0, 0, 255, 0.05);">
        <th>Кадастровый номер</th>
    </tr>
    <?php $check = true; ?>
    @foreach ($kadastr_tables as $kadastr_table)
    @if($check == true)
      <tr style="background-color:rgba(0, 0, 255, 0.05);">
        <td><a class="btn btn-primary btn-sm" href="parse1page/{{$kadastr_table->id}}">{{$kadastr_table->kadastr_number}}</a></td>
      </tr>
      <?php $check = false; ?>
    @else
      <tr style="background-color:rgba(0, 255, 0, 0.05);">
        <td><a class="btn btn-primary btn-sm" href="parse1page/{{$kadastr_table->id}}">{{$kadastr_table->kadastr_number}}</a></td>
      </tr>
      <?php $check = true; ?>
    @endif
    @endforeach
  </table>
</body>
</html>
