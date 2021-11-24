<?php
	require_once "server.php";
?>

<!DOCTYPE html>
<html lang="ru">
<head>
	<meta charset="UTF-8">
	<meta name='viewport' content='width=device-width,initial-scale=1'/>
	<link rel="stylesheet" href="assets/styles/style.css">
	<link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css" rel="stylesheet">
	<link href="https://fonts.googleapis.com/css2?family=PT+Sans:wght@400;700&display=swap" rel="stylesheet">
	<link href="https://fonts.googleapis.com/css2?family=Zilla+Slab:wght@500&display=swap" rel="stylesheet">
	<link href="https://fonts.googleapis.com/css2?family=Rajdhani:wght@700&display=swap" rel="stylesheet">
	<title name="date">Personal_Space</title>
</head>
<body class="night-theme">
	<div class="logo-load">
		<div class="img"></div>
		<div class="glitch"></div>
	</div>
	<?php 
	if( !isset($_SESSION['user']) ){
		header('Location: auth?page=regist');
	}else{
		header('Location: public');
	}
	?>
</body>
</html>