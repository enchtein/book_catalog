<?php ## Запрос используется для поиска ( SELECT )
require_once("bdconnect_pdo.php"); // вызов подключения к бд
class SQL_select {
	function select($array) {
		global $link;
	  if (count($array)<3){
		  $a = "SELECT $array[0] FROM $array[1]";
	  } elseif (count($array)<4) {
		  $a = "SELECT $array[0] FROM $array[1] WHERE $array[2]";
	  } elseif (count($array)==4) {
		  $a = "SELECT $array[0] FROM $array[1] WHERE $array[2] ORDER BY $array[3]";
	  }
	  $select_var = $link->prepare($a);
	  $select_var->execute();
	  $mass = $select_var->fetchAll();
	  return ($mass); // Возвращаем результат поиска
	}
}