<?php session_start(); ?>

<header>
    <!-- opciones del dropdown -->
    <ul id="dropdown1" class="dropdown-content">
        <li><a href="administrarObras.php" style="color:#e57373!important;">Obras</a></li>
        <li><a href="administradores.php" style="color:#e57373!important;">Administradores</a></li>
    </ul>

    <nav>
        <div class='nav-wrapper'>
            <a href='index.php' class='brand-logo center'>Cándido Bidó SRC</a>
            <ul id='nav-mobile' class='right hide-on-med-and-down'>
                <?php if(isset($_SESSION['administrador'])) { ?>
                    <!-- disparador del dropdown -->
                    <?php echo"<li><a class='dropdown-trigger' href='#!' data-target='dropdown1'>Administrar<i class='material-icons right'>arrow_drop_down</i></a></li>"; ?>
                    <?php echo"<li><a href='componentes/cerrarSesion.php'>Cerrar Sesión</a></li>"?>
                <?php }else{ ?>
                    <?php echo"<li><a href='login.php'>Iniciar Sesión</a></li>"; ?>
                <?php } ?>
            </ul>
        </div>
    </nav>
</header>

<!-- js del dropdown -->
<script src="https://code.jquery.com/jquery-3.3.1.min.js" integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8=" crossorigin="anonymous"></script>
<script>
    $(document).ready(function(){
        $(".dropdown-trigger").dropdown();
    });
</script>
