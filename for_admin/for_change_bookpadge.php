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

$url="change_bookpadge.php?id_book=" . $_SESSION['id_book'];
function redirect ($url){
	header("Location: " . $url);
	exit();
}


if (isset($_POST['save_changes'])) { ## проверка наполненности поля
	$data = new QueryBuilder; // создание объекта для апдейта БД

	## change_book_name
	$for_book_name_validate = new Validate($_POST['change_book_name'], $_SESSION['old_book_name']); // создание объекта для проверки на заполненность
	$_SESSION['msg_book_name'] = $for_book_name_validate->myEmpty(); ## сессионные сообщения // если не ввел название книги выдаст: Вы не ввели обязательный параметр
	if (empty($_SESSION['msg_book_name'])) {
		$_SESSION['msg_book_name'] = $for_book_name_validate->myCompare(); ## сессионные сообщения // если $_SESSION['msg_book_name'] - пустой, то сравнит, иначе - должно остаться сообщение: Вы не ввели обязательный параметр
	}
	if ($_SESSION['msg_book_name'] == "<h3 style='font-size: 15px; color: #009105;'>Данные обновлены</h3>") {
		$name_col_for_update = "`book`";
		$param = "`book_name`= '". $_POST['change_book_name'] . "'";
		$for_where = "`book`.`id_book` = ".$_SESSION['id_book'];
		$mass_for_update = array ($name_col_for_update, $param, $for_where);
		$u_book_name = $data->update($mass_for_update);
	}
		
	## change_short_descr
	$for_short_descr_validate = new Validate($_POST['change_short_descr'], $_SESSION['old_short_descr']); // создание объекта для проверки на заполненность
	$_SESSION['msg_short_descr'] = $for_short_descr_validate->myEmpty(); ## сессионные сообщения // если не ввел название книги выдаст: Вы не ввели обязательный параметр
	if (empty($_SESSION['msg_short_descr'])) {
		$_SESSION['msg_short_descr'] = $for_short_descr_validate->myCompare(); ## сессионные сообщения // если $_SESSION['msg_short_descr'] - пустой, то сравнит, иначе - должно остаться сообщение: Вы не ввели обязательный параметр
	}
	if ($_SESSION['msg_short_descr'] == "<h3 style='font-size: 15px; color: #009105;'>Данные обновлены</h3>") {
		$name_col_for_update = "`book`";
		$param = "`short_descr`= '". $_POST['change_short_descr'] . "'";
		$for_where = "`book`.`id_book` = ".$_SESSION['id_book'];
		$mass_for_update = array ($name_col_for_update, $param, $for_where);
		$u_book_name = $data->update($mass_for_update);
	}
	
	## change_full_descr
	$for_full_descr_validate = new Validate($_POST['change_full_descr'], $_SESSION['old_full_descr']); // создание объекта для проверки на заполненность
	$_SESSION['msg_full_descr'] = $for_full_descr_validate->myEmpty(); ## сессионные сообщения // если не ввел название книги выдаст: Вы не ввели обязательный параметр
	if (empty($_SESSION['msg_full_descr'])) {
		$_SESSION['msg_full_descr'] = $for_full_descr_validate->myCompare(); ## сессионные сообщения // если $_SESSION['msg_full_descr'] - пустой, то сравнит, иначе - должно остаться сообщение: Вы не ввели обязательный параметр
	}
	if ($_SESSION['msg_full_descr'] == "<h3 style='font-size: 15px; color: #009105;'>Данные обновлены</h3>") {
		$name_col_for_update = "`book`";
		$param = "`full_descr`= '". $_POST['change_full_descr'] . "'";
		$for_where = "`book`.`id_book` = ".$_SESSION['id_book'];
		$mass_for_update = array ($name_col_for_update, $param, $for_where);
		$u_book_name = $data->update($mass_for_update);
	}
	
	## change_price
	$for_orice_validate = new Validate($_POST['change_price'], $_SESSION['old_price']); // создание объекта для проверки на заполненность
	$_SESSION['msg_price'] = $for_orice_validate->myEmpty(); ## сессионные сообщения // если не ввел название книги выдаст: Вы не ввели обязательный параметр
	if (empty($_SESSION['msg_price'])) {
		$_SESSION['msg_price'] = $for_orice_validate->myCompare(); ## сессионные сообщения // если $_SESSION['msg_price'] - пустой, то сравнит, иначе - должно остаться сообщение: Вы не ввели обязательный параметр
	}
	if ($_SESSION['msg_price'] == "<h3 style='font-size: 15px; color: #009105;'>Данные обновлены</h3>") {
		$name_col_for_update = "`book`";
		$param = "`price`= '". $_POST['change_price'] . "'";
		$for_where = "`book`.`id_book` = ".$_SESSION['id_book'];
		$mass_for_update = array ($name_col_for_update, $param, $for_where);
		$u_book_name = $data->update($mass_for_update);
	}
	
	## change_image
	if ($_FILES['change_image']['type']!='') {
		$data = str_replace('/', '.', $_FILES['change_image']['type']);
		$row = stristr($data, ".");
		$new_url_image = "img/uploads/".uniqid().$row; //путь картинки

		$for_image_validate = new Validate($new_url_image, $_SESSION['old_image']); // создание объекта для проверки на заполненность
		$_SESSION['msg_image'] = $for_image_validate->myEmpty(); ## сессионные сообщения // если не ввел название книги выдаст: Вы не ввели обязательный параметр
		if (empty($_SESSION['msg_image'])) {
			$_SESSION['msg_image'] = $for_image_validate->myCompare(); ## сессионные сообщения // если $_SESSION['msg_image'] - пустой, то сравнит, иначе - должно остаться сообщение: Вы не ввели обязательный параметр
		}
		if ($_SESSION['msg_image'] == "<h3 style='font-size: 15px; color: #009105;'>Данные обновлены</h3>") {
			## сделать апдейт поля $new_url_image
			move_uploaded_file ($_FILES['change_image']['tmp_name'], "../".$new_url_image); // загрузка файла *в папку: img/uploads*

			$data = new QueryBuilder; // создание объекта для апдейта БД
			$name_col_for_update = "`book`";
			$param = "`image`= '". $new_url_image . "'";
			$for_where = "`book`.`id_book` = ".$_SESSION['id_book'];
			$mass_for_update = array ($name_col_for_update, $param, $for_where);
			$u_book_name = $data->update($mass_for_update);
		}
	}
	
	## change_genre
	$comma_separated_genre = implode(", ", $_POST['change_genre']);//$_POST['change_genre'] -- это массив, нужно записать в строку
	$for_gerne_validate = new Validate($comma_separated_genre, $_SESSION['old_genre']); // создание объекта для проверки на заполненность
	$_SESSION['msg_genre'] = $for_gerne_validate->myEmpty(); ## сессионные сообщения // если не ввел автора выдаст: Вы не ввели обязательный параметр
	if (empty($_SESSION['msg_genre'])) {
		$_SESSION['msg_genre'] = $for_gerne_validate->myCompare(); ## сессионные сообщения // если $_SESSION['msg_genre'] - пустой, то сравнит, иначе - должно остаться сообщение: Вы не ввели обязательный параметр
	}
	if ($_SESSION['msg_genre'] == "<h3 style='font-size: 15px; color: #009105;'>Данные обновлены</h3>") {

		$genres = 'genre'; // табл
		$genre_mass = $data->select($genres); // все книги

		//1) поиск значение в массиве $author_mass и добавить значение которых раньше не было (если такие есть - которых не было)
		foreach ($genre_mass['data'] as $value) {
			$only_all_genre[$value['id_genre']] = $value['genre'];
		}
		foreach ($_POST['change_genre'] as $key=>$value) {
			$search = array_search($value, $only_all_genre);
			if (!empty($search) && $search!='') {
				$found[$key] = $search; // значения массива - ид выбранных жанров для книги
			}
		}
		 
		//2) удалить предидущие связи books_vs_genre
		$books_vs_genre = array("`books_vs_genre`", "`id_book`=".$_SESSION['id_book']); // табл
		$res_select_from_books_vs_genre = $data->select($books_vs_genre); // все книги
		foreach ($res_select_from_books_vs_genre['data'] as $value) {
			$name_col_for_update = "`books_vs_genre`";
			$for_where = "`books_vs_genre`.`id_book` = ".$value['id_book'];
			$mass_for_update = array ($name_col_for_update, $for_where);
			$u_book_name = $data->delete_rows($mass_for_update);

			// проверить остались ли связи по данному жанру ? если нет - status=0
			$name_col_for_update = "`books_vs_genre`";
			$for_where = "`books_vs_genre`.`id_genre` = ".$value['id_genre'];
			$mass_for_update = array ($name_col_for_update, $for_where);
			$select_book_name = $data->select($mass_for_update);
			if (empty($select_book_name['data'])) {
				$name_table = "`genre`";
				$change_status = "`status`= 0";
				$for_id = "`genre`.`id_genre` = ".$value['id_genre'];
				$update_genre_status = array ($name_table, $change_status, $for_id);
				$u_book_name = $data->update($update_genre_status);
			}
		}
		
		
		//3) установить новые связи
		foreach ($found as $value) {
			$name_table_for_update = "`books_vs_genre`";
			$param_col = '(`id`, `id_book`, `id_genre`)';
			$param_val = "(NULL, '" . $_SESSION['id_book'] . "', '".$value."')";
			$mass_for_add = array ($name_table_for_update, $param_col, $param_val);
			$lastId = $data->insert($mass_for_add);

			// так же делаем апдейт табл genre (на случай если status = 0)
			$name_table = "`genre`";
			$change_status = "`status`= 1";
			$for_id = "`genre`.`id_genre` = ".$value;
			$update_genre_status = array ($name_table, $change_status, $for_id);
			$u_book_name = $data->update($update_genre_status);
		}

	}

	## change_author
	$comma_separated_author = implode(", ", $_POST['change_author']);//$_POST['change_author'] -- это массив, нужно записать в строку
	$for_author_validate = new Validate($comma_separated_author, $_SESSION['old_author']); // создание объекта для проверки на заполненность
	$_SESSION['msg_author'] = $for_author_validate->myEmpty(); ## сессионные сообщения // если не ввел автора выдаст: Вы не ввели обязательный параметр
	if (empty($_SESSION['msg_author'])) {
		$_SESSION['msg_author'] = $for_author_validate->myCompare(); ## сессионные сообщения // если $_SESSION['msg_author'] - пустой, то сравнит, иначе - должно остаться сообщение: Вы не ввели обязательный параметр
	}
	if ($_SESSION['msg_author'] == "<h3 style='font-size: 15px; color: #009105;'>Данные обновлены</h3>") {

		$authors = 'author'; // табл
		$author_mass = $data->select($authors); // все книги

		//1) поиск значение в массиве $author_mass и добавить значение которых раньше не было (если такие есть - которых не было)
		foreach ($author_mass['data'] as $value) {
			$only_all_author[$value['id_author']] = $value['author'];
		}
		foreach ($_POST['change_author'] as $key=>$value) {
			$search = array_search($value, $only_all_author);
			if (!empty($search) && $search!='') {
				$found[$key] = $search; // значения массива - ид выбранных жанров для книги
			}
		}
			
		//2) удалить предидущие связи books_vs_author
		$books_vs_author = array("`books_vs_author`", "`id_book`=".$_SESSION['id_book']); // табл
		$res_select_from_books_vs_author = $data->select($books_vs_author); // все книги
		foreach ($res_select_from_books_vs_author['data'] as $value) {
			// удаление связей
			$name_col_for_update = "`books_vs_author`";
			$for_where = "`books_vs_author`.`id_book` = ".$value['id_book'];
			$mass_for_update = array ($name_col_for_update, $for_where);
			$u_book_name = $data->delete_rows($mass_for_update);

			// проверить остались ли связи по данному автору ? если нет - status=0
			$name_col_for_update = "`books_vs_author`";
			$for_where = "`books_vs_author`.`id_author` = ".$value['id_author'];
			$mass_for_update = array ($name_col_for_update, $for_where);
			$select_book_name = $data->select($mass_for_update);
			if (empty($select_book_name['data'])) {
				$name_table = "`author`";
				$change_status = "`status`= 0";
				$for_id = "`author`.`id_author` = ".$value['id_author'];
				$update_author_status = array ($name_table, $change_status, $for_id);
				$u_book_name = $data->update($update_author_status);
			}

		}
		
		
		//3) установить новые связи
		foreach ($found as $value) {
			$name_table_for_update = "`books_vs_author`";
			$param_col = '(`id`, `id_book`, `id_author`)';
			$param_val = "(NULL, '" . $_SESSION['id_book'] . "', '".$value."')";
			$mass_for_add = array ($name_table_for_update, $param_col, $param_val);
			$lastId = $data->insert($mass_for_add);	

			// так же делаем апдейт табл author (на случай если status = 0)
			$name_table = "`author`";
			$change_status = "`status`= 1";
			$for_id = "`author`.`id_author` = ".$value;
			$update_author_status = array ($name_table, $change_status, $for_id);
			$u_book_name = $data->update($update_author_status);
		}
	}
}

redirect($url); //Перенаправление на старницу change_bookpadge.php
?>