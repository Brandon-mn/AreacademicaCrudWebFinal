<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
<?php if ($_POST) {
    $paymenyAmount=(isset($_POST['paymentAmount'])?$_POST['paymentAmount']:"");
    $payee=(isset($_POST['payee'])?$_POST['payee']:"");
    $referenceNumber=(isset($_POST['referenceNumber'])?$_POST['referenceNumber']:"");
    $paymentmethod=(isset($_POST['paymentmethod'])?$_POST['paymentmethod']:"");
    $stm=$conexion->prepare("INSERT INTO externalpayment (paymentAmount,payee,referenceNumber,paymentmethod)
    values(:paymentAmount,:payee,:referenceNumber,:paymentmethod)");
    $stm->bindParam(":paymentAmount",$paymenyAmount);
    $stm->bindParam(":payee",$payee);
    $stm->bindParam(":referenceNumber",$referenceNumber);
    $stm->bindParam(":paymentmethod",$paymentmethod);
    $stm->execute();
    header("location:index.php");
}
?>
<div class="modal fade" id="crear" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Add External Payment</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form action="index.php" method="post">
      <div class="modal-body">
        <label for="">Payment Amount</label>
        <input type="text" class="form-control" name="paymentAmount" value="" placeholder="Enter the Payment Amount">
        <label for="">Payee</label>
        <input type="text" class="form-control" name="payee" value="" placeholder="Enter the Payee">
        <label for="">Reference Number</label>
        <input type="text" class="form-control" name="referenceNumber" value="" placeholder="Enter the Reference Number">
        <label for="">Paymenthod</label>
        <input type="text" class="form-control" name="paymentmethod" value="" placeholder="Enter the Paymenthod">   
    </div>
      <div class="modal-footer">
      <button type="button" class="btn btn-outline-danger" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-outline-info">Aggregate data</button>
      </div>
      </form>
    </div>
  </div>
</div>