<?php 

include("../conexion.php");




if (isset($_GET['idActivity'])) {
    $txtid=(isset($_GET['idActivity'])?$_GET['idActivity']:"");
    $stm=$conexion->prepare("SELECT *FROM activity where idActivity=:txtid");
    $stm->bindparam(":txtid",$txtid);
    $stm->execute();
    $registro=$stm->fetch(PDO::FETCH_LAZY);
    $activityName=$registro['activityName'];
    $description=$registro['description'];
}


 if ($_POST) {
    $activityName=(isset($_POST['activityName'])?$_POST['activityName']:"");
    $description=(isset($_POST['description'])?$_POST['description']:"");    
    $stm=$conexion->prepare("UPDATE acctivity SET activityName=:activityName,description=:description WHERE idActivity =:txtid ");
    $stm->bindParam(":txtid",$txtid);
    $stm->bindParam(":activityName",$activityName);
    $stm->bindParam(":description",$description);
    $stm->execute();
    header("location:index.php");

  }
  ?>


<?php include("../header.php");?>

<form action="" method="post">

         <input type="hidden" class="form-control" name="txtid" value="" placeholder="">
        <label for="">Activity Name</label>
        <input type="text" class="form-control" name="activityName" value="<?php echo $activityName;?> " placeholder="Enter the Activity Name">
        <label for="">Description</label>
        <input type="text" class="form-control" name="description" value="<?php echo $description;?>" placeholder="Enter the description">
    </div>
      <div class="modal-footer">
    <a href="index.php" class="btn btn-outline-danger">Cancel</a>
      <button type="submit" class="btn btn-outline-info">Update</button>
      </div>
      </form>
      <?php include("../foter.php");?>
