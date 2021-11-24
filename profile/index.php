<!DOCTYPE html>
<html lang="ru">
<head>
	<meta charset="UTF-8">
	<meta name='viewport' content='width=device-width,initial-scale=1'/>
	<meta content='true' name='HandheldFriendly'/>
	<meta content='width' name='MobileOptimized'/>
	<meta content='yes' name='apple-mobile-web-app-capable'/>
	<meta name="description" content="Начни делиться своими идеями прямо сейчас!">
	<link rel="stylesheet" href="style.css">
	<link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css" rel="stylesheet">
	<link href="https://fonts.googleapis.com/css2?family=PT+Sans:wght@400;700&display=swap" rel="stylesheet">
	<link href="https://fonts.googleapis.com/css2?family=Zilla+Slab:wght@500&display=swap" rel="stylesheet">
	<link href="https://fonts.googleapis.com/css2?family=Rajdhani:wght@700&display=swap" rel="stylesheet">
	<title name="date">Будни говнокодера</title><script type="text/javascript">
		$.ajax({
			crossOrigin: true,
						url: "server.php",
						type: "POST",
						data: {date:true},
						dataType: "json",
						success: function(result) {
							if (!result.error){
								document.querySelector('title[name="date"]').innerHTML += ' ' + result.out;
							}
							else{
								console.log('Ошибка.');
							}
						}
					});
	</script>
	<script type="text/javascript" src="ajax-cross-origin/js/jquery.ajax-cross-origin.min.js"></script>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
	<script type="text/javascript" src="js/engine/version.js"></script>
	<script src="https://cdn.ckeditor.com/ckeditor5/29.0.0/classic/ckeditor.js"></script>
	 <!-- Main Quill library -->
	<!-- s<script src="//cdn.quilljs.com/1.3.6/quill.js"></script> -->
	<script src="//cdn.quilljs.com/1.3.6/quill.min.js"></script>
	<script src="quill-emoji.js"></script>
	<link rel="stylesheet" type="text/css" href="quill-emoji.css">

	<!-- Theme included stylesheets -->
	<link href="//cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">
	<script src="engine.js"></script>
</head>
<body class="night-theme">
	<div class="header-wrapper">
		<div class="header-container">
			<img src="logo.png" loading="lazy" alt="">
		</div>
	</div>
	<div class="posts-wrapper">
		<div class="sidebar">
			<ul>
				<li><a href="/public">Статьи</a></li>
				<li><a href="/private">Дневник</a></li>
				<li><a href="/settings">Настройки</a></li>
				<li><a href="/profile">
					<?php if(!isset($_SESSION['user'])): ?>
						Войти
					<?php else: ?>
					<?php
						echo ($_SESSION['user']['login']);
					?>
					<?php endif; ?>
				</a></li>
			</ul>
		</div>
		<script type="text/javascript">
			SesCheck();
			
		</script>
		<div class="posts-container" id="result"></div>
	</div>
	
	
</body>
</html>