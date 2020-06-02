<?php ## Поиск
class NEWClass {
	function searching_data ($s) {
	include ('class_for_search.php'); // подключение файла для валидации
		$searching = new s_data();
		$res_of_search = $searching->searching($s); // результат поиска
		return $res_of_search; // вернуть результат
	}
}
?>