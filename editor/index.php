<?php
	require_once "../server.php";
	if( !isset($_SESSION['user']) ){
		header('Location: ../');
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
	<script type="text/javascript" src="ajax-cross-origin/js/jquery.ajax-cross-origin.min.js"></script>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
	
	<script src="https://cdn.ckeditor.com/ckeditor5/29.0.0/classic/ckeditor.js"></script> 
	 <!-- Main Quill library -->
	<script src="//cdn.quilljs.com/1.3.6/quill.js"></script> 
	<script src="//cdn.quilljs.com/1.3.6/quill.min.js"></script>
	<script src="assets/js/quill-emoji.js"></script>
	<link rel="stylesheet" type="text/css" href="../assets/styles/quill-emoji.css">
	<!-- Theme included stylesheets -->
	<link href="//cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">
	<script src="assets/js/engine.js"></script>
	<meta content='true' name='HandheldFriendly'/>
	<meta content='width' name='MobileOptimized'/>
	<meta content='yes' name='apple-mobile-web-app-capable'/>
	<meta name="description" content="Начни делиться своими идеями прямо сейчас!">
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
				<div class="l-container">
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
						<li><a href="../profile">Профиль <?php
						$user = R::findOne('users', 'id = ?', array($_SESSION['user']['id']));
						echo($user->nickname);
					?></a></li>
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
					<div class="title">Создай свой Personal_Space</div>
					<div class="form-container">
						<form action="" method='post'>
							<input type="email" name="login" class="inputs" placeholder="Email">
							<input type="password" name="password" class="inputs" placeholder="Пароль">
							<input type="submit" name="login" class="BTNs" value="Войти">
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
								<a href="../profile/?id=2">Блог</a>
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
						<?php
							$author = R::findOne('users', 'id = ?', array($_SESSION['user']['id']));
						?>
						<a href="../profile/?id=<?php echo($author->id); ?>" tittle="<?php echo($author->nickname.' '.$author->status); ?>"><div class="nickname <?php echo($author->status); ?>"><?php echo($author->nickname); ?></div></a>
						<a href=""><div class="info-inlines template"></div></a>
						<div class="info-inlines template"></div>
					</div>
					<form action="" method="post">
					<div class="content-block">
						<div class="datetime"><?php
						$datetime = new DateTime();
						echo($datetime->format('d.m.Y H:i'));
					?></div>
						<div class="editor-container">
							<div id="toolbar"></div>
							<div id="editor"></div>
							<textarea name="out" id="out" class="hidden" cols="30" rows="10"></textarea>
							<script type="text/javascript">
								var toolbarOptions = [
  ['bold', 'italic', 'underline', 'strike'],        // toggled buttons
  ['blockquote', 'code-block'],

  [{ 'header': 1 }, { 'header': 2 }],               // custom button values
  [{ 'list': 'ordered'}, { 'list': 'bullet' }],
  [{ 'script': 'sub'}, { 'script': 'super' }],      // superscript/subscript
  [{ 'indent': '-1'}, { 'indent': '+1' }],          // outdent/indent
  [{ 'direction': 'rtl' }],                         // text direction

  [{ 'size': ['small', false, 'large', 'huge'] }],  // custom dropdown
  [{ 'header': [1, 2, 3, 4, 5, 6, false] }],

  [{ 'color': [] }, { 'background': [] }],          // dropdown with defaults from theme
  [{ 'font': [] }],
  [{ 'align': [] }],
  ['video'],['image'],['link'],

  ['clean']                                         // remove formatting button
];

var quill = new Quill('#editor', {
  modules: {
    toolbar: toolbarOptions
  },
  theme: 'snow'
});
							</script>
						</div>
						<input type="submit" name="sendPublic" class="BTNs" value="Опубликовать">
					</form>
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
	<script type="text/javascript">
		$(document).ready(function(){
			$('input[name="sendPublic"]').on('click', function(){
				var inputText = document.querySelector('.ql-editor').innerHTML;
				document.querySelector('#out').value = inputText;
				console.log(document.querySelector('#out').value);
			});
		});
	</script>
</body>
</html>