<?php
session_start (); // служит для передачи данных валидации
## должно быть в обработчике событий
include ('../include_all.php'); // подключение всех файлов
function redirect ($url='add_bookpadge.php'){
	header("Location: $url");
	exit();
}

$for_genres = array('*', 'genre');
$empl = new SQL();
$genre_mass=$empl->select($for_genres); // в этом массиве должны быть все жанры

$for_authors = array('*', 'author');
$empl = new SQL();
$author_mass=$empl->select($for_authors); // в этом массиве должны быть все авторы

/* универсальная функция для валидации*/
function val_row($post) {
	$check = new Validate(); // проверка поля на заполненность
    $res_check = $check->myvald($post);
    return $res_check;
	}
/* универсальная функция для валидации*/

/* Данные нужны для сохранения в случае заполнения не всех полей */
$_SESSION['data_add_book_name'] = $_POST['add_book_name'];
$_SESSION['data_add_author'] = $_POST['add_author'];
$_SESSION['data_add_genre'] = $_POST['add_genre'];
$_SESSION['data_add_short_descr'] = $_POST['add_short_descr'];
$_SESSION['data_add_full_descr'] = $_POST['add_full_descr'];
$_SESSION['data_add_price'] = $_POST['add_price'];
/* Данные нужны для сохранения в случае заполнения не всех полей */

## Валидация поля add_book_name
if (isset($_POST['add_book'])) {
    $_SESSION['msg_add_book_name'] = val_row ($_POST['add_book_name']);
}
## Валидация поля add_author
if (isset($_POST['add_book'])) {
    $_SESSION['msg_add_author'] = val_row ($_POST['add_author']);
}
## Валидация поля add_genre
if (isset($_POST['add_book'])) {
    $_SESSION['msg_add_genre'] = val_row ($_POST['add_genre']);
}
## Валидация поля add_short_descr
if (isset($_POST['add_book'])) {
    $_SESSION['msg_add_short_descr'] = val_row ($_POST['add_short_descr']);
}
## Валидация поля add_full_descr
if (isset($_POST['add_book'])) {
    $_SESSION['msg_add_full_descr'] = val_row ($_POST['add_full_descr']);
}
## Валидация поля add_price
if (isset($_POST['add_book'])) {
    $_SESSION['msg_add_price'] = val_row ($_POST['add_price']);
}


$_SESSION['good_msg'] = '';

