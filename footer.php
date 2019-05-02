
        <script src="assets/js/admin.js"></script>

        <?php if (login_check($mysqli) == false) { ?>
            
            <div class="container text-center">
            <div class="jumbotron mt-3">
                <h1 id="title" class="hidden"><span id="logo">log<span>in</span></span></h1>
                <h2>Ingreso</h2>
                <div class="p-3 mb-2 bg-danger text-white">No está autorizado para acceder a esta página.</div>
                <span class="error"></span> Por favor vaya al 
                <a class="btn btn-primary" href="index.html">login</a>
            </div>
        <?php } ?>

        </div>
        <!-- /container -->

        <nav class="navbar fixed-bottom navbar-expand-sm navbar-dark bg-dark">
            <a class="navbar-text" href="index.html">
                <img src="assets/img/logo.png" style="width: 7%;">SistemaPlus - Copyright 2016-<?php echo date("Y"); ?>
            </a>
        </nav> 
    </body>
</html>