<?php

    session_start();  
    
    require_once 'autoload.php';
    
    require_once 'Config/Conexion.php';
    require_once 'Config/Parameters.php';
    require_once 'Utils/Utils.php';

    require_once 'Views/Layout/header.php';
    require_once 'Views/Layout/sidebar.php';    
   
    

    function show_error(){
            $error = new errorController();
            $error->error404();
    }

    if(isset($_GET['controller'])){
            $nombre_controlador = $_GET['controller'].'Controller';

    }elseif(!isset($_GET['controller']) && !isset($_GET['action'])){
            $nombre_controlador = controller_default;

    }else{
            show_error();
            exit();
    }

    if(class_exists($nombre_controlador)){	
            $controlador = new $nombre_controlador();

            if(isset($_GET['action']) && method_exists($controlador, $_GET['action'])){
                    $action = $_GET['action'];
                    $controlador->$action();
            }elseif(!isset($_GET['controller']) && !isset($_GET['action'])){
                    $action_default = action_default;
                    $controlador->$action_default();
            }else{
                    show_error();
            }
    }else{
            show_error();
    }

    require_once 'Views/Layout/footer.php';

?>