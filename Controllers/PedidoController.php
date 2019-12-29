<?php

require_once 'Models/Pedido.php';

class PedidoController {

    public function vistaHacerPedido() {

        require_once 'Views/Pedido/hacerPedido.php';
    }

    public function add() {
        //comprobar que esta identificado
        if (isset($_SESSION['identity'])) {
            //Guardar datos del formulario
            $usuario_id = $_SESSION['identity']->id;
            $provincia = isset($_POST['provincia']) ? $_POST['provincia'] : false;
            $localidad = isset($_POST['localidad']) ? $_POST['localidad'] : false;
            $direccion = isset($_POST['direccion']) ? $_POST['direccion'] : false;
            
            //Recogemos el total de los stats
            $stats = Utils::statsCarrito();
            $coste = $stats['total'];
            
            //Validar si existen los datos del formulario
            if ($provincia && $localidad && $direccion) {
                // Guardar datos en el modelo y bd
                $pedido = new Pedido();
                $pedido->setUsuario_id($usuario_id);
                $pedido->setProvincia($provincia);
                $pedido->setLocalidad($localidad);
                $pedido->setDireccion($direccion);
                $pedido->setCoste($coste);
                
                //Funcion save del modelo
                $save = $pedido->save();

                // Guardar linea pedido
                $save_linea = $pedido->save_linea(); 
                
                //Guardar mensajes en session
                if ($save && $save_linea) {
                    $_SESSION['pedido'] = "complete";
                } else {
                    $_SESSION['pedido'] = "failed";
                }
            } else {
                $_SESSION['pedido'] = "failed";
            }
            //redirigir a la confirmacion
            header("Location:" . base_url . 'Pedido/confirmado');
        } else {
            // Redigir al index si no esta identificado
            header("Location:" . base_url);
        }
    }

    public function confirmado() {
        if (isset($_SESSION['identity'])) {
            $identity = $_SESSION['identity'];
            $pedido = new Pedido();
            $pedido->setUsuario_id($identity->id);

            $pedido = $pedido->getOneByUser();

            $pedido_productos = new Pedido();
            $productos = $pedido_productos->getProductosByPedido($pedido->id);
        }
        require_once 'Views/Pedido/confirmado.php';
    }

    public function mis_pedidos() {
        Utils::isIdentity();
        $usuario_id = $_SESSION['identity']->id;
        $pedido = new Pedido();

        // Sacar los pedidos del usuario
        $pedido->setUsuario_id($usuario_id);
        $pedidos = $pedido->getAllByUser();

        require_once 'Views/Pedido/mis_pedidos.php';
    }

    public function detalle() {
        Utils::isIdentity();

        if (isset($_GET['id'])) {
            $id = $_GET['id'];

            // Sacar el pedido
            $pedido = new Pedido();
            $pedido->setId($id);
            $pedido = $pedido->getOne();

            // Sacar los poductos
            $pedido_productos = new Pedido();
            $productos = $pedido_productos->getProductosByPedido($id);

            require_once 'Views/Pedido/detalle.php';
        } else {
            header('Location:' . base_url . 'Pedido/mis_pedidos');
        }
    }

    public function gestion() {
        Utils::isAdmin();
        $gestion = true;

        $pedido = new Pedido();
        $pedidos = $pedido->getAll();

        require_once 'Views/Pedido/mis_pedidos.php';
    }

    public function estado() {
        Utils::isAdmin();
        if (isset($_POST['pedido_id']) && isset($_POST['estado'])) {
            // Recoger datos form
            $id = $_POST['pedido_id'];
            $estado = $_POST['estado'];

            // Upadate del pedido
            $pedido = new Pedido();
            $pedido->setId($id);
            $pedido->setEstado($estado);
            $pedido->edit();

            header("Location:" . base_url . 'Pedido/detalle&id=' . $id);
        } else {
            header("Location:" . base_url);
        }
    }

}

?>
