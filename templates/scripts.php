<script src="js/jquery.min.js"></script>
<script src="js/jquery-migrate-3.0.1.min.js"></script>
<script src="js/bootstrap.min.js"></script>
<script src="js/jquery.waypoints.min.js"></script>
<script src="js/jquery.stellar.min.js"></script>
<script src="js/owl.carousel.min.js"></script>
<script src="js/aos.js"></script>
<script src="js/scrollax.min.js"></script>
<script src="js/sorter.js"></script>
<script src="js/main.js"></script>
<?php
    if(strpos($nombrePagina, 'temporadasf1') != false) echo '<script src="js/formula1.js"></script>';
    if(strpos($nombrePagina, 'temporadasf2') != false) echo '<script src="js/formula2.js"></script>';
    if(strpos($nombrePagina, 'creaciones') != false) echo '<script src="js/creaciones.js"></script>';
    if(strpos($nombrePagina, 'modificaciones') != false) echo '<script src="js/modificaciones.js"></script>';
    if(strpos($nombrePagina, 'modificar-piloto') != false) echo '<script src="js/modificaciones.js"></script>';
    if(strpos($nombrePagina, 'modificar-escuderia') != false) echo '<script src="js/modificaciones.js"></script>';
    if(strpos($nombrePagina, 'modificar-pista') != false) echo '<script src="js/modificaciones.js"></script>';
    if(strpos($nombrePagina, 'configuracion') != false) echo '<script src="js/configuracion-temporada.js"></script>';
    if(strpos($nombrePagina, 'historiaf1') != false) echo '<script src="js/historiaf1.js"></script>';
    if(strpos($nombrePagina, 'historiaf2') != false) echo '<script src="js/historiaf2.js"></script>';
?>