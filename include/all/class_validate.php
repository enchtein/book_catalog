<?php ## Валидация
class Validate {
	function myvald ($post) {
		if ($post=='') {
			return "<h3 style='font-size: 15px;'>Вы не ввели обязательный параметр</h3>"; // вернуть результат проверки на пустоту
		}
	}
	function change ($session, $post) {
		if ($session == $post) {
			return "<h3 style='font-size: 15px; color: #003ba8;'>Данные не изменились</h3>"; // вернуть результат проверки на изменения
		} else {
			return "<h3 style='font-size: 15px; color: #009105;'>Данные обновлены</h3>"; // вернуть результат проверки на изменения
		}
	}
}
?>