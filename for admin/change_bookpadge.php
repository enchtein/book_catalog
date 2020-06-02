<?php
session_start (); // служит для передачи данных валидации
include ('../include_all.php'); // подключение всех файлов

$id_book = $_GET['id_book']; // получаем ID книги через адрессную строку
$_SESSION['id_book'] = $_GET['id_book']; // получаем ID книги через адрессную строку
$myarr = array('*', 'books', 'id_book = '.$id_book);
$empl = new SQL();
$result=$empl->select($myarr); // в этом массиве должна быть вся информация о выбранной книге

#Здесь содержиться выборка по id_author и id_genre для конкретной книги
					// для авторов
$for_MY_authors = array('*', 'books_vs_author', 'id_book=' . $id_book);
$emplll = new SQL();
$author_MY_mass=$emplll->select($for_MY_authors); // в этом массиве должны быть все id_author для конкретной книги
foreach ($author_MY_mass as $key=>$value) {
	$value_from_author = array('author', 'author', 'id_author='.$value['id_author']); // выбрать ТОЛЬКО имена авторов
	$emplid_author = new SQL();
	$author_value=$emplid_author->select($value_from_author); // в этом массиве должны быть все авторы
	$total_authors[] = $author_value[0]['author'];
}
$comma_separated_authors = implode(",", $total_authors); // записываем всех авторов книги через запятую в СТРОКУ
					// для жанров
$for_MY_genres = array('*', 'books_vs_genre', 'id_book=' . $id_book);
$emplll_gen = new SQL();
$genre_MY_mass=$emplll_gen->select($for_MY_genres); // в этом массиве должны быть все id_gerne для конкретной книги
foreach ($genre_MY_mass as $key=>$value) {
	$value_from_genre = array('genre', 'genre', 'id_genre='.$value['id_genre']); // выбрать ТОЛЬКО названия жанров
	$emplid_genre = new SQL();
	$genre_value=$emplid_genre->select($value_from_genre); // в этом массиве должны быть все жанры
	$total_genres[] = $genre_value[0]['genre'];
}
$comma_separated_genres = implode(",", $total_genres); // записываем все жанры книги через запятую в СТРОКУ
?>
<!-- счетчик для покупки -->
<script>
	function plus() {
		var a = parseInt(document.getElementById('resultcost').value);
		var b = parseInt(document.getElementById('countbooks').value);

		if (isNaN(a)==true) a=0;
		if (isNaN(b)==true) b=0;

		var c = a * (b + 1);

		document.getElementById('result').innerHTML = c;
	}
	function minus() {
		var a = parseInt(document.getElementById('resultcost').value);
		var b = parseInt(document.getElementById('countbooks').value);

		if (isNaN(a)==true) a=0;
		if (isNaN(b)==true) b=0;

		var c = a * (b + 1);
		
			if (b==1) {
			var d = c-a;
			document.getElementById('result').innerHTML = d;
		
			} else {
			var d = c-a-a;
		document.getElementById('result').innerHTML = d;
			}
	}
</script>
<!-- /счетчик для покупки -->
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bootstrap сайт</title>
	<link rel="stylesheet" href="../css/main.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <link rel="stylesheet" href="../css/font-awesome.min.css">
</head>
<body>
	<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
	  <a class="navbar-brand" href="../index.php">B<i class="fa fa-circle"></i><i class="fa fa-circle"></i>KS</a> <!-- проверить удаленние сессионных сообщении -->
	  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
		<span class="navbar-toggler-icon"></span>
	  </button>
<form action="admin_index.php" method="post" id="for_form_top"><!-- ставим метод POST для передачи данных через адрессную строку -->
	  <div class="collapse navbar-collapse" id="navbarSupportedContent">
		<ul class="navbar-nav mr-auto">
			<li class="nav-item active">
			<a class="nav-link" href="admin_index.php">Вернуться на: Ну так-то да, ты АДМИН)</a> <!-- проверить удаленние сессионных сообщении -->
		  </li>
		</ul>
		<?php
		include ('admin_search_tab.php'); // подключение поиска
		?>
	  </div>
