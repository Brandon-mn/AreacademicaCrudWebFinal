<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">

<?php if ($_POST) {
    $date=(isset($_POST['date'])?$_POST['date']:"");
    $nameAcademicAward=(isset($_POST['nameAcademicAward'])?$_POST['nameAcademicAward']:"");
    $description=(isset($_POST['description'])?$_POST['description']:"");
    $recipients=(isset($_POST['recipients'])?$_POST['recipients']:"");
    $idStudent=(isset($_POST['idStudent'])?$_POST['idStudent']:"");
  
    $stm=$conexion->prepare("INSERT INTO academicaward (date,nameAcademicAward,description,recipients,idStudent)
    values(:date,:nameAcademicAward,:description,:recipients,:idStudent)");
    $stm->bindParam(":date",$date);
    $stm->bindParam(":nameAcademicAward",$nameAcademicAward);
    $stm->bindParam(":description",$description);
    $stm->bindParam(":recipients",$recipients);
    $stm->bindParam(":idStudent",$idStudent);
    $stm->execute();
    header("location:index.php");
  }
  ?>
<div class="modal fade" id="crear" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Add Academic Award</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form action="" method="post">
        <label for="">Date</label>
        <input type="date" class="form-control" name="date" value=""placeholder="Enter Date">
        <label for="">Name Academic Award</label>
        <input type="text" class="form-control" name="nameAcademicAward" value=""placeholder="Enter the Name Academic Award">
        <label for="">Description</label>
        <input type="text" class="form-control" name="description" value=""placeholder="Enter the Description">
        <label for="">Recipients</label>
        <input type="text" class="form-control" name="recipients" value=""placeholder="Enter the Recipients">
        <option selected disabled> --Select the Student--</option>
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