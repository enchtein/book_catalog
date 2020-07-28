<?php ## универсальный вывод рефайна на странице
require_once "classes/class/QueryBuilder.php"; // вызов подключения к классу QueryBuilder
$data = new QueryBuilder;

$genres = array("`genre`", "`status`=1"); // данные для выборки
$genre_mass = $data->select($genres); // вывод инфы на экран

$authors = array("`author`", "`status`=1"); // данные для выборки
$author_mass = $data->select($authors); // вывод инфы на экран
?>

<div id="fixed">																						<!-- вынести в док include/refain_tab.php и просто включать на каждой странице -->
	<ul class="nav nav-tabs">
      <li class="nav-item">
        <a class='nav-link-my active' data-toggle="tab" name="catvalue" href="#cat1">Жанр</a>     
      </li>
      <li class="nav-item">
        <a class='nav-link-my' data-toggle="tab" name="catvalue" href="#cat2">Автор</a>     
      </li>      
    </ul>
    <!-- секция вкладок -->
    <div class="tab-content">  
      <!-- контент первой категории -->
      <div id="cat1" class="tab-pane fade show active">
	 <?php foreach ($genre_mass['data'] as $key=>$value) : ?> <!-- Вывод циклом всех жанров БД -->
        <a href="index.php?genre=<?php echo $value['genre'];?>"><?php echo $value['genre']; ?></a>
		<br>
	<?php endforeach; ?>
      </div>
      <!-- контент второй категории -->
      <div id="cat2" class="tab-pane fade">
	<?php foreach ($author_mass['data'] as $key=>$value) : ?> <!-- Вывод циклом всех авторов БД -->
        <a href="index.php?author=<?php echo $value['author'];?>"><?php echo $value['author']; ?></a>
		<br>
	<?php endforeach; ?>
      </div>
	</div>
</div>
