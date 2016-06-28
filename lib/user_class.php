<?php
	
	class User {

		private $db;
		
		private static $user = null;
		
		private function __construct() {
			$this->db = new mysqli("localhost", "root", "", "rtsutv");
			$this->db->query("SET NAME 'utf8'");
		}
		
		public static function getObject() {
			if(self::$user === null) self::$user = new User();
			return self::$user;
		}
		
		
		private function checkUser($login, $password) {
			$result_set = $this->db->query("SELECT `password` FROM `users` WHERE `login` = '$login'");
			$user = $result_set->fetch_assoc();
			$result_set->close();
			if(!$user) return false;
			return $user["password"] === $password;
		}
		
		public function isAuth() {
			session_start();
			$login = $_SESSION['login'];
			$password = $_SESSION['password'];
			return $this->checkUser($login, $password);
		}
		
		public function login($login, $password) {
			$password = md5($password);
			if($this->checkUser($login, $password)) {
				session_start();
				$_SESSION['login'] = $login;
				$_SESSION['password'] = $password;
				return true;
			}
			else return false;
		}
		
		public function __destruct() {
			if($this->db) $this->db->close();
		}
		
		
	}
?>