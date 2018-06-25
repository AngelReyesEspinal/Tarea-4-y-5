<?php include('libreria/obras.php'); ?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <title>Candido Bido SRC</title>
        
        <link rel="stylesheet" href="css/estilosInputs.css">
        <link rel="stylesheet" href="css/estilosGenerales.css">
        <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0-beta/css/materialize.min.css"> 
        <style>
            textarea.materialize-textarea:focus + label{
                color: #e57373 !important;
            }

            textarea.materialize-textarea:focus{
                border-bottom: 1px solid #e57373!important;
                box-shadow: 0 1px 0 0 #e57373!important;
            }
        </style>
    </head>
    <body>
        <!-- header -->
        <?php 
            include('componentes/header.php'); 
            if(!isset($_SESSION['administrador']))  
                header('Location: login.php');
        ?>
            
        <!-- main -->
        <main class="container">
            <div class="MargenTopAdministrar">
                <h2>Obras</h2>
            
                <div class="row">
                    <form class="col s12" method="post" action="libreria/obras.php" enctype="multipart/form-data">
                        <div class="row">
                            
                            <input id="id" type="hidden" class="validate" name="id" value="<?php echo $valores['id'] ?>">

                            <div class="file-field input-field col s12">
                                <div class="btn red lighten-2">
                                    <span>Selecciona la obra</span>
                                    <input type="file" name="imagen">
                                </div>
                                <div class="file-path-wrapper">
                                    <input class="file-path validate" value="<?php echo $valores['imagen'] ?>" type="text" name="nombreImagen">
                                </div>
                            </div>
                            
                            <div class="input-field col s12">
                                <i class="material-icons prefix">chevron_right</i>
                                <input id="nombre" type="text" class="validate" name="nombre" value="<?php echo $valores['nombre'] ?>" require>
                                <label for="nombre">Introduce el titulo de la obra</label>
                            </div>

                            <div class="input-field col s12">
                                <i class="material-icons prefix">chevron_right</i>
                                <textarea id="textarea" class="materialize-textarea" name="descripcion"> <?php echo $valores['descripcion'] ?> </textarea>
                                <label for="textarea">Introduce la descripción la obra</label>
                            </div>
                        </div>
                        
                        <?php $boton; $editar == true ? $boton = "<button class='waves-effect red lighten-2 btn-large right' name='accion' value='editar' type='submit'>Editar</button>" : $boton = "<button class='waves-effect red lighten-2 btn-large right' name='accion' value='agregar' type='submit'>Agregar</button>"; echo $boton; ?>
                    </form>
                </div>

                <h3 style="text-align:center; color:#e57373;"> <?php echo $mensaje; ?> </h3>
            </div>

            <?php $obras = obtenerObras(); ?>

            <!-- TABLE -->
            <table class="striped centered">
                <thead>
                    <tr>
                        <th>Nombre</th>
                        <th>Descripcion</th>
                        <th>Imagen</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                        if($obras != null){ 
                            foreach ($obras as $obra){
                            $desc = $obra->descripcion; 
                            $descripcion = substr($desc, 0, 40) . '...';
                    ?>
                        <tr>
                            <td> <?php echo $obra->nombre; ?> </td>
                            <td> <?php echo $descripcion ?> </td>
                            <td> 
                                <img src="/web/tarea4y5/libreria/timthumb.php?src=/web/tarea4y5/libreria/imagenes/<?php echo $obra->imagen;?>&w=100&h=100" alt="obra de arte" /> 
                            </td>

                            <td>
                                <a href='administrarObras.php?editar=<?php echo $obra->id ?>' class='waves-effect red lighten-2 btn-large'><i class='material-icons'>mode_edit</i></a>
                                <a href='administrarObras.php?id=<?php echo $obra->id ?>&estatus=<?php echo $obra->estatus ?>' class='waves-effect red lighten-2 btn-large'><i class='material-icons'><?php $resultado; $obra->estatus == ('activa') ? $resultado = "done" : $resultado = "clear"; echo $resultado;?></i></a>
                            </td>
                        </tr>
                    <?php 
                        } 
                    }
                    ?>
                </tbody>
            </table>

            <br/>
        </main>

        <!-- footer -->
        <?php include('componentes/footer.php'); ?>

        <!-- scripts -->
        <script src="https://code.jquery.com/jquery-3.3.1.min.js" integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8=" crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0-beta/js/materialize.min.js"></script>
    </body>
</html>
