<?php
    # Dependencias
    include('libreria/configx.php');
    include('libreria/conexion.php');

    # Evita que salgan errores por variables vacías
    error_reporting(E_ALL ^ E_NOTICE);

    # Paginacion
    $cantidad_resultados_por_pagina = 9; # Cantidad de resultados por pagina
    
    # Comprueba si está seteado el GET de HTTP
    if (isset($_GET["pagina"])) {
        # Si el GET de HTTP SÍ es una string / cadena, procede
        if (is_string($_GET["pagina"])) {
            # Si la string es numérica, define la variable 'pagina'
            if (is_numeric($_GET["pagina"])) {
                # Si la petición desde la paginación es la página uno
                # en lugar de ir a 'index.php?pagina=1' se iría directamente a 'index.php'
                if ($_GET["pagina"] == 1) {
                    header("Location: http://localhost/web/tarea4y5/index.php");
                    die();
                } else { # Si la petición desde la paginación no es para ir a la pagina 1, va a la que sea
                    $pagina = $_GET["pagina"];
                }
            } else { # Si la string no es numérica, redirige al index (por ejemplo: index.php?pagina=AAA)
                header("Location: index.php");
                die();
            }
        }
    } else { # Si el GET de HTTP no está seteado, lleva a la primera página (puede ser cambiado al index.php o lo que sea)
        $pagina = 1;
    }

    # Define el número 0 para empezar a paginar multiplicado por la cantidad de resultados por página
    $empezar_desde = ($pagina-1) * $cantidad_resultados_por_pagina;
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <title>Candido Bido SRC</title>

        <!-- recursos -->
        <link rel="stylesheet" href="css/estilosGenerales.css">
        <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0-beta/css/materialize.min.css">
        <style>
            .titulosObras{
                color: #e57373!important;
            }

            .card:hover{
                cursor: pointer;
                -webkit-box-shadow: 5px 5px 10px 0px #e57373!important;
            }
        </style>
    </head>
    <body>
        <!-- header -->
        <?php include('componentes/header.php'); ?>

        <!-- main -->
        <main class="container">
            <h3>Obras mas recientes</h3>

            <div class="row">
                <?php
                    # Obteniendo los datos 
                    $conn = Conexion::getinstancia();
                    $sql = "SELECT * FROM obras WHERE estatus = 'activa'";
                    $consulta_todo = mysqli_query($conn, $sql);

                    //Cuenta el número total de registros
                    $total_registros = mysqli_num_rows($consulta_todo);

                    //Obtiene el total de páginas existentes
                    $total_paginas = ceil($total_registros / $cantidad_resultados_por_pagina); 

                    //Realiza la consulta en el orden de ID ascendente (cambiar "id" por, por ejemplo, "nombre" o "edad", alfabéticamente, etc.)
                    //Limitada por la cantidad de cantidad por página
                    $consulta_resultados = mysqli_query($conn, " SELECT * FROM `obras` WHERE estatus = 'activa' ORDER BY `obras`.`id` ASC LIMIT $empezar_desde, $cantidad_resultados_por_pagina");

                    //Crea un bluce 'while' y define a la variable 'datos' ($datos) como clave del array
                    //que mostrará los resultados por nombre
                    while($datos = mysqli_fetch_array($consulta_resultados)) {  
                ?>
                    <div class="col s4">
                        <a href="http://localhost/web/tarea4y5/detalleObra.php?id=<?php echo $datos['id']; ?>">
                            <div class="card z-depth-3">
                                <div class="card-image">
                                    <img src="/web/tarea4y5/libreria/timthumb.php?src=/web/tarea4y5/libreria/imagenes/<?php echo $datos['imagen']; ?>&w=300&h=300" alt="obra de arte" />
                                </div>
                            </div>
                        </a>
                    </div>
                <?php } ?>
            </div>
            
            <ul class="pagination center">
                <?php 
                    if($pagina != 1){
                        $paginaAnterior = $pagina - 1;
                        echo "<li class=''><a href='?pagina=".$paginaAnterior."'><i class='material-icons'>chevron_left</i></a></li>";
                    } 
                ?>
                    <?php
                        for ($i = 1 ; $i <= $total_paginas ; $i++) {
                            if($pagina == $i){
                                echo "<li class='active'>";
                            } else {
                                echo "<li class=''>";
                            } 
                    ?>
                            <?php echo "<a href='?pagina=".$i."'>".$i."</a> "; ?> 
                        </li>
                    <?php } ?>     

                <?php 
                    if($pagina != $total_paginas){
                        $paginaSiguiente = $pagina + 1;
                        echo "<li class=''><a href='?pagina=".$paginaSiguiente."'><i class='material-icons'>chevron_right</i></a></li>";
                    } 
                ?>
            </ul>
        </main>
        
        <!-- footer -->
        <?php include('componentes/footer.php'); ?>

        <!-- scripts -->
        <script src="https://code.jquery.com/jquery-3.3.1.min.js" integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8=" crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0-beta/js/materialize.min.js"></script>
    </body>
</html>