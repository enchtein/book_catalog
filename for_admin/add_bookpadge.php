<?php
session_start();
//include ('../include_all.php'); // подключение всех файлов
//require_once "../include/classes/class.php"; // вызов подключения к классам

require_once "../include/classes/class/all_classes.php"; // подключение файлов
include ('buy_counter.php'); // счетчик для покупки (JS)
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
	<div class="container-fluid-my">
		<?php
			include ('second_header.php'); // подключение шапки 2
		?>
<form action="for_add_bookpadge.php" method="post" enctype="multipart/form-data"><!-- ставим метод POST для передачи данных -->
		<div id="new" class="row mx-auto">
			<div id="dg" class="col">
				<?php
					include ('admin_refain_tab.php'); // подключение файла для refain
				?>
			</div>
			<div class="col-10">
				<div id="dg" class="row mx-auto">
					<div class="col-sm-12 text-center">
						<div class="row">
							<div class="col-sm-4 text-center">
							</div>
							<div class="col-sm-8 text-left">
								<h4 style="color: green;"><?php echo $_SESSION['good_msg']; ?></h4>
								<input name="add_book_name" placeholder="Введите название книги" size="30" value="<?php if($_SESSION['good_msg']==''){ echo $_SESSION['data_add_book_name']; } ?>"></input><!-- name="add_book_name" -->
<?php echo $_SESSION['msg_add_book_name']; ?>
							</div>
						</div>
                    </div>
                        <div class="col-4">
                            <div class="works-img">
								<img src="../img/phone_no image.png" alt="">
                                <input type="file" class="form-control" name="add_image" id="exampleFormControlInput1" value=""> <!-- name="add_image" -->					
                            </div>
                        </div>
						<div class="col-2 text-left">
							<div class="row">
								<h5>Автор: </h5>&nbsp;<input name="add_author" placeholder="Введите автора" size="25" value="<?php if($_SESSION['good_msg']==''){ echo $_SESSION['data_add_author']; } ?>"></input><!-- name="add_author" -->
<?php echo $_SESSION['msg_add_author']; ?>
							</div>
							<div class="row">
								<h5>Жанр: </h5>&nbsp;<input name="add_genre" placeholder="Введите жанр" size="25" value="<?php if($_SESSION['good_msg']==''){ echo $_SESSION['data_add_genre']; } ?>"></input><!-- name="add_gerne" -->
<?php echo $_SESSION['msg_add_genre']; ?>
							</div>
						</div>
                        <div class="col-6">
                            <textarea id="on_full_div" name="add_short_descr" placeholder="short_description" ><?php if($_SESSION['good_msg']==''){ echo $_SESSION['data_add_short_descr']; } ?></textarea><!-- name="add_short_descr" -->
<?php echo $_SESSION['msg_add_short_descr']; ?>
                        </div>
						<div id="fulldescr" class="col-12 text-center border border-primary">
							<textarea id="on_full_div" name="add_full_descr" placeholder="full_description" ><?php if($_SESSION['good_msg']==''){ echo $_SESSION['data_add_full_descr']; } ?></textarea><!-- name="add_full_descr" -->
<?php echo $_SESSION['msg_add_full_descr']; ?>
						</div>
						<div id="buy" class="col-12"><!--Форма для покупки книги-->
							<div class="row">
								<div id="forprice" class="col-4">
									&nbsp; <!--НЕВИДИМЫЙ СИМВОЛ-->
									<div id="centeredid" class="row">
									Цена&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Количество&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Стоимотсть</div>
									<div id="centered" class="row">		
									<input name="add_price" id="resultcost" type="number" min="0" max="1000" placeholder="Введите ЦЕНУ" size="12" width="30px" class="razprice" value="<?php if($_SESSION['good_msg']==''){ echo $_SESSION['data_add_price']; } ?>"></input><!-- name="add_price" -->
<?php echo $_SESSION['msg_add_price']; ?>
									<button type="button" onclick="minus();this.nextElementSibling.stepDown()">-</button>
									<input id="countbooks" type="number" min="1" max="100" value="1" readonly class="raz">
									<button type="button" onclick="plus();this.previousElementSibling.stepUp()">+</button>
									&nbsp;&nbsp;&nbsp;&nbsp;<div class="resultprice" id="result"></div>
									</div>
								</div>
							</div>
						</div>
					<button id="savechanges" type="submit" name="add_book">Add Book</button> <!-- name="add_book" -->
				</div>
			</div>
		</div>
</form>
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