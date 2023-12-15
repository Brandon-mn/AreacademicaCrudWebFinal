<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
<?php if ($_POST) {
    $title=(isset($_POST['title'])?$_POST['title']:"");
    $date=(isset($_POST['date'])?$_POST['date']:"");
    $type=(isset($_POST['type'])?$_POST['type']:"");
    $idStudent=(isset($_POST['idStudent'])?$_POST['idStudent']:"");
    $stm=$conexion->prepare("INSERT INTO academicdiploma (title,date,type,idStudent)
    values(:title,:date,:type,:idStudent)");
    $stm->bindParam(":title",$paymenyAmount);
    $stm->bindParam(":date",$date);
    $stm->bindParam(":type",$type);
    $stm->bindParam(":idStudent",$idStudent);
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
      <form action="" method="post">
      <div class="modal-body">
        <label for="">Title</label>
        <input type="text" class="form-control" name="title" value="" placeholder="Enter the Title">
        <label for="">date</label>
        <input type="date" class="form-control" name="date" value="" placeholder="Enter the date">
        <label for="">Type</label>
        <input type="text" class="form-control" name="type" value="" placeholder="Enter the Type"> 
        <select class="form-control" name="idStudent"placeholder="Select the Student">
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
      <button type="button" class="btn btn-outline-danger" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-outline-info">Aggregate data</button>
      </div>
      </form>
    </div>
  </div>
</div>