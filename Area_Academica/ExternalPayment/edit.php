<?php 

include("../conexion.php");




if (isset($_GET['idExternalPayment'])) {
    $txtid=(isset($_GET['idExternalPayment'])?$_GET['idExternalPayment']:"");
    $stm=$conexion->prepare("SELECT *FROM externalPayment where idExternalPayment=:txtid");
    $stm->bindparam(":txtid",$txtid);
    $stm->execute();
    $registro=$stm->fetch(PDO::FETCH_LAZY);
    $paymentAmount=$registro['paymentAmount'];
    $payee=$registro['payee'];
    $referenceNumber=$registro['referenceNumber'];
    $paymentmethod=$registro['paymentmethod'];
}


 if ($_POST) {
    $paymentAmount=(isset($_POST['paymentAmount'])?$_POST['paymentAmount']:"");
    $payee=(isset($_POST['payee'])?$_POST['payee']:"");
    $referenceNumber=(isset($_POST['referenceNumber'])?$_POST['referenceNumber']:"");
    $paymentmethod=(isset($_POST['paymentmethod'])?$_POST['paymentmethod']:"");    
    $stm=$conexion->prepare("UPDATE externalpayment SET paymentAmount=:paymentAmount,payee=:payee,referenceNumber=:referenceNumber,paymentmethod=:paymentmethod WHERE idExternalPayment =:txtid ");
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
        
    </div>
      <div class="modal-footer">
    <a href="index.php" class="btn btn-outline-danger">Cancel</a>
      <button type="submit" class="btn btn-outline-info">Update</button>
      </div>
      </form>
      <?php include("../foter.php");?>
