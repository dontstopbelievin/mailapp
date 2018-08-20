@extends('layouts.app')

@section('content')
<div class="container">
  <div class="flex-center position-ref full-height">
    <div class="row col-md-12" style=" color: #777">
      Максимальное количество попыток отправки: 10
    </div>
    <div class="table">
      <table class="table_source text-center" border=1 align=center>
        <tr>
          <th>Номер</th><th>Попыток отправки</th><th>Зарезервирован до</th><th>Дата отправления</th>
        </tr>
      @if(count($jobs) > 0)
          @foreach ($jobs as $job)
            <tr>
              <td>{{ $job->id }}</td>
              <td>{{ $job->attempts}}</td>
              @if($job->available_at < time())
              <td>В очереди</td>
              @else
              <td>{{ date('d/m/Y H:i:s', $job->available_at+6*3600) }}</td>
              @endif
              <td>{{ date('d/m/Y H:i:s', $job->created_at+6*3600) }}</td>
            </tr>
          @endforeach
          <tr>
            <td></td>
            <td><form method="post" action="/clear_attempts">
              <input type="hidden" name="_token" value="{{ csrf_token() }}">
              <button type="submit" class="btn btn-sm btn-success">Обнулить попытки</button></form></td>
            <td><form method="post" action="/run_jobs">
              <input type="hidden" name="_token" value="{{ csrf_token() }}">
              <button type="submit" class="btn btn-sm btn-success">Запустить всю очередь</button></form></td>
            <td></td>
          </tr>
        @else
          <tr><td colspan=4>Список пуст</td></tr>
        @endif
      </table>
    </div>
  </div>
</div>
@endsection
