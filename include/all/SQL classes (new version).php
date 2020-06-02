<?php ## SQL запросы
require("bdconnect_pdo.php"); // вызов подключения к бд

/* КАК РАБОТАТЬ С НИМИ */

// ДЛЯ select:
/*
. Создать массив вида:
		что выбрать|название таблицы|критерий(необязателен)|сортировка(необязателен)
	$my = array('*', 'table_name', 'parameter=:$parameter', 'sort_by:=&sort_by');
. Передать его в функцию
*/

// ДЛЯ update:
/*
. Создать массив вида:
			название таблицы    обновляемое зачение       критерий(необязателен)
	$my = array('table_name', 'colum_name=:$parameter', 'parameter=:$parameter');
. Передать его в функцию
*/

// ДЛЯ insert:
/*
. Создать массив вида:
			название таблицы    	колонки таблицы       		вставляемые значения
	$my = array('table_name', '(param, param2, param3)', '(NULL, :id, :Date, :text, :status)');
	
$add_data = [
    'id' => $user_id, 
    'Date' => $date,
    'text' => $text,
    'status' => $status,
];
. Передать его в функцию
*/

class SQL {
	
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
	  return ($mass);
	}
	
	function update($array) {
		global $link;
		if (count($array)<3){
			$a = "UPDATE $array[0] SET $array[1]";
		} elseif (count($array)<4) {
			$a = "UPDATE $array[0] SET $array[1] WHERE $array[2]";
		}
		$update_var = $link->prepare($a);
		$update_var->execute();
	}
	
	function insert($array) {
		global $link;
		$a = "INSERT INTO $array[0] $array[1] VALUES $array[2]";
		$insert_var = $link->prepare($a);
		$res_insert = $insert_var->execute();
		$last_add_id = $link->lastInsertId(); //получаем id последней добавленной записи
		return $last_add_id;
	}
	
	function delete_rows($array) {
		global $link;
		$a = "DELETE FROM $array[0] WHERE $array[1]";
		$delete_var = $link->prepare($a);
		$res_delete = $delete_var->execute();
		return $res_delete;
	}

}
?>