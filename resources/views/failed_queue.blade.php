@extends('layouts.app')

@section('content')
<div class="container">
  <div class="flex-center position-ref full-height">
    <div class="table">
      <table class="table_source text-center" border=1 align=center>
        <tr>
          <th>Номер</th><th>Вид ошибки</th><th>Дата ошибки</th><th>Действие</th>
        </tr>
        @if(count($failed_jobs) > 0)
          @foreach ($failed_jobs as $failed_job)
            <?php
              $fail_date = strtotime($failed_job->failed_at);
            ?>
              <tr>
                <td>{{ $failed_job->id }}</td>
                @if(strlen($failed_job->exception) > 100)
                <td title="{{ $failed_job->exception }}">{{ substr($failed_job->exception, 0, 100) }} ...</td>
                @else
                <td>{{ $failed_job->exception }}</td>
                @endif
                <td>{{ date('d/m/Y H:i:s', $fail_date+6*3600) }}</td>
                <td><form method="post" action="{{'try_again/'.$failed_job->id}}">
                  <input type="hidden" name="_token" value="{{ csrf_token() }}">
                  <button type="submit" class="btn btn-sm btn-success">Попробывать отправить снова</button></form></td>
              </tr>
          @endforeach
          </table>
          <div style="padding:10px;">
            <form method="post" action="try_again_all" style="display:inline-block;">
              <input type="hidden" name="_token" value="{{ csrf_token() }}">
              <button type="submit" class="btn btn-sm btn-success">Попробывать отправить все снова</button>
            </form>
            <form method="post" action="delete_failed_all" style="display:inline-block;">
              <input type="hidden" name="_token" value="{{ csrf_token() }}">
              <button type="submit" class="btn btn-sm btn-danger">Удалить все</button>
            </form>
          </div>
        @else
          <tr><td colspan=4>Список пуст</td></tr></table>
        @endif
    </div>
  </div>
</div>
@endsection
