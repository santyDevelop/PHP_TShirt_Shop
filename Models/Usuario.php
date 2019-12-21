<?php

class Usuario{
	private $id;
	private $nombre;
	private $apellidos;
	private $email;
	private $password;
	private $rol;
	private $imagen;
        private $dbConection;
        	
	public function __construct() {
		$this->dbConection = Conexion::connect();
	}
	
        //GETTERS Y SETTERS
	function getId() {
		return $this->id;
	}

	function getNombre() {
		return $this->nombre;
	}

	function getApellidos() {
		return $this->apellidos;
	}

	function getEmail() {
		return $this->email;
	}

	function getPassword() {
		return password_hash($this->dbConection->real_escape_string($this->password), PASSWORD_BCRYPT, ['cost' => 4]);
	}

	function getRol() {
		return $this->rol;
	}

	function getImagen() {
		return $this->imagen;
	}

	function setId($id) {
		$this->id = $id;
	}

	function setNombre($nombre) {
		$this->nombre = $this->dbConection->real_escape_string($nombre);
	}

	function setApellidos($apellidos) {
		$this->apellidos = $this->dbConection->real_escape_string($apellidos);
	}

	function setEmail($email) {
		$this->email = $this->dbConection->real_escape_string($email);
	}

	function setPassword($password) {
		$this->password = $password;
	}

	function setRol($rol) {
		$this->rol = $rol;
	}

	function setImagen($imagen) {
		$this->imagen = $imagen;
	}

	public function save(){
		$querySql = "INSERT INTO usuarios VALUES(NULL, '{$this->getNombre()}', "
                . "'{$this->getApellidos()}', '{$this->getEmail()}', "
                . "'{$this->getPassword()}', 'user', null);";
		$queryResult = $this->dbConection->query($querySql);
		
		$result = false;
		if($queryResult){
			$result = true;
		}
		return $result;
	}
	
	public function login(){
		$result = false;
		$email = $this->email;
		$password = $this->password;
		
		// Comprobar si existe el usuario
		$sql = "SELECT * FROM usuarios WHERE email = '$email'";
		$login = $this->dbConection->query($sql);
		
		
		if($login && $login->num_rows == 1){
			$usuario = $login->fetch_object();
			
			// Verificar la contraseña
			$verify = password_verify($password, $usuario->password);
			
			if($verify){
				$result = $usuario;
			}
		}
		
		return $result;
	}
}
?>

