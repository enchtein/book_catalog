<?php
session_start (); // служит для передачи данных валидации
//require_once "../include/classes/class.php"; // вызов подключения к классам
##NEW
require_once "../include/classes/class/all_classes.php"; // подключение файлов

include ('buy_counter.php'); // счетчик для покупки (JS)

$id_book = $_GET['id_book']; // получаем ID книги через адрессную строку
$_SESSION['id_book'] = $_GET['id_book']; // получаем ID книги через адрессную строку

$data = new QueryBuilder;
$books = 'book'; // данные для выборки
$all_books = $data->select($books);

$pre_on_screen = new BookInfo($all_books, $_GET);
$book_mass = $pre_on_screen->view(); // вывод инфы на экран
$on_screen = $book_mass;
?>

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
<?php
	include ('header.php'); // подключение поиска
?>
	<div class="container-fluid-my">
		<?php
			include ('second_header.php'); // подключение шапки 2
		?>
		<div id="new" class="row mx-auto">
			<div id="dg" class="col">
				<?php
					include ('admin_refain_tab.php'); // подключение файла для refain
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
								<input name="change_book_name" placeholder="Введите название книги" size="30" value="<?php echo $on_screen['data'][0]['book_name']; ?>"></input><!-- name="change_book_name" -->
<?php ## Обновление поля book_name
echo $_SESSION['msg_book_name']; // вывод сообщения
?>
							</div>
						</div>
                    </div>
                        <div class="col-4">
                            <div class="works-img">
								<img src="../<?php echo $on_screen['data'][0]['image']; ?>" alt="">
                                <input type="file" class="form-control" name="change_image" id="exampleFormControlInput1"> <!-- name="change_image" -->
                            </div>
                        </div>
						<div class="col-2 text-left">
							<div class="row">
	<!-- ДОБАВИЛ 11,02,2020 --><input name="on_screen_change_author" size="30" value="<?php echo $on_screen['data'][0]['author']; ?>" disabled></input><!-- ПРОСТО ДЛЯ НАГЛЯДНОСТИ name="on_screen_change_author" -->
								<h5>Автор: </h5>&nbsp;
								<select name="change_author[]" multiple>
									<?php ## Делаем вывод выподающим списком
									foreach ($author_mass['data'] as $key=>$value) : 
										if ($key == $num_id['author']) : ?>
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
?>
							</div>
							<div class="row">
	<!-- ДОБАВИЛ 11,02,2020 --><input name="on_screen_change_genre" size="30" value="<?php echo $on_screen['data'][0]['genre']; ?>" disabled></input><!-- ПРОСТО ДЛЯ НАГЛЯДНОСТИ name="on_screen_change_genre" -->
								<h5>Жанр: </h5>&nbsp;
								<select name="change_genre[]" multiple>
									<?php ## Делаем вывод выподающим списком
									foreach ($genre_mass['data'] as $key=>$value) : 
										if ($key == $num_id['genre']) : ?>
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
?>
							</div>
						</div>
                        <div class="col-6">
                            <textarea id="on_full_div" name="change_short_descr" placeholder="short_description"><?php echo $on_screen['data'][0]['short_descr']; ?></textarea><!-- name="change_short_descr" -->
<?php ## Обновление поля short_descr
echo $_SESSION['msg_short_descr']; // вывод сообщения
?>
                        </div>
						<div id="fulldescr" class="col-12 text-center border border-primary">
							<textarea id="on_full_div" name="change_full_descr" placeholder="full_description"><?php echo $on_screen['data'][0]['full_descr']; ?></textarea><!-- name="change_full_descr" -->
<?php ## Обновление поля full_descr
echo $_SESSION['msg_full_descr']; // вывод сообщения
?>
						</div>
                    <div id="buy" class="col-12"><!--Форма для покупки книги-->
                        <div class="row">
							<div id="forprice" class="col-4">
								&nbsp; <!--НЕВИДИМЫЙ СИМВОЛ-->
									<div id="centeredid" class="row">
									Цена&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Количество&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Стоимотсть</div>
									<div id="centered" class="row">		
								<input name="change_price" id="resultcost" type="number" min="0" max="1000" placeholder="Введите ЦЕНУ" size="12" width="30px" class="razprice" value="<?php echo $on_screen['data'][0]['price']; ?>"></input><!-- name="change_price" -->
<?php ## Обновление поля price
echo $_SESSION['msg_price']; // вывод сообщения
?>
								<button type="button" onclick="minus();this.nextElementSibling.stepDown()">-</button>
								<input name="quantity" id="countbooks" type="number" min="1" max="100" value="1" readonly class="raz">
								<button type="button" onclick="plus();this.previousElementSibling.stepUp()">+</button>
								&nbsp;&nbsp;&nbsp;&nbsp;<div class="resultprice" name="resultprice" id="result"></div>
									</div>
							</div>
                        </div>
                    </div>
<?php ## запись старых данных для сравнения в обработчике событий
if (!isset($_POST['save_changes'])) {
	$_SESSION['old_book_name'] = $on_screen['data'][0]['book_name']; // записываем старые данные
	$_SESSION['old_image'] = $on_screen['data'][0]['image']; // записываем старые данные
	$_SESSION['old_author'] = $on_screen['data'][0]['author']; // записываем старые данные
	$_SESSION['old_genre'] = $on_screen['data'][0]['genre']; // записываем старые данные
	$_SESSION['old_short_descr'] = $on_screen['data'][0]['short_descr']; // записываем старые данные
	$_SESSION['old_full_descr'] = $on_screen['data'][0]['full_descr']; // записываем старые данные
	$_SESSION['old_price'] = $on_screen['data'][0]['price']; // записываем старые данные
}
?>
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