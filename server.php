<?php
	require_once "rb.php";
	// require_once "class.php";

	session_start();
	// $start = 0;
	$endpoint = 20;
	R::setup( 'mysql:host=localhost;dbname=personalspacedb','root', '' );
	$user = R::dispense('users');
	$error = null;
	
	if( isset($_POST['logout']) ){
		session_destroy();
		header('Location: ../');
	}

	if( isset($_POST['register']) ){
		$datetime = new DateTime();
		$nickname = $_POST['nickname'];
		$login = $_POST['login'];
		$password = $_POST['password'];
		$password_again = $_POST['password_again'];
		if( $nickname == null ){
			$nickname = 'user'.bin2hex(openssl_random_pseudo_bytes(3));
		}
		if( $login == null ){
			$error = 'Поле Email обязательно для заполнения';
		}else if( R::findOne('users', 'login = ?', array($login)) ){
			$error = 'Пользователь с таким логином уже зарегистриван';
		}
		if( $password == null ){
			$error = 'Поле Пароль обязательно для заполнения';
		}
		if( $password != $password_again ){
			$error = 'Пароли не совпадают';
		}
		else{
			$session = R::findOne('users', 'login = ?', array($login));
			if( $session ){
				$_SESSION['user'] = $session;
			}else{
				$user->login = $login;
				$user->password = password_hash($password, PASSWORD_BCRYPT);
				$user->nickname = $nickname;
				$user->status = 'user';
				$user->avatar = '../assets/default.jpg';
				$user->regdate = $datetime->format('d.m.Y H:i');
				R::store($user);
				$session = R::findOne('users', 'login = ?', array($login));
				$_SESSION['user'] = $session;
				header('../');
			}
		}
	}

	if( isset($_POST['loginBTN']) ){
		$login = $_POST['login'];
		$password = $_POST['password'];
		$session = R::findOne('users', 'login = ?', array($login));
		if( password_verify($password, $session->password) ){
			$_SESSION['user'] = $session;
			header('../');
		}else{
			return false;
		}
	}

	if( isset($_POST['sendPublic']) ){
		$datetime = new DateTime();
		$datetime = $datetime->format('d.m.Y H:i');
		$post = R::dispense('public');
		$post->author = $_SESSION['user']['id'];
		$post->datetime = $datetime;
		$post->content = $_POST['out'];
		R::store($post);
		$id = R::findOne('public', 'author = ? AND datetime = ?', array($_SESSION['user']['id'], $datetime));
		header('Location: ../threads/?id='.$id->id);
	}

	if( isset($_POST['sendComment']) ){
		$datetime = new DateTime();
		$datetime = $datetime->format('d.m.Y H:i');
		$post = R::dispense('comments');
		$post->author = $_SESSION['user']['id'];
		$post->reply_id = $_GET['id'];
		$post->datetime = $datetime;
		$post->content = $_POST['out'];
		R::store($post);
	}

	function Thread($id){
		$out_post = '';
		$out_comment = '';
		$comments = R::getAll('SELECT * FROM comments WHERE reply_id = '.$id.' ORDER BY id DESC');
		$result = R::findOne('public', 'id = ?', array($id));
		if( $result ){
			$author = R::findOne('users', 'id = ?', array($result->author));
				$out_post = '<div class="post-card">
					<div class="info-block">
						<div class="avatar">
							<img src="../assets/default.jpg" alt="">
						</div>
						<a href="../profile/?id='.$author->id.'" tittle="'.$author->nickname.' '.$author->status.'"><div class="nickname '.$author->status.'">'.$author->nickname.'</div></a>
						<a href="../threads/?id='.$result->id.'"><div class="info-inlines">'.count($comments).' ответов</div></a>
						<div class="info-inlines">23k рейтинг</div>
									
					</div>
					<div class="content-block">
						<div class="datetime">'.$result->datetime.'</div>
						<div class="content">'.$result->content.'</div>
					</div>
					<div class="options-block">
						<div class="option">･･･</div>
						<div class="option ">↑</div>
						<div class="option  ">↓</div>
					</div>
				</div>';
		}
		
		if( $comments ){
			for( $i = 0; $i <= count($comments)-1; $i++ ){
				$author = R::findOne('users', 'id = ?', array($comments[$i]['author']));
				$reply = R::findOne('users', 'id = ?', array($result->author));
				$out_comment .= '<div class="post-card">
					<div class="info-block">
						<div class="avatar">
							<img src="../assets/default.jpg" alt="">
						</div>
						<a href="../profile/?id='.$author->id.'" tittle="'.$author->nickname.' '.$author->status.'"><div class="nickname '.$author->status.'">'.$author->nickname.'</div></a><br/>для <a href="../profile/?id='.$reply->id.'" tittle="'.$reply->nickname.' '.$reply->status.'"><div class="nickname '.$reply->status.'">'.$reply->nickname.'</div></a>
						
						<div class="info-inlines">23k рейтинг</div>
					</div>
					<div class="content-block">
						<div class="datetime">'.$comments[$i]['datetime'].'</div>
						<div class="content">'.$comments[$i]['content'].'</div>
					</div>
					<div class="options-block">
						<div class="option">･･･</div>
						<div class="option ">↑</div>
						<div class="option  ">↓</div>
					</div>
				</div>';
			}
		}
		$out = $out_post.$out_comment;
		return $out;
	}

	function UpdatePosts(){
		$result = R::getAll('SELECT * FROM public ORDER BY id DESC LIMIT 0, 10');
		if( $result ){
			for( $i = 0; $i <= count($result)-1; $i++){
				$author = R::findOne('users', 'id = ?', array($result[$i]['author']));
				$comments = R::getAll('SELECT * FROM comments WHERE reply_id = '.$result[$i]['id'].' ORDER BY id DESC');
				echo('<div class="post-card">
					<div class="info-block">
						<div class="avatar">
							<img src="../assets/default.jpg" alt="">
						</div>
						<a href="../profile/?id='.$author->id.'" tittle="'.$author->nickname.' '.$author->status.'"><div class="nickname '.$author->status.'">'.$author->nickname.'</div></a>
						<a href="../threads/?id='.$result[$i]['id'].'"><div class="info-inlines">'.count($comments).' ответов</div></a>
						<div class="info-inlines">23k рейтинг</div>
									
					</div>
					<div class="content-block">
						<div class="datetime">'.$result[$i]['datetime'].'</div>
						<div class="content">'.$result[$i]['content'].'</div>
					</div>
					<div class="options-block">
						<div class="option">･･･</div>
						<div class="option ">↑</div>
						<div class="option  ">↓</div>
					</div>
				</div>');
			}
		}
	}

	function countDaysBetweenDates($d1, $d2)
    {
    	$d1_ts = strtotime($d1);
		$d2_ts = strtotime($d2);
		$seconds = abs($d1_ts - $d2_ts);
		return floor($seconds / 86400);
	}

	function countDaysBetweenBirth($d1, $d2)
	{
		$d1_ts = strtotime($d1);
		$d2_ts = strtotime($d2);
		$seconds = abs($d1_ts - $d2_ts);
		return floor($seconds / 86400);
	}
?>