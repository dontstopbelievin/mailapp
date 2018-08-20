<nav class="nav-bar-dark navbar navbar-expand-lg navbar-light fixed-line-height" style="border-color:#0088cc; background:#0088cc;">
	<button class="navbar-toggler" type="button" data-toggle="collapse"
					data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
					aria-expanded="false" aria-label="Toggle navigation">
		<span class="navbar-toggler-icon"></span>
	</button>
	<!-- Brand -->
  <a href="/home" class="navbar-brand"><img src="/storage/images/logo.png" style="width:auto; height:25px;"></a>

  <!-- Links -->
	@guest

	@else
			<ul class="navbar-nav">
				<li class="nav-item">
		      <a class="nav-link {{Request::is('home') ? 'active' : ''}}" href="/home">Отправить сообщение</a>
		    </li>
		    <li class="nav-item">
		      <a class="nav-link {{Request::is('my_queue') ? 'active' : ''}}" href="/my_queue">Очередь сообщений</a>
		    </li>
				<li class="nav-item">
		      <a class="nav-link {{Request::is('failed_queue') ? 'active' : ''}}" href="/failed_queue">Ошибки отправления</a>
		    </li>
		    <li class="nav-item">
		      <a class="nav-link {{Request::is('my_postmans') ? 'active' : ''}}" href="my_postmans">Мои почты</a>
		    </li>
		  </ul>
			<ul class="navbar-nav ml-auto">
				<li class="nav-item dropdown">
						<a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
								{{ Auth::user()->name }} <span class="caret"></span>
						</a>
						<div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
								<a class="dropdown-item" href="{{ route('logout') }}"
									 onclick="event.preventDefault();
																 document.getElementById('logout-form').submit();">
										Выйти
								</a>
								<form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
										@csrf
								</form>
						</div>
				</li>
			</ul>
	@endguest
</nav>
