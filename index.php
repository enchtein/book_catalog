<?php
require_once "../GeekForLess/index_all_classes.php"; // подключение файлов

$data = new QueryBuilder;

$books = 'book'; // данные для выборки
$on_screen = $data->select($books);

if(isset($_GET['genre']) || isset($_GET['author'])) {

	$pre_on_screen = new PublishRefain($on_screen, $_GET);
	$genre_mass = $pre_on_screen->view(); // вывод инфы на экран
	$on_screen = $genre_mass;
}
$title = "Количество книг для " . $on_screen['from_where'] . ": " . count($on_screen['data']); // здесь title
?>
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
<form action="" method="post" id="for_form_top"><!-- ставим метод POST для передачи данных через адрессную строку -->
	<div class="collapse navbar-collapse" id="navbarSupportedContent">
		<ul class="navbar-nav mr-auto">
			<li class="nav-item active">
				<a class="nav-link" href="for_admin/admin_index.php">А ты точно админ?</a>
			</li>
		</ul>
		<?php
			include ('include/search_tab.php'); // подключение поиска
		?>
	</div>
</form><!-- ставим метод POST для передачи данных через адрессную строку -->
	</nav>
<form action="" method="get"><!-- ставим метод GET для передачи данных через адрессную строку -->
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
						<h4><?php echo $title; ?></h4>
					</div>
<?php if (!empty($on_screen) && $on_screen['data']!=''): 
		foreach ($on_screen['data'] as $key=>$value) : ?> <!-- вывод книг -->
					<div class="col-sm-3">
						<div class="works-img tilt">
							<a href="bookpadge.php?id_book=<?php echo $value['id_book'];?>"><img src="<?php echo $value['image'];?>" alt=""></a><!--переход на страницу с книгой (адрессная строка)-->
							<p><?php echo $value['book_name']; ?></p>
						</div>
					</div>
<?php 	endforeach;
	  endif; ?>
				</div>
			</div>
		</div>
	</div>
</form><!-- ставим метод GET для передачи данных через адрессную строку -->
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