</form>
	</nav>
	<div class="container-fluid-my">
		<div id="headerwrap">
			<div class="row">
				<div class="col-sm-12">
					<h1>Change Book!</h1>
					<h2>Изменение книги!</h2>
				</div>
			</div>
		</div>
		<div class="col-sm-12 text-center">
			<div class="row ">
				<br><br>
				<div class="col-lg-4 ">
					<i class="fa fa-heart"></i>
					<h4>Дизайн</h4>
					<p>Lorem ipsum dolor sit amet, consectetur</p>
				</div>
				<div class="col-lg-4">
					<i class="fa fa-laptop"></i>
					<h4>Компьютеры</h4>
					<p>Lorem ipsum dolor sit amet, consectetur</p>
				</div>
				<div class="col-lg-4">
					<i class="fa fa-trophy"></i>
					<h4>Помощь</h4>
					<p>Lorem ipsum dolor sit amet, consectetur</p>
				</div>
			</div>
			<br><br>
		</div>
		<div id="new" class="row mx-auto">
			<div id="dg" class="col">
				<?php
					include ('admin_refain_tab.php'); // подключение файла для refain
							 ## ищем ID автора (для атрибута selected)
							foreach ($author_mass as $key=>$value) {
								$num = array_search($comma_separated_authors, $value);
								if ($num!=''){
									$num_id = $key;
									break;
								}
							}
							 ## ищем ID жанра (для атрибута selected)
							foreach ($genre_mass as $key=>$value) {
								$num = array_search($comma_separated_genres, $value);
								if ($num!=''){
									$num_id = $key;
									break;
								}
							}
				?>
			</div>
			<div class="col-10">
<form action="for_change_bookpadge.php" method="post" enctype="multipart/form-data"><!-- ставим метод POST для передачи данных -->
				<div id="dg" class="row mx-auto">
				<?php $_POST['id_book'] = $id_book; // присваиваем ID книги переменной $_POST для обработчика ?>
<input name="id_book" placeholder="" style="height: 30px; width: 50px"value="<?php echo $_POST['id_book']; ?>">ДАННОЕ ПОЛЕ НЕ ИЗМЕНЯТЬ</input><!-- name="id_book" -->
					<div class="col-sm-12 text-center">
						<div class="row">
							<div class="col-sm-4 text-center">
							</div>
							<div class="col-sm-8 text-left">
								<!--<h4>Название книги</h4>-->
								<input name="change_book_name" placeholder="Введите название книги" size="30" value="<?php echo $result[0]['book_name']; ?>"></input><!-- name="change_book_name" -->
<?php ## Обновление поля book_name
echo $_SESSION['msg_book_name']; // вывод сообщения
if (!isset($_POST['save_changes'])) {
	$_SESSION['old_book_name'] = $result[0]['book_name'];
	}
?>
							</div>
						</div>
                    </div>
                        <div class="col-4">
                            <div class="works-img">
								<img src="../<?php echo $result[0]['images']; ?>" alt="">
                                <input type="file" class="form-control" name="change_image" id="exampleFormControlInput1"> <!-- name="change_image" -->
                            </div>
                        </div>
						<div class="col-2 text-left">
							<div class="row">
	<!-- ДОБАВИЛ 11,02,2020 --><input name="on_screen_change_author" size="30" value="<?php echo $comma_separated_authors; ?>" disabled></input><!-- ПРОСТО ДЛЯ НАГЛЯДНОСТИ name="on_screen_change_author" -->
								<h5>Автор: </h5>&nbsp;
								<select name="change_author[]" multiple>
									<?php ## Делаем вывод выподающим списком
									foreach ($author_mass as $key=>$value) : 
										if ($key == $num_id) : ?>
										<option value="<?php echo $value['author']; ?>" selected><?php echo $value['author'] . "<br />"; ?></option>
										<?php else: ?>
										<option value="<?php echo $value['author']; ?>"><?php echo $value['author'] . "<br />"; ?></option>
										<?php
										endif;
									endforeach;
									?>
								</select><!-- name="change_author" -->
