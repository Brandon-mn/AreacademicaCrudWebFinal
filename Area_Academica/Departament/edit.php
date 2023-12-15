<?php 

include("../conexion.php");




if (isset($_GET['idDepartment'])) {
    $txtid=(isset($_GET['idDepartment'])?$_GET['idDepartment']:"");
    $stm=$conexion->prepare("SELECT *FROM department where idDepartment=:txtid");
    $stm->bindparam(":txtid",$txtid);
    $stm->execute();
    $registro=$stm->fetch(PDO::FETCH_LAZY);
    $name=$registro['name'];
    $description=$registro['description'];
    $director=$registro['director'];
    $foundingDate=$registro['foundingDate'];
    $phone=$registro['phone'];
    $email=$registro['email'];
    $location=$registro['location'];
    $openingHour=$registro['openingHour'];
    $closingHour=$registro['closingHour'];
    $idEmployee=$registro['idEmployee'];
}


 if ($_POST) {
    $name=(isset($_POST['name'])?$_POST['name']:"");
    $description=(isset($_POST['description'])?$_POST['description']:"");
    $director=(isset($_POST['director'])?$_POST['director']:"");
    $foundingDate=(isset($_POST['foundingDate'])?$_POST['foundingDate']:"");   
    $phone=(isset($_POST['phone'])?$_POST['phone']:"");    
    $email=(isset($_POST['email'])?$_POST['email']:"");    
    $location=(isset($_POST['location'])?$_POST['location']:"");    
    $openingHour=(isset($_POST['openingHour'])?$_POST['openingHour']:"");    
    $closingHour=(isset($_POST['closingHour'])?$_POST['closingHour']:"");    
    $idEmployee=(isset($_POST['idEmployee'])?$_POST['idEmployee']:"");    
    $stm=$conexion->prepare("UPDATE department SET paymentAmount=:paymentAmount,payee=:payee,referenceNumber=:referenceNumber,paymentmethod=:paymentmethod WHERE idExternalPayment =:txtid ");
    $stm->bindParam(":txtid",$txtid);
    $stm->bindParam(":paymentAmount",$paymentAmount);
    $stm->bindParam(":payee",$payee);
    $stm->bindParam(":referenceNumber",$referenceNumber);
    $stm->bindParam(":paymentmethod",$paymentmethod);
    $stm->execute();
    header("location:index.php");

  }
  ?>


<?php include("../header.php");?>

<form action="" method="post">

         <input type="hidden" class="form-control" name="txtid" value="" placeholder="">
        <label for="">Payment Amount</label>
        <input type="text" class="form-control" name="paymentAmount" value="<?php echo $paymentAmount;?> " placeholder="Enter the Payment Amount">
        <label for="">Payeeo</label>
        <input type="text" class="form-control" name="payee" value="<?php echo $payee;?>" placeholder="Enter the Payee">
        <label for="">Reference Number </label>
        <input type="text" class="form-control" name="referenceNumber" value="<?php echo $referenceNumber;?>" placeholder="Enter Reference Number">
        <label for="">Payment Method</label>
        <input type="text" class="form-control" name="paymentmethod" value="<?php echo $paymentmethod;?>" placeholder="Enter the Payment Method">
        <option selected disabled> --Seleciona el autor--</option>
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