// Добавление данных в БД
if ($_POST['add_book_name']!='' && $_POST['add_author']!='' && $_POST['add_genre']!='' && $_POST['add_short_descr']!='' && $_POST['add_full_descr']!='' && $_POST['add_price']!='') {

    // Проверка жанров и авторов

/* Проверка жанров */
$pieces_genre = explode(", ", $_POST['add_genre']);

foreach ($pieces_genre as $key=>$value) {
	foreach ($genre_mass as $key_2=>$value2) {
	$result = array_search($value, $value2);
		
		if($result!='') {
			$res[$key+1] = $value; // найденные значения
		} else {
			$not_founr[] = $value; // не найденные зачения
		}
	}
}
	$res_genre = array_unique($not_founr);
	if ($res!='') {
		foreach ($res_genre as $key=>$value) {
			$result = array_search($value, $res);
			if($result=='') {
				$total[] = $value; // здесь значения которых раньше не было
			}
		}
	} else {
		foreach ($res_genre as $key=>$value) {
			$total[] = $value; // здесь значения которых раньше не было
		}
	}

if (!empty($total)) { // если такого жанра не было раньше - добавляем в таблицу genre
    foreach ($total as $value) {## Добавить значение новых жанров в таблицу жанров
$name_table_for_update = '`genre`';
$param_col = '(`id_genre`, `genre`)';
$param_val = "(NULL, '" . $value . "')";
$mass_for_add = array ($name_table_for_update, $param_col, $param_val);
$add_genre = new SQL(); // отправка запроса на добавление
$add_genre->insert($mass_for_add); // добавление нового жанра в таблицу genre
    }
}

/* Проверка авторов */
$pieces_author = explode(", ", $_POST['add_author']);

foreach ($pieces_author as $key=>$value) {
	foreach ($author_mass as $key_2=>$value2) {
	$result_author = array_search($value, $value2);
		
		if($result_author!='') {
			$res_auth[$key+1] = $value; // найденные значения
		} else {
			$not_founr_author[] = $value; // не найденные зачения
		}
	}
}
	$res_author = array_unique($not_founr_author);
	if ($res_auth!='') {
		foreach ($res_author as $key=>$value) {
			$result = array_search($value, $res_auth);
			if($result=='') {
				$total_author[] = $value; // здесь значения которых раньше не было
			}
		}
	} else {
		foreach ($res_author as $key=>$value) {
			$total_author[] = $value; // здесь значения которых раньше не было
		}
	}

if (!empty($total_author)) { // если такого автора не было раньше - добавляем в таблицу author
    foreach ($total_author as $value) {## Добавить значение новых авторов в таблицу авторов
$name_table_for_update = '`author`';
$param_col = '(`id_author`, `author`)';
$param_val = "(NULL, '" . $value . "')";
$mass_for_add = array ($name_table_for_update, $param_col, $param_val);
$add_author = new SQL(); // отправка запроса на добавление
$add_author->insert($mass_for_add); // добавление нового автора в таблицу author
    }
}


    // для новой картинки
$data = str_replace('/', '.', $_FILES['add_image']['type']);
$row = stristr($data, ".");
$new_url_image = "img/uploads/".uniqid().$row; //путь картинки
move_uploaded_file ($_FILES['add_image']['tmp_name'], "../" . $new_url_image); // загрузка файла *нужно создать папку: uploads*
if ($_FILES['add_image']['tmp_name']!='') { // если картинка не загруженна ставим заглушку
	$link_for_im = $new_url_image;
} else {
	$link_for_im = "img/phone_no image.png";
}

// массив в обновляемыми данными
$name_col_for_update = '`books`';
$param_col = '(`id_book`, `book_name`, `short_descr`, `full_descr`, `price`, `images`)';
$param_val = "(NULL, '" . $_POST['add_book_name'] . "', '" . $_POST['add_short_descr'] . "', '" . $_POST['add_full_descr'] . "', '" . $_POST['add_price'] . "', '" . $link_for_im . "')"; // должно вернуть id_book

// Подаем данные на добавление в табл
$mass_for_add = array ($name_col_for_update, $param_col, $param_val);
$add = new SQL(); // отправка запроса на добавление
$add_data=$add->insert($mass_for_add); // все книги // должно вернуть id_book потому что добавил функцию lastInsertId()
// После добавления данных нужно обновить связующие таблицы
		if ($add_data != '') {
			$_SESSION['good_msg'] = "Книга добавленна";
		}
		
		/* ДОБАВИТЬ авторов и жанры */
					//жанры
		if (!empty($_POST['add_genre'])) {
			$for_genres = array('*', 'genre');
			$empl = new SQL();
			$genre_mass=$empl->select($for_genres); // в этом массиве должны быть все жанры
			$pieces_genre = explode(", ", $_POST['add_genre']); // разбиваем по разделителю строку add_genre
			for ($i=0; $i<count($pieces_genre); $i++) {
				foreach ($genre_mass as $key=>$value) { // поиск id жанра
					$for_id_genre = array_search($pieces_genre[$i], $value);
					if ($for_id_genre!=''){
						$res_id_genre[] = $value; // массив с id_genre
					break;
					}
				}
			}
			/* вставить новые записи по id_book в табл. books_vs_genre */
			foreach ($res_id_genre as $key=>$value) {
				$name_table_for_insert = '`books_vs_genre`';
				$param_col = '(`id`, `id_book`, `id_genre`)';
				$param_val = "(NULL, '" . $add_data . "', '" . $value['id_genre'] . "')";
				$mass_for_add_books_vs_genre = array ($name_table_for_insert, $param_col, $param_val);
				$add_books_vs_genre = new SQL(); // отправка запроса на добавление
				$add_books_vs_genre->insert($mass_for_add_books_vs_genre); // добавление новых записей в таблицу books_vs_genre
			}
		}
							//авторы
		if (!empty($_POST['add_author'])) {
			$for_authors = array('*', 'author');
			$empl = new SQL();
			$author_mass=$empl->select($for_authors); // в этом массиве должны быть все авторы
			$pieces_author = explode(", ", $_POST['add_author']); // разбиваем по разделителю строку add_author
			for ($i=0; $i<count($pieces_author); $i++) {
				foreach ($author_mass as $key=>$value) { // поиск id автора
					$for_id_author = array_search($pieces_author[$i], $value);
					if ($for_id_author!=''){
						$res_id_author[] = $value; // массив с id_author
					break;
					}
				}
			}
			/* вставить новые записи по id_book в табл. books_vs_author */
			foreach ($res_id_author as $key=>$value) {
				$name_table_for_insert = '`books_vs_author`';
				$param_col = '(`id`, `id_book`, `id_author`)';
				$param_val = "(NULL, '" . $add_data . "', '" . $value['id_author'] . "')";
				$mass_for_add_books_vs_author = array ($name_table_for_insert, $param_col, $param_val);
				$add_books_vs_author = new SQL(); // отправка запроса на добавление
				$add_books_vs_author->insert($mass_for_add_books_vs_author); // добавление новых записей в таблицу books_vs_author
			}
		}
    }

redirect(); //Перенаправление на старницу add_bookpadge.php
?>