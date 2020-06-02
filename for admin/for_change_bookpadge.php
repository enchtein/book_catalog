<?php
session_start (); // служит для передачи данных валидации
## должно быть в обработчике событий
include ('../include_all.php'); // подключение всех файлов
$url="change_bookpadge.php?id_book=" . $_SESSION['id_book'];
function redirect ($url){
	header("Location: " . $url);
	exit();
}

/* универсальная функция для валидации*/
function val_row($session, $post) {
	$check = new Validate(); // проверка поля на заполненность
	$res_check = $check->myvald($post);
	$a = $res_check;
	$b = $res_check;
	
		if ($a!='Вы не ввели обязательный параметр') {
		$was_change_field = new Validate(); // Делаем проверку на внесение изменений
		$res_was_change_field = $was_change_field->change($session, $post);
		$a = $res_was_change_field;
		}
			if ($b!=''){
				return $b;	
			} else {
				return $a;
			}
	}
/* универсальная функция для валидации*/

/* универсальная функция для апдейта*/
	function u_row($field, $name_field, $id_book) {

			$name_col_for_update = "`books`";
			$param = "`$name_field`= '".$field . "'";
			$for_where = "`books`.`id_book` = ".$id_book;
			$mass_for_update = array ($name_col_for_update, $param, $for_where);
			$save = new SQL(); // класс SQL
			$save->update($mass_for_update); // отправка запроса на апдейт
	}
/* универсальная функция для апдейта*/


## FOR change_book_name
if (isset($_POST['save_changes'])) {
	$_SESSION['msg_book_name'] = val_row ($_SESSION['old_book_name'], $_POST['change_book_name']);
	if (!empty($_POST['change_book_name'])) {
	u_row ($_POST['change_book_name'], "book_name", $_POST['id_book']);
	}
}

## Обновление поля image
if (isset($_POST['save_changes'])) { ## проверка наполненности поля

$check_image = new Validate(); // проверка image на заполненность
$_SESSION['msg_image'] = $check_image->myvald($_POST['change_image']);

if ($_FILES['change_image']['type']!='') {
		if ($_SESSION['msg_image']!="Вы не ввели обязательный параметр") {
	
// для новой картинки
$data = str_replace('/', '.', $_FILES['change_image']['type']);
$row = stristr($data, ".");
$new_url_image = "img/uploads/".uniqid().$row; //путь картинки
move_uploaded_file ($_FILES['change_image']['tmp_name'], "../".$new_url_image); // загрузка файла *нужно создать папку: uploads*
	
$was_change_image = new Validate(); // Делаем проверку на внесение изменений
$_SESSION['msg_image'] = $was_change_image->change($_SESSION['old_image'], $new_url_image);

	$name_col_for_update = "`books`";
	$param = "`images`= '".$new_url_image . "'";
	$for_where = "`books`.`id_book` = ".$_POST['id_book'];
	$mass_for_update = array ($name_col_for_update, $param, $for_where);
	$save = new SQL(); // класс SQL
	$update_data=$save->update($mass_for_update); // отправка запроса на апдейт
		}
	}
}

## FOR change_author
if (isset($_POST['save_changes'])) {
$_SESSION['msg_author'] = val_row ($_SESSION['old_author'], $_POST['change_author']);
	if (!empty($_POST['change_author'])) {
		$for_authors = array('*', 'author');
		$empl = new SQL();
		$author_mass=$empl->select($for_authors); // в этом массиве должны быть все авторы
			for ($i=0; $i<count($_POST['change_author']); $i++) {
				foreach ($author_mass as $key=>$value) { // поиск id автора
					$for_id_author = array_search($_POST['change_author'][$i], $value);
						if ($for_id_author!=''){
							$res_id_author[] = $value['id_author']; // массив с id_author
						break;
						}
					}
				}

		/* удалить все записи по id_book из табл. books_vs_author */
			$name_col_for_delete = "`books_vs_author`";
			$param = "`id_book`= '". $_POST['id_book'] . "'";
			$mass_for_delete_books_vs_author = array ($name_col_for_delete, $param);
			$delete_from_books_vs_author = new SQL(); // отправка запроса на удаление
			$delete_from_books_vs_author->delete_rows($mass_for_delete_books_vs_author); // удаление старых записей из таблицы books_vs_author
			
		/* вставить новые записи по id_book в табл. books_vs_author */
		foreach ($res_id_author as $key=>$value) {
			$name_table_for_insert = '`books_vs_author`';
			$param_col = '(`id`, `id_book`, `id_author`)';
			$param_val = "(NULL, '" . $_POST['id_book'] . "', '" . $value . "')"; // $VALUE ПРИНИМАЕТ ПАРАМЕТР id_author
			$mass_for_add_books_vs_author = array ($name_table_for_insert, $param_col, $param_val);
			$add_books_vs_author = new SQL(); // отправка запроса на добавление
			$add_books_vs_author->insert($mass_for_add_books_vs_author); // добавление новых записей в таблицу books_vs_author
		}
	}
}

