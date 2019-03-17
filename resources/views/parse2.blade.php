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
  table, th, td.my_list {
      border: 1px solid black;
      text-align: center;
      margin:auto;
  }
  </style>
  <table style="border:0px!important">
    <tr>
      <td>{{ $kadastr_tables->links() }}</td><td><a class="btn btn-primary btn-sm" href="parse2search/20321021172?lpage={{ $kadastr_tables->currentPage()}}">20321021172</a></td>
    </tr>
  </table>
  <table style="border-collapse: collapse;">
    <tr style="background-color:rgba(0, 0, 255, 0.05);">
        <th>Кадастровый номер</th>
    </tr>
    <!--<tr>
      <td>
        <form class="" action="/parse1/delete" method="post">
            <input type="hidden" name="_token" id="csrf-token" value="{{ Session::token() }}" />
            <button type="submit" class="btn btn-primry">Удалить ошибки с базы</button>
        </form>
      </td>
    </tr>-->
    <?php $check = true; ?>
    @foreach ($kadastr_tables as $kadastr_table)
    @if($check == true)
      <tr style="background-color:rgba(0, 0, 255, 0.05);">
        <td><a class="btn btn-primary btn-sm" href="parse2page/{{$kadastr_table->id}}?lpage={{ $kadastr_tables->currentPage()}}">{{$kadastr_table->kadastr_number}}</a></td>
      </tr>
      <?php $check = false; ?>
    @else
      <tr style="background-color:rgba(0, 255, 0, 0.05);">
        <td><a class="btn btn-primary btn-sm" href="parse2page/{{$kadastr_table->id}}?lpage={{ $kadastr_tables->currentPage()}}">{{$kadastr_table->kadastr_number}}</a></td>
      </tr>
      <?php $check = true; ?>
    @endif
    @endforeach
  </table>
</body>
</html>
