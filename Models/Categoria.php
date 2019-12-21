<?php

class Categoria {

    private $id;
    private $nombre;
    private $dbConnection;

    public function __construct() {
        $this->dbConnection = Conexion::connect();
    }
    
    //GETTERS Y SETTERS

    function getId() {
        return $this->id;
    }

    function getNombre() {
        return $this->nombre;
    }

    function setId($id) {
        $this->id = $id;
    }

    function setNombre($nombre) {
        $this->nombre = $this->dbConnection->real_escape_string($nombre);
    }

    public function getAll() {
        $categorias = $this->dbConnection->query("SELECT * FROM categorias ORDER BY id DESC;");
        return $categorias;
    }

    public function getOne() {
        $categoria = $this->dbConnection->query("SELECT * FROM categorias WHERE id={$this->getId()}");
        return $categoria->fetch_object();
    }

    public function save() {
        $sql = "INSERT INTO categorias VALUES(NULL, '{$this->getNombre()}');";
        $save = $this->dbConnection->query($sql);

        $result = false;
        if ($save) {
            $result = true;
        }
        return $result;
    }

}
?>

