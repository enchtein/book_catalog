<?php
session_start (); // служит для передачи данных валидации
## должно быть в обработчике событий
//require_once "../include/classes/class.php"; // вызов подключения к классам
##NEW
/*
require_once "../include/classes/class/QueryBuilder.php"; // вызов подключения к классам
require_once "../include/classes/class/Validate.php"; // вызов подключения к классам
*/
require_once "../include/classes/class/all_classes.php"; // подключение файлов

function redirect ($url='add_bookpadge.php'){
	header("Location: $url");
	exit();
}

$data = new QueryBuilder;

$books = 'book'; // табл
$all_books = $data->select($books); // все книги
$genres = 'genre'; // табл
$all_genre = $data->select($genres); // все жанры
$authors = 'author'; // табл
$all_author = $data->select($authors); // все авторы

/*
1) проверить поля на пустоту
2) проверить наличие книги с таким названием (если есть - минус)
3) поверить наличие автора/жанра (если автора нет - добавить, если есть взять его ИД)
4) проверка картинки
5) если все норм - апдейт
*/

if (isset($_POST['add_book'])) {
	
	// Данные нужны для сохранения в случае заполнения не всех полей
	$_SESSION['data_add_book_name'] = $_POST['add_book_name'];
	$_SESSION['data_add_author'] = $_POST['add_author'];
	$_SESSION['data_add_genre'] = $_POST['add_genre'];
	$_SESSION['data_add_short_descr'] = $_POST['add_short_descr'];
	$_SESSION['data_add_full_descr'] = $_POST['add_full_descr'];
	$_SESSION['data_add_price'] = $_POST['add_price'];
	
	$_SESSION['good_msg'] = '';
	// --------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
	## 1) проверить поля на пустоту
	
	$for_validate_book_name = new Validate($_POST['add_book_name'], ''); // проверка book_name на заполненность
    $_SESSION['msg_add_book_name'] = $for_validate_book_name->myEmpty();
	
	$for_validate_author = new Validate($_POST['add_author'], ''); // проверка author на заполненность
	$_SESSION['msg_add_author'] = $for_validate_author->myEmpty();
	
	$for_validate_genre = new Validate($_POST['add_genre'], ''); // проверка genre на заполненность
	$_SESSION['msg_add_genre'] = $for_validate_genre->myEmpty();
	
	$for_validate_short_descr = new Validate($_POST['add_short_descr'], ''); // проверка short_descr на заполненность
	$_SESSION['msg_add_short_descr'] = $for_validate_short_descr->myEmpty();
	
	$for_validate_full_descr = new Validate($_POST['add_full_descr'], ''); // проверка full_descr на заполненность
	$_SESSION['msg_add_full_descr'] = $for_validate_full_descr->myEmpty();
	
	$for_validate_price = new Validate($_POST['add_price'], ''); // проверка price на заполненность
	$_SESSION['msg_add_price'] = $for_validate_price->myEmpty();

	if (empty($_SESSION['msg_add_book_name']) && empty($_SESSION['msg_add_author']) && empty($_SESSION['msg_add_genre']) && empty($_SESSION['msg_add_short_descr']) && empty($_SESSION['msg_add_full_descr']) && empty($_SESSION['msg_add_price'])) {
	// --------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
	##2) проверить наличие книги с таким названием (если есть - минус)
		foreach ($all_books['data'] as $key=>$value) {
			$only_book_name[$key] = $value['book_name']; // записываем все названия книг из БД в отдельных массив
		}
		$search_book = array_search($_POST['add_book_name'], $only_book_name);
	// если такой книги раньше не было - можно добавлять
	// здесь должна быть проверка на пустоту и 0
		if (empty($search_book) && $search_book=='') {
	// --------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
	## 3) поверить наличие автора/жанра (если автора нет - добавить, если есть взять его ИД)
		## проверка жанра и отбор нужных id_genre
			foreach ($all_genre['data'] as $key=>$value) {
				$only_genre[$value['id_genre']] = $value['genre']; // записываем все названия книг из БД в отдельных массив
			}
			$pieces_genre = explode(", ", $_POST['add_genre']);
			foreach ($pieces_genre as $value) { // поле $_POST['add_genre'] - массив, нудно проверить каждое значение
				$search_genre = array_search($value, $only_genre);
				if (!empty($search_genre) || $search_genre===0) {
/*УЖЕ БЫЛИ*/		$result_s_genre[$search_genre] = $only_genre[$search_genre]; // результатом будет пара ключ=>значение массива $all_genre (МАССИВ С ИД ЖАНР => ЖАНР) для добавления
				} else {
					$need_to_add_genre[] = $value; // такого жанра нет в БД, его нужно добавить перед апдейтом! (МАССИВ С [] => ЖАНР, которого не было в БД)
				}
			}
			if (!empty($need_to_add_genre)) {
				foreach ($need_to_add_genre as $value) {
					//сделать апдейт табл жанров и получить на выходе МАССИВ С ИД ЖАНР => ЖАНР, затем объеденить его с $result_s_genre
					$name_table_for_update = "`genre`";
					$param_col = '(`id_genre`, `genre`, `status`)';
					$param_val = "(NULL, '" . $value . "', 0)";
					$mass_for_add = array ($name_table_for_update, $param_col, $param_val);
					$lastId = $data->insert($mass_for_add);
/*ДОБАВИЛИСЬ*/		$add_genres[$lastId] = $value; // // результатом будет пара ключ=>значение массива $need_to_add_genre (МАССИВ С ИД ЖАНР => ЖАНР) для добавления
				}
			}
			/* массив жанров для добавления книги */
			if (empty($result_s_genre) && !empty($add_genres)) {
				$result_genre = $add_genres; // массив для добавления книги (МАССИВ С ИД ЖАНР => ЖАНР) - именно для ЭТОЙ книги
			} elseif (empty($add_genres) && !empty($result_s_genre)) {
				$result_genre = $result_s_genre; // массив для добавления книги (МАССИВ С ИД ЖАНР => ЖАНР) - именно для ЭТОЙ книги
			} elseif (!empty($result_s_genre) && !empty($add_genres)) {
				$result_genre = $result_s_genre + $add_genres; // массив для добавления книги (МАССИВ С ИД ЖАНР => ЖАНР) - именно для ЭТОЙ книги
			}
		## проверка автора и отбор нужных id_author
			foreach ($all_author['data'] as $key=>$value) {
				$only_author[$value['id_author']] = $value['author']; // записываем все названия книг из БД в отдельных массив
			}
			$pieces_author = explode(", ", $_POST['add_author']);
			foreach ($pieces_author as $value) { // поле $_POST['add_author'] - массив, нудно проверить каждое значение
				$search_author = array_search($value, $only_author);
				if (!empty($search_author) || $search_author===0) {
	/*УЖЕ БЫЛИ*/		$result_s_author[$search_author] = $only_author[$search_author]; // результатом будет пара ключ=>значение массива $all_author (МАССИВ С ИД ЖАНР => ЖАНР) для добавления
				} else {
					$need_to_add_author[] = $value; // такого жанра нет в БД, его нужно добавить перед апдейтом! (МАССИВ С [] => ЖАНР, которого не было в БД)
				}
			}
			if (!empty($need_to_add_author)) {
				foreach ($need_to_add_author as $value) {
					//сделать апдейт табл жанров и получить на выходе МАССИВ С ИД ЖАНР => ЖАНР, затем объеденить его с $result_s_author
					$name_table_for_update = "`author`";
					$param_col = '(`id_author`, `author`, `status`)';
					$param_val = "(NULL, '" . $value . "', 0)";
					$mass_for_add = array ($name_table_for_update, $param_col, $param_val);
					$lastId = $data->insert($mass_for_add);
	/*ДОБАВИЛИСЬ*/		$add_authors[$lastId] = $value; // // результатом будет пара ключ=>значение массива $need_to_add_author (МАССИВ С ИД ЖАНР => ЖАНР) для добавления
				}
			}
			/* массив жанров для добавления книги */
			if (empty($result_s_author) && !empty($add_authors)) {
				$result_author = $add_authors; // массив для добавления книги (МАССИВ С ИД ЖАНР => ЖАНР) - именно для ЭТОЙ книги
			} elseif (empty($add_authors) && !empty($result_s_author)) {
				$result_author = $result_s_author; // массив для добавления книги (МАССИВ С ИД ЖАНР => ЖАНР) - именно для ЭТОЙ книги
			} elseif (!empty($result_s_author) && !empty($add_authors)) {
				$result_author = $result_s_author + $add_authors; // массив для добавления книги (МАССИВ С ИД ЖАНР => ЖАНР) - именно для ЭТОЙ книги
			}
			
		
	// --------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
	## 4 - проверка картинки
			if ($_FILES['add_image']['type']!='') {
				$img_data = str_replace('/', '.', $_FILES['add_image']['type']);
				$row = stristr($img_data, ".");
				$new_url_image = "img/uploads/".uniqid().$row; //путь картинки
				// поставить картинки (перенести на FTP и добавить путь в БД)
				move_uploaded_file ($_FILES['add_image']['tmp_name'], "../".$new_url_image); // загрузка файла *в папку: img/uploads*
			} else {
				// если картинка не указанна поставить заглушку no-image
				$new_url_image = "img/phone_no image.png"; //путь картинки no-image
			}
	// --------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
	## 5) если все норм - апдейт
	// собрать массив данных и сделать его добавление в табл. book
			$book_table = "`book`";
			$param_table = '(`id_book`, `book_name`, `short_descr`, `full_descr`, `image`, `price`)';
			$param_value = "(NULL, '" . $_POST['add_book_name'] . "', '" . $_POST['add_short_descr'] . "', '" . $_POST['add_full_descr'] . "', '" . $new_url_image . "', '" . $_POST['add_price'] . "')";
			$mass_for_add_book = array ($book_table, $param_table, $param_value);
			$add_book = $data->insert($mass_for_add_book); // в $add_book - содержится lastID book

	// затем используя id_book которую только что добавили - сделать добавление связей в табл. book_vs_genre / book_vs_author
			## ДЛЯ book_vs_genre
			foreach ($result_genre as $key=>$one_genre) {
				$book_table = "`books_vs_genre`";
				$param_table = '(`id`, `id_book`, `id_genre`)';
				$param_value = "(NULL, '" . $add_book . "', '" . $key . "')";
				$mass_for_add_book = array ($book_table, $param_table, $param_value);
				$add_relations = $data->insert($mass_for_add_book); // в $add_book - содержится lastID book
			}
			## ДЛЯ book_vs_author
			foreach ($result_author as $key=>$one_author) {
				$book_table = "`books_vs_author`";
				$param_table = '(`id`, `id_book`, `id_author`)';
				$param_value = "(NULL, '" . $add_book . "', '" . $key . "')";
				$mass_for_add_book = array ($book_table, $param_table, $param_value);
				$add_relations = $data->insert($mass_for_add_book); // в $add_book - содержится lastID book
			}
	
			$_SESSION['good_msg'] = "Книга добавленна";
		} else {
			$_SESSION['msg_add_book_name'] = "<h3 style='font-size: 15px;'>Книга с таким названием уже есть в БД!</h3>";
		}
	}
}
redirect(); //Перенаправление на старницу add_bookpadge.php
?>