## FOR change_genre
if (isset($_POST['save_changes'])) {
$_SESSION['msg_genre'] = val_row ($_SESSION['old_genre'], $_POST['change_genre']);
	if (!empty($_POST['change_genre'])) {
		$for_genres = array('*', 'genre');
		$empl = new SQL();
		$genre_mass=$empl->select($for_genres); // в этом массиве должны быть все жанры
		for ($i=0; $i<count($_POST['change_genre']); $i++) {
			foreach ($genre_mass as $key=>$value) { // поиск id жанра
				$for_id_genre = array_search($_POST['change_genre'][$i], $value);
				if ($for_id_genre!=''){
					$res_id_genre[] = $value['id_genre']; // массив с id_genre
				break;
				}
			}
		}
		/* удалить все записи по id_book из табл. books_vs_author */
			$name_col_for_delete = "`books_vs_genre`";
			$param = "`id_book`= '". $_POST['id_book'] . "'";
			$mass_for_delete_books_vs_genre = array ($name_col_for_delete, $param);
			$delete_from_books_vs_genre = new SQL(); // отправка запроса на удаление
			$delete_from_books_vs_genre->delete_rows($mass_for_delete_books_vs_genre); // удаление старых записей из таблицы books_vs_genre

		/* вставить новые записи по id_book в табл. books_vs_author */
		foreach ($res_id_genre as $key=>$value) {
			$name_table_for_insert = '`books_vs_genre`';
			$param_col = '(`id`, `id_book`, `id_genre`)';
			$param_val = "(NULL, '" . $_POST['id_book'] . "', '" . $value . "')"; // $VALUE ПРИНИМАЕТ ПАРАМЕТР id_genre
			$mass_for_add_books_vs_genre = array ($name_table_for_insert, $param_col, $param_val);
			$add_books_vs_genre = new SQL(); // отправка запроса на добавление
			$add_books_vs_genre->insert($mass_for_add_books_vs_genre); // добавление новых записей в таблицу books_vs_genre
		}
	}
}
	
## FOR short_descr
if (isset($_POST['save_changes'])) { 
$_SESSION['msg_short_descr'] = val_row ($_SESSION['old_short_descr'], $_POST['change_short_descr']);
	if (!empty($_POST['change_short_descr'])) {
	u_row ($_POST['change_short_descr'], "short_descr", $_POST['id_book']);
	}
}
	 
## FOR full_descr
if (isset($_POST['save_changes'])) {
$_SESSION['msg_full_descr'] = val_row ($_SESSION['old_full_descr'], $_POST['change_full_descr']);
	if (!empty($_POST['change_full_descr'])) {
	u_row ($_POST['change_full_descr'], "full_descr", $_POST['id_book']);
	}
}
	 
## FOR price
if (isset($_POST['save_changes'])) {
$_SESSION['msg_price'] = val_row ($_SESSION['old_price'], $_POST['change_price']);
	if (!empty($_POST['change_price'])) { 
	u_row ($_POST['change_price'], "price", $_POST['id_book']);
	}
}

redirect($url); //Перенаправление на старницу change_bookpadge.php
?>