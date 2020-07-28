<!-- ДОБАВИЛ 11,02,2020 --><input size="40" value="Поиск работает корректно =) >>>>>>>>>>" disabled></input><!-- ПРОСТО ДЛЯ НАГЛЯДНОСТИ -->
		<textarea rows="1" name="text_for_search" type="text" placeholder="Введите автора"></textarea>   <!--ПОЛЕ ДЛЯ ПОИСКА ПО АВТОРУ-->
		<button type="submit" name="search">Поиск</button>
<?php ## для поиска
if (isset($_POST['search'])) { // если нажата кнопка поиска вывести результат поиска <> иначе вывести все
	//require_once "../include/classes/class/Search.php"; // вызов подключения к классам
	require_once "../include/classes/class/all_classes.php"; // подключение файлов
	
	$res_search = (new Search($_POST['text_for_search']))->viewSearch(); // поиск
		if ($res_search['data']!='') {
			$on_screen = $res_search; // массив которые выводится на экран из ключа ['data']
			$c_search = count($res_search['data']); // количество найденных
			$title = "Результат поиска: " . $c_search . " " . $res_search['wtf'] . "-ов"; // в ключе [1] содержется название того что искали
		} else {
			$title = "Извините по вашему запросу ничего не найденно!";
			$on_screen = '';
		}
}
?>