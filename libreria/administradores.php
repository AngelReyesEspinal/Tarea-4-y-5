<?php
    include("libreria/../configx.php");
    include("libreria/../conexion.php");

    if($_POST){
        $con = Conexion::getInstancia();
        extract($_POST);

        if($_POST['accion'] == "agregar"){ 
            # AGREGAR
            
            if($user != "" && $password != ""){
                $tipo = "normal";
                $sql = "INSERT INTO administradores (usuario, contrasenia, tipo) values (?, ?, ?)";
                $stmt = mysqli_prepare($con, $sql);
                $stmt->bind_param("sss", $user, $password, $tipo);
                $stmt->execute();

                echo "<script> alert('Se ha agregado el administrador!'); </script>";
                echo "<script> window.location = '/web/tarea4y5/administradores.php' </script>";
            } else {
                echo "<script> alert('Debes llenar los dos campos.'); </script>";
                echo "<script> window.location = '/web/tarea4y5/administradores.php' </script>";
            }
        } else { 
            # LOGIN

            if($user != "" && $password != ""){
                $esAdministrador = false;
                $rs = mysqli_query($con, "select * from administradores");
    
                $datos = array();
    
                while($fila = mysqli_fetch_object($rs)){
                    $datos[] = $fila;
                }
    
                foreach ($datos as $dato) {
                    if($dato->usuario == $user && $dato->contrasenia == $password){
                        $esAdministrador = true;
                    }
                }
    
                if($esAdministrador){
                    session_start();
                    $_SESSION['administrador'] = 'hayAdmin';
                    header('Location: http://localhost/web/tarea4y5/index.php');
                }else{
                    echo "<script> alert('Por favor verifica tus credenciales.'); </script>";
                    echo "<script> window.location = '/web/tarea4y5/login.php' </script>";
                }
            } else {
                echo "<script> alert('Debes llenar los dos campos.'); </script>";
                echo "<script> window.location = '/web/tarea4y5/login.php' </script>";
            }
        }        
    }
?>