<?php ## Поиск
include ('SQL classes.php'); // подключение файла для SQL запросов
class s_data {
	function searching ($i) {
		$search = $i; // получаем значение поиска (УБЕДИТЬСЯ ЧТО РАБОТАЕТ)
		/* From books */
		$for_all = array('*', 'books'); // формирование SQL запроса
		$empl = new SQL_select();
		$all_data=$empl->select($for_all); // результирующий массив всех данных из таблицы books
		/* From genre */
		$for_all_genre = array('*', 'genre'); // формирование SQL запроса
		$empl_genre = new SQL_select();
		$all_data_genre=$empl_genre->select($for_all_genre); // результирующий массив всех данных из таблицы genre
		/* From author */
		$for_all_author = array('*', 'author'); // формирование SQL запроса
		$empl_author = new SQL_select();
		$all_data_author=$empl_author->select($for_all_author); // результирующий массив всех данных из таблицы author
		
		
		/* поиск */
		## ищем в таблице book
		foreach ($all_data as $key => $value) { // ищем в таблице book
		$key_search = array_search($search, $value); // ключ первого найденного результата по запросу поиска
		
			if ($key_search != '') {
				if ($key_search!='id_book') { // если не содержит ключ id_book
				$result[] = $key; // записываем КЛЮЧИ всех найденных результатов поиска
				$param_name =  $key_search;
				} // если не содержит ключ id_book
			}
		}
		
		if ($result!='') {
			foreach ($result as $value_start) {
				$total[]=$all_data[$value_start]; // массив всех данных по $result
			}
		}
		
		## ищем в таблице genre
		if ($result=='') { // если результата нет - ищем в таблице genre
			foreach ($all_data_genre as $key => $value) {
			$key_search = array_search($search, $value); // ключ первого найденного результата по запросу поиска

				if ($key_search != '') {
					if ($key_search!='id_genre') { // если не содержит ключ id_genre
						$result[] = $value['id_genre']; // записываем id_genre того что ищем
						$param_name =  $key_search; // записываем то что ищем (название)
					} // если не содержит ключ id_genre
				}
			}

			if ($result!='') {
				foreach ($result as $value_start) {
					$search_MY_genre = array('id_book', "`books_vs_genre`", "`id_genre` = '" . $value_start . "'"); // данные для sql запроса
					$emplll = new SQL();
					$search_MY_genre_mass=$emplll->select($search_MY_genre); // в этом массиве должны быть все id_book выбранного жанра
					
					foreach ($search_MY_genre_mass as $val) {
						$for_MY_books = array('*', 'books', 'id_book='.$val['id_book']);
						$emplllbook = new SQL();
						$books_MY_mass=$emplllbook->select($for_MY_books); // в этом массиве должны быть все книги по жанру
						$result_search_MY_genre_mass[]=$books_MY_mass[0];
					}
					$pre_total[]=$result_search_MY_genre_mass; // массив всех данных по книгам с выбораным жанром
				}
			}
				$total = $pre_total[0];
		}
		
		## ищем в таблице author
		if ($result=='') { // если результата нет - ищем в таблице author
			foreach ($all_data_author as $key => $value) {
			$key_search = array_search($search, $value); // ключ первого найденного результата по запросу поиска
			
				if ($key_search != '') {
					if ($key_search!='id_author') { // если не содержит ключ id_author
					$result[] = $value['id_author']; // записываем id_author того что ищем
					$param_name =  $key_search; // записываем то что ищем (название)
					} // если не содержит ключ id_author
				}
			}
			if ($result!='') {
				foreach ($result as $value_start) {
					$search_MY_author = array('id_book', "`books_vs_author`", "`id_author` = '" . $value_start . "'"); // данные для sql запроса
					$emplll = new SQL();
					$search_MY_author_mass=$emplll->select($search_MY_author); // в этом массиве должны быть все id_book выбранного автора

					foreach ($search_MY_author_mass as $val) {
							$for_MY_books = array('*', 'books', 'id_book='.$val['id_book']);
							$emplllbook = new SQL();
							$books_MY_mass=$emplllbook->select($for_MY_books); // в этом массиве должны быть все книги по автору
							$result_search_MY_author_mass[]=$books_MY_mass[0];
						}
						$pre_total[]=$result_search_MY_author_mass; // массив всех данных по книгам с выбораным автором
					}
				}
					$total = $pre_total[0];
			}
		$res=array($total, $param_name); // $key_search - нужен для понимания того что мы нашли
		return ($res); // возвращаем результат поиска
	}
}
?>