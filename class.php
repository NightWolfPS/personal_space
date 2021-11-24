<?php
	class MyDiary {

		private $connect;
		private $table = array('posts' => 'posts', 'users' => 'users');

		private $DBadmin = 'root';
		private $DBpassword = '';

		public $id;
		public $name;
		public $content;
		public $dateTime;
		public $getSessionResult = R::findOne('users', 'login = ?', array($login));
		public $response = new Array();

		public function __construct($db){
			$this->connect = R::setup( 'mysql:host=localhost;dbname='.$db, $DBadmin, $DBpassword );
		}

		//Функция получения информации о существовании сессии
		public function getSessionInfo($login){
			if ( $getSessionResult ){
				$response[0] = true;
				if ( isset($_SESSION['user']) ){
					$response[1] = true;
				}else{
					$response[1] = false;
				}
			}else{
				$response[0] = false;
			}
			return $response;
		}

		//Функция шифрования данных
		public function EncryptDecrypt($type, $data){
			$out = '';
			switch($type){
				case 'encrypt':
					$key = base64_encode($_SESSION['user']['id'].$_SESSION['user']['login'].$_SESSION['user']['password']);
					$input = $data;
					$cipher = "aes-128-ctr";
					$ivlen = openssl_cipher_iv_length($cipher);
					$iv = hex2bin('5876836c54fb1afda2178d820655909c');
					$cipher_phrase = openssl_encrypt($input, $cipher, $key, 0, $iv);
				break;

				case 'decrypt':
					$key = base64_encode($_SESSION['user']['id'].$_SESSION['user']['login'].$_SESSION['user']['password']);
					$input = $data;
					$cipher = "aes-128-ctr";
					$ivlen = openssl_cipher_iv_length($cipher);
	    			$iv = hex2bin('5876836c54fb1afda2178d820655909c');
    				$cipher_phrase = openssl_decrypt($input, $cipher, $key, 0, $iv);
				break;
			
			}
			return $cipher_phrase;
		}

		//Функция авторизации
		public function SetSession($type, $authInfo){
			if ( !isset($_SESSION['user']) ){
				//Проводим авторизацию по типу отправки данных
				switch($type){
					case 'log':
						$password = $_POST['password'];
						$users = R::findOne('users', 'login = ?', $authInfo['login']);
						if( password_verify($authInfo['password'], $users->password)){
							$_SESSION['user'] = $users;
						}else{
							return false;
						}
						$response = true;
						break;

					case 'reg':
						$user = R::findOne('users', 'login = ?', $authInfo['login']);
						if(!$user){
							$user = R::dispense('users');
							$user->login = $authInfo['login'];
							$user->password = password_hash($authInfo['password'], PASSWORD_BCRYPT);
							$user->email = $authInfo['email'];
							$user->regdate = $today = new DateTime();
							R::store($user);
							$user = R::findOne('users', 'login = ?', $authInfo['login']);
							$_SESSION['user'] = $user;
						}else{
							return false;
						}
						$response = true;
					break;
				}
				return $response;
			}
		}

		public function GeneratePosts($type){
			
		}
	}
?>