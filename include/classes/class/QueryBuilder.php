<?php
## QueryBuilder.php
/*
$mass=scandir('../GeekForLess/include/classes');
print_r($mass);
*/
//require_once "../GeekForLess/include/classes/bdconnect_pdo.php"; // вызов подключения к бд
## Класс для запросов
class QueryBuilder
{
	public $what_selected = '*'; // ЧТО ВЫБИРАЮ (свойство по умолчанию)
	## Запрос SELECT
    public function select($parameter) {
        global $link; // подключение к БД
        ## ЕСЛИ нужно выбирать не все, необходимо переназначить свойство $what_selected, которое задано по умолчанию
        if (count($parameter)<2){
            $query = 'SELECT '.$this->what_selected.' FROM '.$parameter.';';
        } elseif (count($array)<3) {
            $query = 'SELECT '.$this->what_selected.' FROM '.$parameter[0].' WHERE '.$parameter[1].';';
        }
        $select_var = $link->prepare($query);
        $select_var->execute();
        $mass = $select_var->fetchAll();
        $from_where = $parameter;
        $end_mass['from_where'] = $parameter;
        $end_mass['data'] = $mass;
        return $end_mass; // результат: массив(массив с назв таблицы которую выбирали, массив с результатом данной выборки)
    }
	## Запрос UPDATE
    public function update($array) {
		global $link;
		if (count($array)<3){
			$a = "UPDATE $array[0] SET $array[1]";
		} elseif (count($array)<4) {
			$a = "UPDATE $array[0] SET $array[1] WHERE $array[2]";
        }
        $update_var = $link->prepare($a);
		$update_var->execute();
    }
    ## Запрос INSERT
    public function insert($array) {
        global $link;
        $a = "INSERT INTO $array[0] $array[1] VALUES $array[2]";
        $insert_var = $link->prepare($a);
        $res_insert = $insert_var->execute();
        $last_add_id = $link->lastInsertId(); //получаем id последней добавленной записи
        return $last_add_id;
    }
    ## Запрос DELETE
    public function delete_rows($array) {
        global $link;
        $a = "DELETE FROM $array[0] WHERE $array[1]";
        $delete_var = $link->prepare($a);
        $res_delete = $delete_var->execute();
        return $res_delete;
    }
}
?>