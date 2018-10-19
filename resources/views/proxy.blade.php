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
  {{ $domains->links() }}
  <table style="border-collapse: collapse;">
    <tr style="background-color:rgba(0, 0, 255, 0.05);">
      <th>domain_name</th><th>name</th><th>organization_name</th><th>street_address</th><th>city</th>
      <th>state</th><th>postal_code</th><th>country</th><th>nic_handle</th><th>agent_name</th>
      <th>phone_number</th><th>fax_number</th><th>email</th>
    </tr>
    <?php $check = true; ?>
    @foreach ($domains as $domain)
    @if($check == true)
      <tr style="background-color:rgba(0, 0, 255, 0.05);">
        <td>{{$domain->domain_name}}</td><td>{{$domain->name}}</td><td>{{$domain->organization_name}}</td><td>{{$domain->street_address}}</td><td>{{$domain->city}}</td>
        <td>{{$domain->state}}</td><td>{{$domain->postal_code}}</td><td>{{$domain->country}}</td><td>{{$domain->nic_handle}}</td><td>{{$domain->agent_name}}</td>
        <td>{{$domain->phone_number}}</td><td>{{$domain->fax_number}}</td><td>{{$domain->email}}</td>
      </tr>
      <?php $check = false; ?>
    @else
      <tr style="background-color:rgba(0, 255, 0, 0.05);">
        <td>{{$domain->domain_name}}</td><td>{{$domain->name}}</td><td>{{$domain->organization_name}}</td><td>{{$domain->street_address}}</td><td>{{$domain->city}}</td>
        <td>{{$domain->state}}</td><td>{{$domain->postal_code}}</td><td>{{$domain->country}}</td><td>{{$domain->nic_handle}}</td><td>{{$domain->agent_name}}</td>
        <td>{{$domain->phone_number}}</td><td>{{$domain->fax_number}}</td><td>{{$domain->email}}</td>
      </tr>
      <?php $check = true; ?>
    @endif
    @endforeach
  </table>
</body>
</html>
