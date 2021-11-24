<?php
	require_once "../server.php";
	if( isset($_SESSION['user']) ){
		header('Location: ../public');
		exit;
	}
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<link rel="icon" type="image/png" href="../assets/favicon.png">
	<link rel="stylesheet" type="text/css" href="../assets/styles/style.css">
	<title>Personal_Space</title>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/clipboard.js/1.5.10/clipboard.min.js"></script>
	<script src="https://cdn.jsdelivr.net/sharer.js/latest/sharer.min.js"></script>
</head>
<body>
	<div class="header-wrapper">
		<div class="header-container">
			<a class="logo" href="../public">
				<div class="logo-block">
					<div class="logo-img"></div>
					<div class="logo-effect"></div>
				</div>
			</a>
			<div class="search-block"><input type="text" class="search" name="search" placeholder="Поиск"></div>
			<?php if( isset($_SESSION['user']) ): ?>
			<form action="" method="post">
				<input type="submit" name="logout" value="Выйти" class="BTNs">
			</form>
			<?php endif; ?>
		</div>
	</div>
	<div class="content-wrapper">
		<div class="content-container">
			<div class="l-side">
				<?php if( isset($_SESSION['user']) ): ?>
				<div class="menu-block">
					<ul>
						<li><a href="../public">Статьи</a></li>
						<li><a href="../private">Дневник</a></li>
						<li><a href="../editor">Создать запись</a></li>
						<?php if(R::findOne('users', 'login = ?', array($_SESSION['user']['login']))['status'] == 'moderator' || R::findOne('users', 'login = ?', array($_SESSION['user']['login']))['status'] == 'developer' ): ?>
							<li><a href="../moderation">Модерация</a></li>
						<?php endif; ?>
						<li><a href="../settings">Настройки</a></li>
						<li><a href="../profile">Профиль</a></li>
					</ul>
				</div>
				<?php endif; ?>
				<?php if( !isset($_SESSION['user']) && (isset($_GET['page']) && $_GET['page'] == 'regist') ): ?>
				<div class="auth-block">
					<div class="title">Создай свой Personal_Space</div>
					<?php if( $error != null ): ?>
						<div class="notice">
							<?php echo($error); ?>
						</div>
					<?php endif; ?>
					<div class="form-container">
						<form action="" method='post'>
							<input type="text" name="nickname" class="inputs" placeholder="Никнейм">
							<input type="email" name="login" class="inputs" placeholder="Email">
							<input type="password" name="password" class="inputs" placeholder="Пароль">
							<input type="password" name="password_again" class="inputs" placeholder="Повторите пароль">
							<input type="submit" name="register" class="BTNs" value="Создать">
						</form>
					</div>
					<div class="auth-info">Нажимая кнопку “Создать” соглашаетесь с <a href="">политикой конфиденциальности</a> данного сайта</div>
					<div class="auth-redir">Есть аккаунт? <a href="?page=login">Войдите!</a></div>
				</div>
				<?php endif; ?>
				<?php if( !isset($_SESSION['user']) && (isset($_GET['page']) && $_GET['page'] == 'login') ): ?>
				<div class="auth-block">
					<div class="title">Твой Personal_Space</div>
					<div class="form-container">
						<form action="" method='post'>
							<input type="email" name="login" class="inputs" placeholder="Email">
							<input type="password" name="password" class="inputs" placeholder="Пароль">
							<input type="submit" name="loginBTN" class="BTNs" value="Войти">
						</form>
					</div>
					<div class="auth-redir">Нет аккаунта? <a href="?page=regist">Создайте!</a></div>
				</div>
				<?php endif; ?>
				<div class="links-block">
					<a href="../policy">Политика</a>
					<a href="../manual">Руководство</a>
					<a href="../getmodstatus">Стать модератором</a>
					<div class="sub-block">
						<div>Еще >
							<div class="sub-menu">
								<a href="../about">О проекте</a>
								<!-- <a href="../ads">Реклама</a> -->
								<a href="../blog">Блог</a>
								<a href="../donut">Поддержать</a>
							</div>
						</div>
					</div>

				</div>
				<!--Шаблоны объектов-->
				<div class="ads-block">
					<div class="ads-card">
						<div class="ads-close">x</div>
						<div class="ads-text">
							Здесь могла быть Ваша реклама
						</div>
					</div>
				</div>

				<!-- <div class="auth-block">
					<div class="title">Создай свой Personal_Space</div>
					<div class="form-container">
						<form action="" method='post'>
							<input type="text" name="nickname" class="inputs" placeholder="Никнейм">
							<input type="email" name="login" class="inputs" placeholder="Email">
							<input type="password" name="password" class="inputs" placeholder="Пароль">
							<input type="password" name="password_again" class="inputs" placeholder="Повторите пароль">
							<input type="submit" name="register" class="BTNs" value="Создать">
						</form>
					</div>
					<div class="auth-info">Нажимая кнопку “Создать” соглашаетесь с <a href="">политикой конфиденциальности</a> данного сайта</div>
					<div class="auth-redir">Есть аккаунт? <a href="">Войдите!</a></div>
				</div>
				<div class="auth-block">
					<div class="title">Создай свой Personal_Space</div>
					<div class="form-container">
						<form action="" method='post'>
							<input type="email" name="login" class="inputs" placeholder="Email">
							<input type="password" name="password" class="inputs" placeholder="Пароль">
							<input type="submit" name="login" class="BTNs" value="Войти">
						</form>
					</div>
					<div class="auth-redir">Нет аккаунта? <a href="">Создайте!</a></div>
				</div> -->
			</div>
			<div class="main-block">
				<div class="post-card">
					<div class="info-block">
						<div class="avatar">
							<img src="../assets/default.jpg" alt="">
						</div>
						<a href=""><div class="nickname developer">tEm04ka</div></a>
						<a href=""><div class="info-inlines">1k ответов</div></a>
						<div class="info-inlines">23k рейтинг</div>
					</div>
					<div class="content-block">
						<div class="datetime">01.01.1970 00:47</div>
						<div class="content">Lorem ipsum, dolor sit amet consectetur, adipisicing elit. A earum facilis aspernatur voluptates quibusdam autem, repellat perspiciatis ea veniam, ad nostrum in quae dolore quas quaerat, saepe aliquam culpa voluptas.</div>
					</div>
					<div class="options-block">
						<div class="option">･･･</div>
						<div class="option ">↑</div>
						<div class="option  ">↓</div>
					</div>
				</div>
				<div class="post-card">
					<div class="info-block">
						<div class="avatar">
							<img src="../assets/default.jpg" alt="">
						</div>
						<a href=""><div class="nickname developer">tEm04ka</div></a><br/>для <a href=""><div class="nickname developer">tEm04ka</div></a>
						<a href=""><div class="info-inlines">1k ответов</div></a>
						<div class="info-inlines">23k рейтинг</div>
					</div>
					<div class="content-block">
						<div class="datetime">01.01.1970 00:47</div>
						<div class="content">Lorem ipsum, dolor sit amet consectetur, adipisicing elit. A earum facilis aspernatur voluptates quibusdam autem, repellat perspiciatis ea veniam, ad nostrum in quae dolore quas quaerat, saepe aliquam culpa voluptas.</div>
					</div>
					<div class="options-block">
						<div class="option">･･･</div>
						<div class="option ">↑</div>
						<div class="option  ">↓</div>
					</div>
				</div>
				
			</div>
		</div>
	</div>	
</body>
</html>