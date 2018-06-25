<?php
    $editar = false;
    $valores = array("id" => "", "nombre" => "", "descripcion" => "", "imagen" => "");
    
    $mensaje = '';
    include("libreria/../configx.php");
    include("libreria/../conexion.php");
    
    if($_POST){
        # Verificando la existencia del directorio
        if(!is_dir('imagenes')){
            mkdir('imagenes');
        }
        
        # Obteniendo los datos de las imagenes
        $estatus = 'activa';
        $nombreImg = $_FILES['imagen']['name'];
        $tipoImg = $_FILES['imagen']['type'];
        $tamanioImg = $_FILES['imagen']['size'];
        $path = $_SERVER['DOCUMENT_ROOT'] . "/Web/Tarea4y5/libreria/imagenes/"; 
        $imagenGuardada = false;
    
        # ACCIONES AGREGAR / EDITAR: 
        if($_POST['accion'] == "agregar"){
            # Agregar
            
            # Gestionando las imagenes
            if($tamanioImg <= 5000000){ 
                if($tipoImg == "image/jpg" || $tipoImg == "image/png" || $tipoImg == "image/jpeg" || $tipoImg == "image/gif"){    
                    move_uploaded_file($_FILES['imagen']['tmp_name'], $path . $nombreImg);
                    $imagenGuardada = true;
                } else {
                    echo "<script> alert('No seleccionaste una imagen!'); </script>";
                    echo "<script> window.location = '/web/tarea4y5/administrarObras.php' </script>";
                }
            } else {
                echo "<script> alert('La imagen es demasiado grande!'); </script>";
                echo "<script> window.location = '/web/tarea4y5/administrarObras.php' </script>";
            }

            if($_POST['nombre'] != "" && $_POST['descripcion'] != "" && $tamanioImg > 0){       
                if($imagenGuardada){
                    $con = Conexion::getInstancia();
                    $sql = "INSERT INTO obras (nombre, descripcion, imagen, estatus) VALUES (?, ?, ?, ?)";
                    $stmt = mysqli_prepare($con, $sql);
                    mysqli_stmt_bind_param($stmt, 'ssss', $_POST['nombre'], $_POST['descripcion'], $nombreImg, $estatus);
                    mysqli_stmt_execute($stmt);

                    echo "<script> alert('Se guardo la imagen correctamente'); </script>";
                    echo "<script> window.location = '/web/tarea4y5/administrarObras.php' </script>";
                }
            } else {
                echo "<script> alert('Debes llenar todos los campos!'); </script>";
                echo "<script> window.location = '/web/tarea4y5/administrarObras.php' </script>";
            }
        } else {
            #Editar
            
            # Gestionando las imagenes
            if($tipoImg == null){ # Si es con la imagen vieja
                $nombreImg = $_POST['nombreImagen'];
                $imagenGuardada = true;
            } else { # Si se agrega una imagen nueva
                if($tamanioImg <= 5000000){
                    if($tipoImg == "image/jpg" || $tipoImg == "image/png" || $tipoImg == "image/jpeg" || $tipoImg == "image/gif"){    
                        move_uploaded_file($_FILES['imagen']['tmp_name'], $path . $nombreImg);
                        $imagenGuardada = true;
                    } else {
                        echo "<script> alert('No seleccionaste una imagen!'); </script>";
                        echo "<script> window.location = '/web/tarea4y5/administrarObras.php' </script>";
                    }
                } else {
                    echo "<script> alert('La imagen es demasiado grande!'); </script>";
                    echo "<script> window.location = '/web/tarea4y5/administrarObras.php' </script>";
                }
            }
            
            if($_POST['nombre'] != "" && $_POST['descripcion'] != ""){
                if($imagenGuardada){
                    $id = $_POST['id'] + 0;
                    $conn = Conexion::getInstancia();
                    $sql = "UPDATE `obras` SET `nombre`= ?, `descripcion`=?,`imagen`= ? WHERE `id`= ?";
                    $stmt = mysqli_prepare($conn, $sql);
                    mysqli_stmt_bind_param($stmt, 'sssi', $_POST['nombre'], $_POST['descripcion'], $nombreImg, $id);
                    mysqli_stmt_execute($stmt);

                    echo "<script> alert('Se edito la imagen correctamente'); </script>";
                    header('Location: /web/tarea4y5/index.php');
                }
            } else {
                echo "<script> alert('Debes llenar todos los campos!'); </script>";
                echo "<script> window.location = '/web/tarea4y5/administrarObras.php' </script>";
            }
        }
    } else {
        $conn = Conexion::getInstancia();
            
        # Editar
        if(isset($_GET['editar'])){
            $obraAEditar;
            $stmt = mysqli_prepare($conn, "SELECT * FROM obras WHERE id = ?");
            $stmt->bind_param("i", $_GET['editar']);
            $stmt->execute();
            
            $result = $stmt->get_result();
            while($row = $result->fetch_object()) {
                $obraAEditar  = $row;
            }

            $valores['id'] = $obraAEditar->id;
            $valores['nombre'] = $obraAEditar->nombre;
            $valores['descripcion'] = $obraAEditar->descripcion;
            $valores['imagen'] = $obraAEditar->imagen;
            
            $editar = true;
        } 

        # Cambiar estatus
        if(isset($_GET['id'])){
            extract($_GET);
            $estatus == ("activa") ? $estatus = "inactiva" :  $estatus = "activa";

            $sql = "UPDATE obras SET estatus = ? WHERE id = ?";
            $stmt = mysqli_prepare($conn, $sql);
            mysqli_stmt_bind_param($stmt, "si", $estatus, $id);
            mysqli_stmt_execute($stmt);
        }
    }

    function obtenerObras(){
        $conn = Conexion::getinstancia();
        $sql = "SELECT * FROM obras";
        $rs = mysqli_query($conn, $sql);

        $datos = array();

        while($fila = mysqli_fetch_object($rs)){
            $datos[] = $fila;
        }

        return $datos;
    }
?>