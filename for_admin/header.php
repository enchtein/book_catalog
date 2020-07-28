<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
		<a class="navbar-brand" href="../index.php">B<i class="fa fa-circle"></i><i class="fa fa-circle"></i>KS</a>
		<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
			<span class="navbar-toggler-icon"></span>
		</button>
<form action="admin_index.php" method="post" id="for_form_top"><!-- ставим метод POST для передачи данных через адрессную строку -->
	<div class="collapse navbar-collapse" id="navbarSupportedContent">
		<ul class="navbar-nav mr-auto">
			<li class="nav-item active">
				<a class="nav-link" href="admin_index.php">Ну так-то да, ты АДМИН)</a>
			</li>
			<li class="nav-item active">
				<a class="nav-link" href="add_bookpadge.php">Добавить книгу</a>
			</li>
		</ul>
		<?php
			include ('admin_search_tab.php'); // подключение поиска
		?>
	</div>
</form>
</nav>