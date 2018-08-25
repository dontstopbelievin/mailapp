@extends('layouts.app')

@section('content')
<div class="container">
  <div class="flex-center position-ref full-height">
    <div class="row">
      <div class="row col-md-12" style=" color: #777">
        <button class="btn btn-success btn-sm" data-toggle="modal" data-target="#myModal">Добавить почту</button>
      </div>
      <div class="row col-md-12" style=" color: #777">
        Максимальное количество сообщений одной почты в день: 500
      </div>
      <div class="col-md-6 text-center">
        <h4>Активные почты</h4>
        <div class="table">
          <table class="table_source text-center" border=1 align=center>
            <tr>
              <th>Emails</th><th>Сегодня отправлено</th><th>Всего отправлено</th><th>Всего неудачных попыток</th><th>Действие</th>
            </tr>
          @if(count($emails['active']) > 0)
            @foreach ($emails['active'] as $email)
                <tr>
                  <td>{{ $email->email }}</td>
                  <td>{{ $email->mails_today }}</td>
                  <td>{{ $email->mails_total }}</td>
                  <td>{{ $email->attempts_total }}</td>
                  <td><button class="btn btn-sm btn-danger" data-id="{{$email->id}}" data-toggle="modal" data-target="#delete_modal">Удалить</button>
                    <form action="{{'/disable_email/'.$email->id}}" method="post">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    <button class="btn btn-sm btn-warning">Отключить</button>
                  </form></td>
                </tr>
            @endforeach
          @else
            <tr><td colspan=5>Список пуст</td></tr>
          @endif
          </table>
        </div>
      </div>
      <div class="col-md-6 text-center">
        <h4>Неактивные почты</h4>
        <div class="table">
          <table class="table_source text-center" border=1 align=center>
            <tr>
              <th>Emails</th><th>Сегодня отправлено</th><th>Всего отправлено</th><th>Всего неудачных попыток</th><th>Действие</th>
            </tr>
          @if(count($emails['inactive']) > 0)
            @foreach ($emails['inactive'] as $email)
                <tr>
                  <td>{{ $email->email }}</td>
                  <td>{{ $email->mails_today }}</td>
                  <td>{{ $email->mails_total }}</td>
                  <td>{{ $email->attempts_total }}</td>
                  <td><button class="btn btn-sm btn-danger" data-id="{{$email->id}}" data-toggle="modal" data-target="#delete_modal">Удалить</button>
                  @if($email->status == 2)
                    <form action="{{'/enable_email/'.$email->id}}" method="post">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    <button class="btn btn-sm btn-warning">Включить</button>
                    </form>
                  @endif
                  </td>
                </tr>
            @endforeach
          @else
            <tr><td colspan=5>Список пуст</td></tr>
          @endif
          </table>
        </div>
      </div>
<div class="modal" id="myModal">
  <div class="modal-dialog">
    <div class="modal-content">
      <!-- Modal Header -->
      <div class="modal-header">
        <h4 class="modal-title">Добавить новую почту</h4>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>
      <!-- Modal body -->
      <div class="modal-body">
        <form method="post" action="add_email">
          <input type="hidden" name="_token" value="{{ csrf_token() }}">
          <div class="form-group row">
              <label for="email" class="col-md-4 col-form-label text-md-right">Email</label>
              <input type="text" class="col-md-4 form-control" name="email" value="" required>
          </div>
          <div class="form-group row">
              <label for="password" class="col-md-4 col-form-label text-md-right">Пароль</label>
              <input type="text" class="col-md-4 form-control" name="password" value="" required>
          </div>
          <div class="form-group row">
            <div style="margin:auto;">
              <button type="submit" class="btn btn-sm btn-success">Добавить</button>
            </div>
          </div>
        </form>
      </div>
      <!-- Modal footer -->
      <div class="modal-footer">
        <button type="button" class="btn btn-danger btn-sm" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>
<div class="modal" id="delete_modal">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-body">
        <div>
        <table id ="delete_table">
          <tr>
            <td align=center>
              Вы действительно хотите удалить?<br>
              <form name="delete_form" action="" method="post" style="display:inline-block;">
                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                <button type="submit" class="btn btn-warning " data-id="">Да</button>
              </form>
              <button class="btn btn-success" data-dismiss="modal">Нет</button>
            </td>
          </tr>
        </table>
      </div>
      </div>
    </div>
  </div>
</div>
    </div>
  </div>
</div>
<script type="text/javascript">
$(document).ready(function(){
  //delete item through api
  $('#delete_modal').on('show.bs.modal', function(e) {
    //get data-id attribute of the clicked element
    document.delete_form.action = '/delete_email/' + $(e.relatedTarget).data('id');
  });

});
</script>
@endsection