<?php 
## Обновление поля author
echo $_SESSION['msg_author']; // вывод сообщения
if (!isset($_POST['save_changes'])) {
	$_SESSION['old_author'] = $comma_separated_authors;
	}
?>
							</div>
							<div class="row">
	<!-- ДОБАВИЛ 11,02,2020 --><input name="on_screen_change_genre" size="30" value="<?php echo $comma_separated_genres; ?>" disabled></input><!-- ПРОСТО ДЛЯ НАГЛЯДНОСТИ name="on_screen_change_genre" -->
								<h5>Жанр: </h5>&nbsp;
								<select name="change_genre[]" multiple>
									<?php ## Делаем вывод выподающим списком
									foreach ($genre_mass as $key=>$value) : 
										if ($key == $num_id) : ?>
										<option value="<?php echo $value['genre']; ?>" selected><?php echo $value['genre'] . "<br />"; ?></option>
										<?php else: ?>
										<option value="<?php echo $value['genre']; ?>"><?php echo $value['genre'] . "<br />"; ?></option>
										<?php
										endif;
									endforeach;
									?>
								</select><!-- name="change_genre" -->
<?php ## Обновление поля genre
## сделать поиск жанра
echo $_SESSION['msg_genre']; // вывод сообщения
if (!isset($_POST['save_changes'])) {
	$_SESSION['old_genre'] = $comma_separated_genres;
	}
?>
							</div>
						</div>
                        <div class="col-6">
                            <textarea id="on_full_div" name="change_short_descr" placeholder="short_description"><?php echo $result[0]['short_descr']; ?></textarea><!-- name="change_short_descr" -->
<?php ## Обновление поля short_descr
echo $_SESSION['msg_short_descr']; // вывод сообщения
if (!isset($_POST['save_changes'])) {
	$_SESSION['old_short_descr'] = $result[0]['short_descr'];
	}
?>
                        </div>
						<div id="fulldescr" class="col-12 text-center border border-primary">
							<textarea id="on_full_div" name="change_full_descr" placeholder="full_description"><?php echo $result[0]['full_descr']; ?></textarea><!-- name="change_full_descr" -->
<?php ## Обновление поля full_descr
echo $_SESSION['msg_full_descr']; // вывод сообщения
if (!isset($_POST['save_changes'])) {
	$_SESSION['old_full_descr'] = $result[0]['full_descr'];
	}
?>
						</div>
                    <div id="buy" class="col-12"><!--Форма для покупки книги-->
                        <div class="row">
							<div id="forprice" class="col-4">
								&nbsp; <!--НЕВИДИМЫЙ СИМВОЛ-->
									<div id="centeredid" class="row">
									Цена&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Количество&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Стоимотсть</div>
									<div id="centered" class="row">		
								<input name="change_price" id="resultcost" type="number" min="0" max="1000" placeholder="Введите ЦЕНУ" size="12" width="30px" class="razprice" value="<?php echo $result[0]['price']; ?>"></input><!-- name="change_price" -->
<?php ## Обновление поля price
echo $_SESSION['msg_price']; // вывод сообщения
if (!isset($_POST['save_changes'])) {
	$_SESSION['old_price'] = $result[0]['price'];
	}
?>
								<button type="button" onclick="minus();this.nextElementSibling.stepDown()">-</button>
								<input name="quantity" id="countbooks" type="number" min="1" max="100" value="1" readonly class="raz">
								<button type="button" onclick="plus();this.previousElementSibling.stepUp()">+</button>
								&nbsp;&nbsp;&nbsp;&nbsp;<div class="resultprice" name="resultprice" id="result"></div>
									</div>
							</div>
                        </div>
                    </div>
					<button id="savechanges" type="submit" name="save_changes">Save Changes</button> <!-- name="save_changes" -->
				</div>
</form><!-- ставим метод POST для передачи данных -->
			</div>
		</div>
	</div>
	<div id="f">
		<a href="#"><i class="fa fa-twitter"></i></a>
		<a href="#"><i class="fa fa-facebook"></i></a>
		<a href="#"><i class="fa fa-vk"></i></a>
	</div>
	<script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
	<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
</body>
</html>