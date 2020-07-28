<?php
require_once "QueryBuilder.php"; // вызов подключения к бд
## Класс для отображения книг при клике на Refain
class PublishRefain
{
    public $books; // массив всех книг из наследуемого класса (вызван на index.php)
    public $get; // параметр который передается через адрессную строку
    public $content ='';

    public function __construct($books, $get) {
        $this->books = $books;
        if(!empty($get['genre'])) {
			$mass['genre'] = $get['genre'];
			$this->get = $mass;
		} elseif (!empty($get['author'])) {
			$mass['author'] = $get['author'];
			$this->get = $mass;
		} else {
			$mass['book'] = $get['id_book'];
			$this->get = $mass;
		}
    }

    //функция проверки привязки автора/жанра к книге
    private function checkerRefain() {
        $obj = new QueryBuilder;

## author
        $select_author = "`author`";
        $author = $obj->select($select_author);
        foreach ($author['data'] as $value) {
            if ($value['status'] == 1) {
                $only_author_Id_1[] = $value['id_author']; // status = 1
            } else {
                $only_author_Id_0[] = $value['id_author']; // status = 0
            }
        }
        $select_books_vs_author = "`books_vs_author`";
        $books_vs_author = $obj->select($select_books_vs_author);
        foreach ($books_vs_author['data'] as $value) {
            $pre_only_books_vs_author_Id[] = $value['id_author'];
        }
        $only_books_vs_author_Id = array_unique($pre_only_books_vs_author_Id); // удалить дубликаты
        // проверка таблицы `author` status = 1 на привязку к книгам (если НЕТ проставить 0)
        if (!empty($only_author_Id_1)) {
            foreach ($only_author_Id_1 as $value) {
                $res = array_search($value, $only_books_vs_author_Id);
                if  (empty($res) && $res !== 0) {
                    // такой связи книги с id_author НЕТ, нужно изменить на status = 0
                    $name_table = "`author`";
                    $change_status = "`status`= 0";
                    $for_id = "`author`.`id_author` = ".$value;
                    $update_author_status = array ($name_table, $change_status, $for_id);
                    $u_book_name = $obj->update($update_author_status);
                }
            }
        }
        // проверка таблицы `author` status = 0 на привязку к книгам (если ЕСТЬ проставить 1)
        if (!empty($only_author_Id_0)) {
            foreach ($only_author_Id_0 as $value) {
                $res = array_search($value, $only_books_vs_author_Id);
                if  (!empty($res) || $res === 0) {
                    // такая связь книги с id_author ЕСТЬ, нужно изменить на status = 1
                    $name_table = "`author`";
                    $change_status = "`status`= 1";
                    $for_id = "`author`.`id_author` = ".$value;
                    $update_author_status = array ($name_table, $change_status, $for_id);
                    $u_book_name = $obj->update($update_author_status);
                }
            }
        }
## genre
        $select_genre = "`genre`";
        $genre = $obj->select($select_genre);
        foreach ($genre['data'] as $value) {
            if ($value['status'] == 1) {
                $only_genre_Id_1[] = $value['id_genre']; // status = 1
            } else {
                $only_genre_Id_0[] = $value['id_genre']; // status = 0
            }
        }
        $select_books_vs_genre = "`books_vs_genre`";
        $books_vs_genre = $obj->select($select_books_vs_genre);
        foreach ($books_vs_genre['data'] as $value) {
            $pre_only_books_vs_genre_Id[] = $value['id_genre'];
        }
        $only_books_vs_genre_Id = array_unique($pre_only_books_vs_genre_Id); // удалить дубликаты
        // проверка таблицы `genre` status = 1 на привязку к книгам (если НЕТ проставить 0)
        if (!empty($only_genre_Id_1)) {
            foreach ($only_genre_Id_1 as $value) {
                $res = array_search($value, $only_books_vs_genre_Id);
                if  (empty($res) && $res !== 0) {
                    // такой связи книги с id_genre НЕТ, нужно изменить на status = 0
                    $name_table = "`genre`";
                    $change_status = "`status`= 0";
                    $for_id = "`genre`.`id_genre` = ".$value;
                    $update_genre_status = array ($name_table, $change_status, $for_id);
                    $u_book_name = $obj->update($update_genre_status);
                }
            }
        }
        // проверка таблицы `genre` status = 0 на привязку к книгам (если ЕСТЬ проставить 1)
        if (!empty($only_genre_Id_0)) {
            foreach ($only_genre_Id_0 as $value) {
                $res = array_search($value, $only_books_vs_genre_Id);
                if  (!empty($res) || $res === 0) {
                    // такая связь книги с id_genre ЕСТЬ, нужно изменить на status = 1
                    $name_table = "`genre`";
                    $change_status = "`status`= 1";
                    $for_id = "`genre`.`id_genre` = ".$value;
                    $update_genre_status = array ($name_table, $change_status, $for_id);
                    $u_book_name = $obj->update($update_genre_status);
                }
            }
        }
    }

    public function view() {

        $this->checkerRefain(); // запуск метода проверки привязки checkerRefain()

        foreach ($this->get as $key=>$value) {
			$table = $key; // название таблицы из которой надо выбрать значение
			$chose = $value; // значение по которому выбираем
        }

        $data = new QueryBuilder;

        $arr = array($table, "`".$table."` LIKE '$chose'");
        $table_mass = $data->select($arr); // массив genre (с выборкой по $chose)
        $new = $table_mass['data'][0];
        $id_table_name = 'id_'.$table;
		$books_vs_table_name = 'books_vs_'.$table;

        $books_vs_table = array("`".$books_vs_table_name."`", "`".$id_table_name."`=".$new[$id_table_name]);
        $books_vs_table_mass = $data->select($books_vs_table); // массив $books_vs_table

        foreach($books_vs_table_mass['data'] as $key=>$value) {
            $select_book = array('book', 'id_book='.$value['id_book']);
            $select_book_mass = $data->select($select_book); // массив $books_vs_table
           
            $select_book_mass['data'][0][$table] = $chose;
            $result_selecting['from_where'] = $table;
            $result_selecting['data'][] = $select_book_mass['data'][0];
        }
        $this->content = $result_selecting;
        return $this->content;
    }
}
?>