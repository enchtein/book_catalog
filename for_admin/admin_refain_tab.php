<?php ## универсальный вывод рефайна на странице
require_once "../include/classes/class/all_classes.php"; // подключение файлов
$data = new QueryBuilder;

$genres = 'genre'; // данные для выборки
$genre_mass = $data->select($genres); // вывод инфы на экран

$authors = 'author'; // данные для выборки
$author_mass = $data->select($authors); // вывод инфы на экран

if (!empty($_GET)) {
	if (isset($_GET["dissable_author"])) {
		// удалить автора/жанр из БД
		$mass_for_delete = array('author', '`id_author`='.$_GET["dissable_author"]); // при нажатии на крестик удаляю автора
		$delete = new QueryBuilder;
		$delete->delete_rows($mass_for_delete);
	} elseif (isset($_GET["dissable_genre"])) {
		$mass_for_delete = array('genre', '`id_genre`='.$_GET["dissable_genre"]); // при нажатии на крестик удаляю жанр
		$delete = new QueryBuilder;
		$delete->delete_rows($mass_for_delete);
	}
	if (isset($_GET["OK"])) {
		// при добавлении сделать статус 0 (т.к. нет привязки)
		if (!empty($_GET['add'])) {
			if ($_GET['gender'] == 'genre') {
				foreach ($genre_mass['data'] as $value) {
					$only_genre_name[] = $value['genre'];
				}
				$res_ger_search = array_search($_GET['add'], $only_genre_name);
				if (empty($res_ger_search) && $res_ger_search !== 0) {
					$table_name_for_add_refain = 'genre';
					$table_name_for_add_param = $_GET['add'];
				}
			} elseif ($_GET['gender'] == 'author') {
				foreach ($author_mass['data'] as $value) {
					$only_author_name[] = $value['author'];
				}
				$res_auth_search = array_search($_GET['add'], $only_author_name);
				if (empty($res_auth_search) && $res_auth_search !== 0) {
					$table_name_for_add_refain = 'author';
					$table_name_for_add_param = $_GET['add'];
				}
			}
		}
		$name_table_for_update = '`'.$table_name_for_add_refain.'`';
		$param_col = '(`id_'.$table_name_for_add_refain.'`, `'.$table_name_for_add_refain.'`, `status`)';
		$param_val = "(NULL, '" . $table_name_for_add_param . "', 0)";
		$mass_for_add = array ($name_table_for_update, $param_col, $param_val);

		$insert = new QueryBuilder;
		$lastId = $insert->insert($mass_for_add);
	}
}
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
		<!-- Вывод циклом всех жанров БД со статусом 1 -->
		 <?php foreach ($genre_mass['data'] as $key=>$value) : 
			if ($value['status']==1) :
		 ?> 
		 <a href="admin_index.php?genre=<?php echo $value['genre'];?>"><?php echo $value['genre']; ?></a>
		<br>
		 <?php else : ?>
		<a href="admin_index.php?id_genre=<?php echo $value['genre'];?>" style="pointer-events: none; cursor: default; color: #999;"><?php echo $value['genre'];?></a><a href="admin_index.php?dissable_genre=<?php echo $value['id_genre'];?>"> X</a> <!-- удалить пустой жанр/автора -->
		<br>
		<?php 
			endif;
			endforeach;
		?>
		<!-- <a href="index.php" style="pointer-events: none; cursor: default; color: #999;">index.php</a><a href="index.php"> X</a> удалить пустой жанр/автора -->
      </div>
      <!-- контент второй категории -->
      <div id="cat2" class="tab-pane fade">
	  <!-- Вывод циклом всех авторов БД со статусом 1 -->
		<?php foreach ($author_mass['data'] as $key=>$value) : 
			if ($value['status']==1) :
		?>
        <a href="admin_index.php?author=<?php echo $value['author'];?>"><?php echo $value['author']; ?></a>
		<br>
		<?php else : ?>
		<a href="admin_index.php?id_author=<?php echo $value['author'];?>" style="pointer-events: none; cursor: default; color: #999;"><?php echo $value['author'];?></a><a href="admin_index.php?dissable_author=<?php echo $value['id_author'];?>"> X</a> <!-- удалить пустой жанр/автора -->
		<br>
		<?php 
			endif;
			endforeach;
		?>
      </div>
	  	  <!-- Использовать ТОЛЬКО для админа -->
	  <input name = "add" placeholder="Добавить значение"></input>
	  <br>
	  <div class="row">
	  <div class="col-sm-6">
<input type="radio" id="male" name="gender" value="genre">
<label for="male">Жанр</label><br>
<input type="radio" id="female" name="gender" value="author">
<label for="female">Автор</label><br>
		</div>
		<div class="col-sm-6">
	  <button name="OK" type="submit">OK</button>
	  </div>
		</div>
	  <br>
	  <!-- Использовать ТОЛЬКО для админа -->
	</div>
</div>																									<!-- вынести в док include/refain_tab.php и просто включать на каждой странице -->