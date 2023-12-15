<?php 
include("../conexion.php");
if (isset($_GET['idAcademicAward'])) {
    $txtid=(isset($_GET['idAcademicAward'])?$_GET['idAcademicAward']:"");
    $stm=$conexion->prepare("SELECT *FROM academicaward where idAcademicAward=:txtid");
    $stm->bindparam(":txtid",$txtid);
    $stm->execute();
    $registro=$stm->fetch(PDO::FETCH_LAZY);
    $date=$registro['date'];
    $nameAcademicAward=$registro['nameAcademicAward'];
    $description=$registro['description'];
    $recipients=$registro['recipients'];
    $idStudent=$registro['idStudent'];
}

 if ($_POST) {
    $date=(isset($_POST['date'])?$_POST['date']:"");
    $nameAcademicAward=(isset($_POST['nameAcademicAward'])?$_POST['nameAcademicAward']:"");
    $description=(isset($_POST['description'])?$_POST['description']:"");
    $recipients=(isset($_POST['recipients'])?$_POST['recipients']:"");
    $idStudent=(isset($_POST['idStudent'])?$_POST['idStudent']:"");
    $stm=$conexion->prepare("UPDATE academicaward SET date=:date,nameAcademicAward=:nameAcademicAward,description=:description,recipients=:recipients,idStudent=:idStudent WHERE idAcademicAward =:txtid ");
    $stm->bindParam(":txtid",$txtid);
    $stm->bindParam(":date",$date);
    $stm->bindParam(":nameAcademicAward",$nameAcademicAward);
    $stm->bindParam(":description",$description);
    $stm->bindParam(":recipients",$recipients);
    $stm->bindParam(":idStudent",$idStudent);
    $stm->execute();
    header("location:index.php");

  }
  ?>


<?php include("../header.php");?>

<form action="" method="post">
<label for="">Date</label>
        <input type="date" class="form-control" name="date" value="<?php echo $date;?>" placeholder="Enter the Date">
         <input type="hidden" class="form-control" name="txtid" value="" placeholder="Enter the Academic Award">
        <label for="">Name Academic Award</label>
        <input type="text" class="form-control" name="nameAcademicAward" value="<?php echo $nameAcademicAward;?> " placeholder="Enter the Name Academic Award">
        <label for="">Description</label>
        <input type="text" class="form-control" name="description" value="<?php echo $description;?>" placeholder="Enter the Description">
        <label for="">Recipients</label>
        <input type="text" class="form-control" name="recipients" value="<?php echo $recipients;?>" placeholder="Enter the Recipients">
        <option selected disabled> --Select the Student--</option>
        <select class="form-control" name="idStudent">
          <?php 
        require_once('../conexion.php');
       $consulta = "SELECT * FROM student where status = 1";
       $stm = $conexion->query($consulta);      
       while ($registro = $stm->fetch(PDO::FETCH_ASSOC)) {
       echo "<option value='" . $registro['idStudent'] . "'>" . $registro['name'] . "</option>";
     }
  ?>
        </select>     
    </div>
      <div class="modal-footer">
    <a href="index.php" class="btn btn-outline-danger">Cancel</a>
      <button type="submit" class="btn btn-outline-info">Update</button>
      </div>
      </form>
      <?php include("../foter.php");?>