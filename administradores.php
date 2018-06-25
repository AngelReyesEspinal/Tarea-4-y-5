<?php include('libreria/administradores.php'); ?>

<!DOCTYPE html>
<html lang="en">
    <head>
    <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <title>Candido Bido SRC</title>

        <!-- recursos -->
        <link rel="stylesheet" href="css/estilosInputs.css">
        <link rel="stylesheet" href="css/estilosGenerales.css">
        <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0-beta/css/materialize.min.css">
    </head>
    <body>
        <!-- header -->
        <?php include('componentes/header.php'); ?>

        <!-- main -->
        <main class="container">
            <div class="MargenTopLogin">
                <h2>Crear administradores</h2>
                
                <div class="row">
                    <form class="col s12" action="libreria/administradores.php" method="post">
                        <div class="row">
                            <div class="input-field col s12">
                                <i class="material-icons prefix">add</i>
                                <input id="user" type="text" class="validate" name="user" require>
                                <label for="user">Introduce el usuario</label>
                            </div>

                            <div class="input-field col s12">
                                <i class="material-icons prefix">add</i>
                                <input id="password" type="password" class="validate" name="password" require>
                                <label for="password">Introduce la contraseña</label>
                            </div>
                        </div>

                        <button class="waves-effect  red lighten-2 btn-large right" type="submit" name="accion" value="agregar">Crear</button>
                    </form>
                </div>
            </div>
        </main>

        <!-- footer -->
        <?php include('componentes/footer.php'); ?>

        <!-- scripts -->
        <script src="https://code.jquery.com/jquery-3.3.1.min.js" integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8=" crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0-beta/js/materialize.min.js"></script>
    </body>
</html>