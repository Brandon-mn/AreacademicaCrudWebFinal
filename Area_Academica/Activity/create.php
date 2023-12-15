<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
<?php if ($_POST) {
    $activityName=(isset($_POST['activityName'])?$_POST['activityName']:"");
    $description=(isset($_POST['description'])?$_POST['description']:"");
    $stm=$conexion->prepare("INSERT INTO activity (activityName,description)
    values(:activityName,:description)");
    $stm->bindParam(":activityName",$activityName);
    $stm->bindParam(":description",$description);
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
        <label for="">Activity Name</label>
        <input type="text" class="form-control" name="paymentAmount" value="" placeholder="Enter the Activity Name">
        <label for="">Description</label>
        <input type="text" class="form-control" name="description" value="" placeholder="Enter the description">  
    </div>
      <div class="modal-footer">
      <button type="button" class="btn btn-outline-danger" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-outline-info">Aggregate data</button>
      </div>
      </form>
    </div>
  </div>
</div>