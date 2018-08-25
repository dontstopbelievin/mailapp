@extends('layouts.app')

@section('content')
<div class="container">
  <div class="flex-center position-ref full-height">
    <div class="row col-md-12" style="color: #777">
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
