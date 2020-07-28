<?php
require_once "PublishRefain.php"; // вызов подключения к бд
## Класс для просмотра информации по книге (bookpadge.php) // наследуеся от класса PublishRefain т.к. имеет одинаковые свойства
class BookInfo extends PublishRefain
{
    public function view() {
        // нужно просто переопределить метод
        foreach ($this->get as $key=>$value) {
			$table = $key; // название таблицы из которой надо выбрать значение
            $chose = $value; // значение по которому выбираем
            
            $id_table_name = 'id_'.$table; // 'id_book'
            $books_vs_author = 'books_vs_author';

            $data = new QueryBuilder;

            $arr = array("`".$table."`", "`".$id_table_name."` = $chose");
            $table_mass = $data->select($arr); // массив книгой (с выборкой по $chose)

            $new = $table_mass['data'][0];
            $books_vs_genre = array("`books_vs_genre`", "`".$id_table_name."`=".$new[$id_table_name]);
            $books_vs_genre_mass = $data->select($books_vs_genre); // массив $books_vs_table

            if (count($books_vs_genre_mass['data']) < 2) {
                foreach($books_vs_genre_mass['data'] as $key=>$value) {
                    $select_book = array('genre', 'id_genre='.$value['id_genre']);
                    $pre_select_book_mass = $data->select($select_book); // массив $books_vs_table
                    $info_genre = $pre_select_book_mass['data'][0]['genre']; // genre
                }
            } else {
                foreach($books_vs_genre_mass['data'] as $key=>$value) {
                    $select_book = array('genre', 'id_genre='.$value['id_genre']);
                    $pre_select_book_mass = $data->select($select_book); // массив $books_vs_table
                    $pre_info_genre[] = $pre_select_book_mass['data'][0]['genre']; // genre
                }
                $info_genre = implode(", ", $pre_info_genre);
            }
            

            $books_vs_author = array("`books_vs_author`", "`".$id_table_name."`=".$new[$id_table_name]);
            $books_vs_author_mass = $data->select($books_vs_author); // массив $books_vs_table
            if (count($books_vs_author_mass['data']) < 2) {
                foreach($books_vs_author_mass['data'] as $key=>$value) {
                    $select_book = array('author', 'id_author='.$value['id_author']);
                    $pre_select_book_mass = $data->select($select_book); // массив $books_vs_table
                    $info_author = $pre_select_book_mass['data'][0]['author']; // genre
                }
            } else {
                foreach($books_vs_author_mass['data'] as $key=>$value) {
                    $select_book = array('author', 'id_author='.$value['id_author']);
                    $pre_select_book_mass = $data->select($select_book); // массив $books_vs_table
                    $pre_info_author[] = $pre_select_book_mass['data'][0]['author']; // genre
                }
                $info_author = implode(", ", $pre_info_author);
            }

            $table_mass['data'][0]['genre'] = $info_genre;
            $table_mass['data'][0]['author'] = $info_author;
            $this->content = $table_mass;
            return $this->content;
        }
    }
}
?>