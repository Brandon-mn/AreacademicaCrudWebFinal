<?php 

include("../conexion.php");

if (isset($_GET['idActivity'])) {
    $txtid=(isset($_GET['idActivity'])?$_GET['idActivity']:"");
    $stm=$conexion->prepare("UPDATE activity SET status= 0 WHERE idActivity=:txtid");
    $stm->bindparam(":txtid",$txtid);
    $stm->execute();
    $registro=$stm->fetch(PDO::FETCH_LAZY);
}
header("Location:index.php"); 

  ?>