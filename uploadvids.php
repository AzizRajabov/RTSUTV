<?php
	require_once "lib/user_class.php";
	require_once "lib/uploadvideo_class.php";
	$user = User::getObject();
	$auth = $user->isAuth();
	if(isset($_POST["auth"])) {
		$login = $_POST["login"];
		$password = $_POST["password"];
		$auth_success = $user->login($login, $password);
		if($auth_success) {
			header("Location: uploadvids.php");
			exit;
		}
	}
	$vidname = $_FILES["video"]["name"];
	$path = "video/".$vidname;
	$namevid = $_POST['vidname'];
	$category = $_POST['category'];
	$desc = $_POST['desc'];
		if(isset($_POST["upload"])) {
				$upload_video = new UploadVideo();
				$success_video = $upload_video->uploadFile($_FILES["video"]);
				$mysqli = new mysqli("localhost", "root", "", "rtsutv");
				$mysqli->query("SET NAME UTF8");
				$mysqli->query("INSERT INTO `video` (`name`, `link`, `category`, `description` ,`upload_date`) VALUES ('$namevid', '$path', '$category', '$desc' ,'".time()."')");
				$mysqli->close();
	}
var_dump($_FILES);
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="windows-1251">
	<title>RTSUTV</title>
	<style>
		body{
			background-color: #fff;
			
		}
		
		h1 {
			margin-top: 0;
		}
		
		.auth {
			width: 250px;
			padding: 10px;
			background-color: #ccc;
			margin: 250px auto;
			border-radius: 20px;
		}
	</style>
</head>
<body>
	<?php
		if($auth) {
			echo '<h1>Загрузить видео</h1>
		<form name="myform" action="uploadvids.php" method="post" enctype="multipart/form-data">
			<table>
				<tr>
					<td>Наименование: </td>
					<td>
						<input type="text" name="vidname">
					</td>
				</tr>
				<tr>
					<td>Категория: </td>
					<td>
						<select name="category">
							<option value="" selected disabled>Выберите категорию</option>
							<option value="events">Мероприятия</option>
							<option value="tables">Круглые столы</option>
							<option value="lectures">Лекции</option>
							<option value="vlesson">Видеоуроки</option>
							<option value="vnews">Видео новости</option>
							<option value="studentw">Студенческие работы</option>
						</select>
					</td>
				</tr>
				<tr>
					<td>Видео: </td>
					<td>
						<input type="file" name="video">
					</td>
				</tr>
				<tr>
					<td>Описание: </td>
					<td>
						<textarea name="desc" id="" cols="30" rows="10"></textarea>
					</td>
				</tr>
				<tr>
					<td colspan="2">
						<input type="submit" value="Загрузить" name="upload">
					</td>
				</tr>
			</table>
		</form>
		<br>
		<a href="logout.php" class="exit">Exit</a>';
		} 
		else {
			if($_POST["auth"]) {
				if(!$auth_success) 
					echo "<span style='color: red;'>Неверный логин и/или пароль!</span>";
			}
			echo '<div class="auth">
	<h1>Авторизация</h1>
	<form name="auth" action="uploadvids.php" method="post">
		<table>
			<tr>
				<td>Логин: </td>
				<td><input type="text" name="login"></td>
			</tr>
			<tr>
				<td>Пароль: </td>
				<td><input type="password" name="password"></td>
			</tr>
			<tr>
				<td colspan="2">
					<input type="submit" name="auth" value="Войти">
				</td>
			</tr>
		</table>
	</form>
	</div>';
		}
	?>
</body>
</html>