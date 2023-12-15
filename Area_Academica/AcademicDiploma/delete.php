<?php 

include("../conexion.php");

if (isset($_GET['idAcademicDiploma'])) {
    $txtid=(isset($_GET['idAcademicDiploma'])?$_GET['idAcademicDiploma']:"");
    $stm=$conexion->prepare("UPDATE academicdiploma SET status= 0 WHERE idAcademicDiploma=:txtid");
    $stm->bindparam(":txtid",$txtid);
    $stm->execute();
    $registro=$stm->fetch(PDO::FETCH_LAZY);
}
header("Location:index.php"); 

  ?>