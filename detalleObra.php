<?php
    $obra;

    # Dependencias
    include('libreria/configx.php');
    include('libreria/conexion.php');

    if(isset($_GET['id']))
    {
        $id = $_GET['id'] + 0;
        $conn = Conexion::getInstancia();
        $stmt = mysqli_prepare($conn, "SELECT * FROM obras WHERE id = ?");
        $stmt->bind_param('i', $id);
        $stmt->execute();
        
        
        $result = $stmt->get_result();
        while($row = $result->fetch_object()) {
            $obra  = $row;
        }
    }
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
            .titulo{
            }
        </style>
    </head>
    <body>
        <!-- header -->
        <?php include('componentes/header.php'); ?>

        <!-- main -->
        <main class="container">
            <h3 class="titulo"> <?php $titulo = $obra->nombre; echo strtoupper($titulo); ?> </h3>
            
            <center> 
                <img class="materialboxed z-depth-3" width="600" src="libreria/imagenes/<?php echo $obra->imagen ?>"> 
            </center>

            <h4> Descripción: </h4>
            <p style="text-align: justify;">
                <?php echo $obra->descripcion; ?>
            </p>  
        </main>

        <!-- footer -->
        <?php include('componentes/footer.php'); ?>

        <!-- scripts -->
        <script src="https://code.jquery.com/jquery-3.3.1.min.js" integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8=" crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0-beta/js/materialize.min.js"></script>
        <script>
            $(document).ready(function(){
                $('.materialboxed').materialbox();
            });
        </script>
    </body>
</html>