<?php
require_once "../include/classes/class/all_classes.php"; // подключение файлов
session_start();
$_SESSION = []; // на этой странице очистить массив сессии

$data = new QueryBuilder;
$books = 'book'; // данные для выборки
$on_screen = $data->select($books);

if(isset($_GET['genre']) || isset($_GET['author'])) {

	$pre_on_screen = new PublishRefain($on_screen, $_GET);
	$genre_mass = $pre_on_screen->view(); // вывод инфы на экран
	$on_screen = $genre_mass;
}
// Сделать поиск с выводом на экран (search_tab.php)
$title = "Количество книг для " . $on_screen['from_where'] . ": " . count($on_screen['data']); // здесь title
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
	include ('header.php'); // подключение шапки и поиска
?>
<form action="" method="get"><!-- ставим метод GET для передачи данных через адрессную строку -->
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
				<div id="dg" class="row mx-auto">
					<div class="col-sm-12 text-center">
						<h4><?php echo $title; ?></h4>
					</div>
<?php if (!empty($on_screen) && $on_screen['data']!=''): 
		foreach ($on_screen['data'] as $key=>$value) : ?> <!-- вывод книг -->
						<div class="col-sm-3">
							<div class="works-img tilt">
                                <a href="change_bookpadge.php?id_book=<?php echo $value['id_book'];?>"><img src="../<?php echo $value['image'];?>" alt=""></a><!--переход на страницу с книгой (адрессная строка)-->
                                <p><?php echo $value['book_name']; ?></p>
							</div>
                        </div>
<?php	endforeach;
	  endif; ?>
				</div>
			</div>
		</div>
    </div>
</form>
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