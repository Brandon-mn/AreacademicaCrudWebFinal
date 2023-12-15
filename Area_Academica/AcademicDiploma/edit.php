<?php 

include("../conexion.php");




if (isset($_GET['idAcademicDiploma'])) {
    $txtid=(isset($_GET['idAcademicDiploma'])?$_GET['idAcademicDiploma']:"");
    $stm=$conexion->prepare("SELECT *FROM academicdiploma where idAcademicDiploma=:txtid");
    $stm->bindparam(":txtid",$txtid);
    $stm->execute();
    $registro=$stm->fetch(PDO::FETCH_LAZY);
    $title=$registro['title'];
    $date=$registro['date'];
    $type=$registro['type'];
    $idStudent=$registro['idStudent'];

}


 if ($_POST) {
    $title=(isset($_POST['title'])?$_POST['title']:"");
    $date=(isset($_POST['date'])?$_POST['date']:"");
    $type=(isset($_POST['type'])?$_POST['type']:"");
    $idStudent=(isset($_POST['idStudent'])?$_POST['idStudent']:"");
    $stm=$conexion->prepare("UPDATE academicdiploma SET title=:title,date=:date,type=:type,idStudent=:idStudent WHERE idAcademicDiploma =:txtid ");
    $stm->bindParam(":txtid",$txtid);
    $stm->bindParam(":title",$title);
    $stm->bindParam(":date",$date);
    $stm->bindParam(":type",$type);
    $stm->bindParam(":idStudent",$idStudent);
    $stm->execute();
    header("location:index.php");

  }
  ?>


<?php include("../header.php");?>

<form action="" method="post">

         <input type="hidden" class="form-control" name="txtid" value="" placeholder="">
        <label for="">Title</label>
        <input type="text" class="form-control" name="title" value="<?php echo $title;?> " placeholder="Enter the Title">
        <label for="">Date</label>
        <input type="date" class="form-control" name="date" value="<?php echo $date;?>" placeholder="Enter the date">
        <label for="">Type </label>
        <input type="text" class="form-control" name="type" value="<?php echo $type;?>" placeholder="Enter the Type">
        <label for="">ID Student</label>
        <option selected disabled> --Select ID Student--</option>
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
