<?php ## универсальный вывод рефайна на странице

// (добавил 03.03.2020) START >>>
/* НАЧАЛО Пишу проверку привязки жанров/авторов к книгам */
// функция
function delete_empty_refain ($param_refain, $what, $what_checked) {
  $for_check = array('*', $param_refain); // данные для sql запроса
  $empl = new SQL();
  $for_result_check=$empl->select($for_check); // в этом массиве должны быть все данные из таблицы, которая записанна в переменной $param_refain
  foreach ($for_result_check as $value) {
    $prepair[] = $value[$what];
  }
  $prepair_2 = array_unique($prepair);
  foreach ($prepair_2 as $value) {
    $total_id[] = $value;
  }
  foreach ($what_checked as $key => $value) {
    $just_id[] = $value[$what]; // здесь только $what ТАБЛИЦЫ , которая записанна в переменной $what_checked
  }
  foreach ($just_id as $key => $value) {
    $found_key = array_search($value, $total_id);
    if ($found_key === FALSE) {
      $not_found_id[] = "`" . $what . "`=" . $value;
    }
  }
  return $not_found_id; // результатом выполнения данной функции является массив со значениями которые не используются в связке books_vs_genre! (которые надо удалить из таблицы массива -> $what_checked)
}
/* КОНЕЦ Пишу проверку привязки жанров/авторов к книгам */
// (добавил 03.03.2020) <<< END

// вытягиваем все данные из таблицы genre
$for_genres = array('*', 'genre');
$empl = new SQL();
$genre_mass=$empl->select($for_genres); // в этом массиве должны быть все жанры

// (добавил 03.03.2020) START >>>
// Проверяем привязку жанров к книгам
$param_refain = "`books_vs_genre`"; // таблица связок
$what = "id_genre"; // какой параметр просматриваем
$what_checked = $genre_mass; // массив который проверяем
$from_where_delete = "genre"; // таблица

$func = delete_empty_refain ($param_refain, $what, $what_checked);
if ($func!='') {
  array_unshift($func, $from_where_delete);
  $delete_mass_func = new SQL(); // отправка запроса на удаление
  $delete_mass_func->delete_rows($func); // удаление старых записей из таблицы books_vs_author
}
// (добавил 03.03.2020) <<< END

// вытягиваем все данные из таблицы author
$for_authors = array('*', 'author');
$empl = new SQL();
$author_mass=$empl->select($for_authors); // в этом массиве должны быть все авторы

// (добавил 03.03.2020) START >>>
// Проверяем привязку авторов к книгам
$param_refain = "`books_vs_author`"; // таблица связок
$what = "id_author"; // какой параметр просматриваем
$what_checked = $author_mass; // массив который проверяем
$from_where_delete = "author"; // таблица

$func = delete_empty_refain ($param_refain, $what, $what_checked);
if ($func!='') {
  array_unshift($func, $from_where_delete);
  $delete_mass_func = new SQL(); // отправка запроса на удаление
  $delete_mass_func->delete_rows($func); // удаление старых записей из таблицы books_vs_author
}
// (добавил 03.03.2020) <<< END
?>

<div id="fixed">																						<!-- вынести в док include/refain_tab.php и просто включать на каждой странице -->
	<ul class="nav nav-tabs">
      <li class="nav-item">
        <a class='nav-link-my active' data-toggle="tab" href="#cat1">Жанр</a>     
      </li>
      <li class="nav-item">
        <a class='nav-link-my' data-toggle="tab" href="#cat2">Автор</a>     
      </li>      
    </ul>
    <!-- секция вкладок -->
    <div class="tab-content">  
      <!-- контент первой категории -->
      <div id="cat1" class="tab-pane fade show active">
	 <?php foreach ($genre_mass as $key=>$value) : ?> <!-- Вывод циклом всех жанров БД -->
        <a href="admin_index.php?genre=<?php echo $value['genre'];?>"><?php echo $value['genre']; ?></a>
		<br>
	<?php endforeach; ?>
      </div>
      <!-- контент второй категории -->
      <div id="cat2" class="tab-pane fade">
	<?php foreach ($author_mass as $key=>$value) : ?> <!-- Вывод циклом всех авторов БД -->
        <a href="admin_index.php?author=<?php echo $value['author'];?>"><?php echo $value['author']; ?></a>
		<br>
	<?php endforeach; ?>
      </div>
	</div>
</div>																									<!-- вынести в док include/refain_tab.php и просто включать на каждой странице -->