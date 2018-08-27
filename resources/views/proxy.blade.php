@extends('layouts.app')

@section('content')
<div class="container">
  <div class="flex-center position-ref full-height">
    <div class="row col-md-12" style="color: #777">
      <?php
       error_reporting(E_ALL);
       $ch = curl_init();
       curl_setopt($ch, CURLOPT_URL, "http://2ip.ru/");
       curl_setopt($ch, CURLOPT_PROXY, '127.0.0.1:9050');
       curl_setopt($ch, CURLOPT_PROXYTYPE, CURLPROXY_SOCKS5);
       $result = curl_exec($ch);
       curl_close($ch);
       echo $result;
      ?>
      OK: https://tengrinews.kz/ NOT: https://whoer.net/ru
      <div style="padding:5px;">
      <input type="text" id="url_name" value="">
      <button type="button" id="go_to" name="button">GO</button>
    </div>
      <iframe id="my_iframe" width="100%" style="min-height:500px;" src="https://www.tengrinews.kz/">
        <p>Your browser does not support iframes.</p>
      </iframe>
      <script type="text/javascript">
        $(document).ready(function(){

          $('#go_to').on('click', function(e) {
            $('#my_iframe').attr('src', $('#url_name').val());
          });
        });
      </script>
    </div>
  </div>
</div>
@endsection
