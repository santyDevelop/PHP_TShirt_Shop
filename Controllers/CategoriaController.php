<?php

require_once 'Models/Categoria.php';
require_once 'Models/producto.php';

class categoriaController {

    public function renderizarVistaCategoria() {
        Utils::isAdmin();
        $categoria = new Categoria();
        $categorias = $categoria->getAll();
        
        require_once 'Views/Categoria/indexCategorias.php';
    }

    public function ver() {
        if (isset($_GET['id'])) {
            $id = $_GET['id'];

            // Conseguir categoria
            $categoria = new Categoria();
            $categoria->setId($id);
            $categoria = $categoria->getOne();

            // Conseguir productos;
            $producto = new Producto();
            $producto->setCategoria_id($id);
            $productos = $producto->getAllCategory();
        }

        require_once 'Views/Categoria/ver.php';
    }

    public function crear() {
        Utils::isAdmin();
        require_once 'Views/Categoria/Crear.php';
    }

    public function save() {
        Utils::isAdmin();
        if (isset($_POST) && isset($_POST['nombre'])) {
            // Guardar la categoria en bd
            $categoria = new Categoria();
            $categoria->setNombre($_POST['nombre']);
            $save = $categoria->save();
        }
        header("Location:" . base_url . "Categoria/renderizarVistaCategoria");
    }

}
