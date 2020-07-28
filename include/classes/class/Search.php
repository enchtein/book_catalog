<?php
##class_search.php
//require_once "../include/classes/class.php"; // вызов подключения к классам
## NEW
require_once "QueryBuilder.php"; // вызов подключения к классам
class Search
{
    public $search_data; // искомое значение
    private $locking_data; // просматриваемое значние
    private $book; // table `book`
    private $genre; // table `genre`
    private $author; // table `author`
    
    public function __construct($search_data) {
        $this->search_data = $search_data;
    }
    
    private function searchindBook() { // здесь ищем
        ## сначала искать в табл. book
        $data = new QueryBuilder;
        $book = $data->select("`book`");
        $this->book = $book; // table `book`
        
        foreach ($book['data'] as $key=>$value) {
            $found = array_search($this->search_data, $value);
            if (!empty($found) &&  $found!='' &&  $found!='id_book') {
                $first_result['wtf'] = $found; // подготовка массива для вывода
                
                $pre_first_result['id_book'] = $value['id_book']; // пара ключ=>значение (параметр для отображения результатов поиска)
                $pre_first_result['book_name'] = $value['book_name']; // пара ключ=>значение (параметр для отображения результатов поиска)
                $pre_first_result['image'] = $value['image']; // пара ключ=>значение (параметр для отображения результатов поиска)
                
                $first_result['data'][] = $pre_first_result; // подготовка массива для вывода
            }
        }
        ## сначала искать в табл. genre
        $data = new QueryBuilder;
        $genre = $data->select("`genre`");
        $this->genre = $genre; // table `genre`
		
        foreach ($genre['data'] as $key=>$value) {
            $found = array_search($this->search_data, $value);
            if ($found=='genre') { // доступ по поиску только для поля 'genre'
                $books_vs_genre = $data->select("`books_vs_genre`"); // table `books_vs_genre`
                $second_result['wtf'] = $found; // подготовка массива для вывода

                foreach ($books_vs_genre['data'] as $value_relation) {
                    $chose_id = array_search($value['id_genre'], $value_relation);
                    if ($value['id_genre'] == $value_relation['id_genre']) {
                        foreach ($book['data'] as $key_book=>$value_book) {
                            if ($value_book['id_book'] == $value_relation['id_book']) {
                                $pre_second_result['id_book'] = $value_book['id_book']; // пара ключ=>значение (параметр для отображения результатов поиска)
                                $pre_second_result['book_name'] = $value_book['book_name']; // пара ключ=>значение (параметр для отображения результатов поиска)
                                $pre_second_result['image'] = $value_book['image']; // пара ключ=>значение (параметр для отображения результатов поиска)
                                
                                $second_result['data'][] = $pre_second_result; // подготовка массива для вывода
                            }
                        }
                        
                    }
                }
            }
        }
        
        ## сначала искать в табл. author
        $data = new QueryBuilder;
        $author = $data->select("`author`");
        $this->author = $author; // table `author`
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
        foreach ($author['data'] as $key=>$value) {
            $found = array_search($this->search_data, $value);
            if ($found=='author') { // доступ по поиску только для поля 'author'
                $books_vs_author = $data->select("`books_vs_author`"); // table `books_vs_genre`
                $third_result['wtf'] = $found; // подготовка массива для вывода

                foreach ($books_vs_author['data'] as $value_relation) {
                    $chose_id = array_search($value['id_author'], $value_relation);
                    if ($value['id_author'] == $value_relation['id_author']) {
                        foreach ($book['data'] as $key_book=>$value_book) {
                            if ($value_book['id_book'] == $value_relation['id_book']) {
                                $pre_third_result['id_book'] = $value_book['id_book']; // пара ключ=>значение (параметр для отображения результатов поиска)
                                $pre_third_result['book_name'] = $value_book['book_name']; // пара ключ=>значение (параметр для отображения результатов поиска)
                                $pre_third_result['image'] = $value_book['image']; // пара ключ=>значение (параметр для отображения результатов поиска)
                                
                                $third_result['data'][] = $pre_third_result; // подготовка массива для вывода
                            }
                        }
                        
                    }
                }
            }
        }
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
        
        
        if (!empty($first_result)) {
            $finish = $first_result;
        } elseif (!empty($second_result)) {
            $finish = $second_result;
        } elseif (!empty($third_result)) {
            $finish = $third_result;
        } else {
            $finish['wtf'] = 'EMPTY';
            $finish['data'] = '';
        }

        $this->locking_data = $finish; // результат поиска
    }
    
    public function viewSearch() { // здесь выводим результат
        $this->searchindBook(); // результат храниться в переменной $this->locking_data
        return $this->locking_data;
    }
}
?>