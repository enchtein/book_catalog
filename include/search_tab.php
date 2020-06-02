<!-- ДОБАВИЛ 11,02,2020 --><input size="40" value="Поиск работает корректно =) >>>>>>>>>>" disabled></input><!-- ПРОСТО ДЛЯ НАГЛЯДНОСТИ -->
		<textarea rows="1" name="text_for_search" type="text" placeholder="Введите автора"></textarea>   <!--ПОЛЕ ДЛЯ ПОИСКА ПО АВТОРУ-->
		<button type="submit" name="search">Поиск</button>
<?php ## для поиска
if (isset($_POST['search'])) { // если нажата кнопка поиска вывести результат поиска <> иначе вывести все
	include ('include/all/searching_data.php'); // подключение файла для валидации
	$check_data = new NEWClass(); // проверка адресса на заполненность
	$res_search = $check_data->searching_data($_POST['text_for_search']);
		if ($res_search[0]!='') {
			$on_screen = $res_search[0]; // в ключе [0] содержатся результаты поиска
			$c_search = count($res_search[0]); // количество найденных
			$title = "Результат поиска: " . $c_search . " " . $res_search[1] . "-ов"; // в ключе [1] содержется название того что искали
		} else {
			$title = "Извините по вашему запросу ничего не найденно!";
			$on_screen = '';
		}
}
?>