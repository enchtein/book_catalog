<?php
require_once "../GeekForLess/index_all_classes.php"; // подключение файлов
$data = new QueryBuilder;

$books = 'book'; // данные для выборки
$all_books = $data->select($books);

if (isset($_GET['id_book'])) {
	$pre_on_screen = new BookInfo($all_books, $_GET);
	$book_mass = $pre_on_screen->view(); // вывод инфы на экран
	$on_screen = $book_mass;
}

if (isset($_POST['buy'])) {
	$check = new Validate($_POST['adress'], ''); // проверка image на заполненность
	$check_adress = $check->myEmpty($_POST['adress']);
	
	$check = new Validate($_POST['user_name'], ''); // проверка image на заполненность
	$check_user_name = $check->myEmpty($_POST['user_name']);

	if ($check_adress=='' && $check_user_name=='') {
		// массив данных для отправки админу
		$mass_for_buy = array ("название книги" => "название книги: " . $on_screen['data'][0]['book_name'], 
						   "автор" => "автор: " . $on_screen['data'][0]['author'], 
						   "жанр" => "жанр: " . $on_screen['data'][0]['genre'], 
						   "цена" => "цена: " . $on_screen['data'][0]['price'], 
						   "кол-во экземпляров" => "кол-во экземпляров: " . $_POST['quantity'], 
						   "конечная стоимость" => "конечная стоимость: " . $_POST['quantity'] * $on_screen['data'][0]['price'], 
						   "Адресс" => "Адресс: " . $_POST['adress'], 
						   "Ф.И.О." => "Ф.И.О.: " . $_POST['user_name']);
		$order = implode("<br />", $mass_for_buy); // формирование строки из массива
		$sending = new Email(); // отправка письма
		$answer=$sending->sent($order); // результаттом должно быть сообщение "Email was sent!"
	}
}
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
	<link rel="stylesheet" href="css/main.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <link rel="stylesheet" href="css/font-awesome.min.css">
</head>
<body>
	<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
	<a class="navbar-brand" href="index.php">B<i class="fa fa-circle"></i><i class="fa fa-circle"></i>KS</a>
	<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
		<span class="navbar-toggler-icon"></span>
	</button>
<form action="index.php" method="post" id="for_form_top"><!-- ставим метод POST для передачи данных через адрессную строку -->
	<div class="collapse navbar-collapse" id="navbarSupportedContent">
		<ul class="navbar-nav mr-auto">
			<li class="nav-item active">
				<a class="nav-link" href="#">Домой</a>
			</li>
			<li class="nav-item">
				<a class="nav-link" href="#">Про нас</a>
			</li>
			<li class="nav-item">
				<a class="nav-link" href="#">Сервисы</a>
			</li>
			<li class="nav-item">
				<a class="nav-link" href="#">Работы</a>
			</li>
			<li>
				<a href="#">
					<i class="fa fa-envelope-o" aria-hidden="true"></i>
				</a>
			</li>
		</ul>
		<?php
			include ('include/search_tab.php'); // подключение поиска
		?>
	</div>
</form><!-- ставим метод POST для передачи данных через адрессную строку -->
	</nav>
	<div class="container-fluid-my">
		<div id="headerwrap">
				<div class="row">
					<div class="col-sm-12">
					<h1>Books Catalog!</h1>
					<h2>Книжный каталог!</h2>
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
				include ('include/refain_tab.php'); // подключение файла для refain
				?>
			</div>
			<div class="col-10">
				<div id="dg" class="row mx-auto">
					<div class="col-sm-12 text-center">
						<div class="row">
							<div class="col-sm-4 text-center">
							</div>
							<div class="col-sm-8 text-left">
								<h4><?php echo $on_screen['data'][0]['book_name']; ?></h4>
							</div>
						</div>
                    </div>
					<div class="col-4">
						<div class="works-img">
							<img src="<?php echo $on_screen['data'][0]['image']; ?>" alt="">
						</div>
					</div>
					<div class="col-2 text-left">
						<h5>Автор: <?php echo $on_screen['data'][0]['author']; ?></h5>
						<h5>Жанр: <?php echo $on_screen['data'][0]['genre']; ?></h5>
					</div>
					<div class="col-6">
						<p>Описание книги
						<br>
							<?php echo $on_screen['data'][0]['short_descr']; ?>
						</p>
					</div>
					<div id="fulldescr" class="col-12 text-center border border-primary">
						<?php echo $on_screen['data'][0]['full_descr']; ?>
					</div>
<form action="" method="post"> <!-- для оформления заказа -->
                    <div id="buy" class="col-12"><!--Форма для покупки книги-->
                        <div class="row">
							<div id="forprice" class="col-4">
								&nbsp; <!--НЕВИДИМЫЙ СИМВОЛ-->
									<div id="centeredid" class="row">
									Цена&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Количество&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Стоимотсть</div>
									<div id="centered" class="row">
								<input id="resultcost" type="number" min="0" max="1000" value="<?php echo $on_screen['data'][0]['price']; ?>" width="30px" readonly class="razprice"> <!-- ДЛЯ ЦЕНЫ ЧИСТО -->
								<button type="button" onclick="minus();this.nextElementSibling.stepDown()">-</button>
								<input id="countbooks" name="quantity" type="number" min="1" max="100" value="1" readonly class="raz">
								<button type="button" onclick="plus();this.previousElementSibling.stepUp()">+</button>
								&nbsp;&nbsp;&nbsp;&nbsp;<div class="resultprice" name="resultprice" id="result"></div>
									</div>
							</div>
							<div class="col-8 text-center">
									Форма для покупки книги
								<div class="row justify-content-center">
									<div class="row">
										<textarea rows="1" cols="45" name="adress" type="text" placeholder="Введите адресс" class="dline"></textarea><!--ПОЛЕ заказа АДРЕСС-->
<?php
if (isset($_POST['buy'])) {
	echo "<br />" . $check_adress; // выдаст предупреждение если поле не заполненно
}
?>
									</div>
									<div class="row">
										<textarea rows="1" cols="45" name="user_name" type="text" placeholder="Введите Ф.И.О." class="dline"></textarea><!--ПОЛЕ заказа Ф.И.О.-->
<?php
if (isset($_POST['buy'])) {
	echo "<br />" . $check_user_name; // выдаст предупреждение если поле не заполненно
}
?>
									</div>
								</div>
								<div class="row justify-content-center">
									<button type="submit" name="buy">Купить</button>
								</div>
<?php echo "<br />" . $answer; ?> <!-- Результат отправки письма -->
							</div>
                        </div>
                    </div>
</form>
				</div>
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