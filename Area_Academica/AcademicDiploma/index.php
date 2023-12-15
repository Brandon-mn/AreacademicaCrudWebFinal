<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.2/font/bootstrap-icons.css" integrity="sha384-b6lVK+yci+bfDmaY1u0zE8YYJt0TZxLEAFyYSLHId4xoVvsrQu3INevFKo+Xir8e" crossorigin="anonymous">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.1/css/all.min.css">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
<?php include("../conexion.php");
$stm = $conexion->prepare("SELECT * FROM academicdiploma INNER JOIN student ON academicdiploma.idstudent = student.idstudent
where academicdiploma.status = 1");
$stm->execute();
$AcademicDiploma=$stm->fetchAll(PDO::FETCH_ASSOC);
?>
<?php include("../header.php");?>
<div class="table-responsive">
    <table class="table">
        <thead class="table table-dark">
            <tr>
                <th scope="col">Title</th>
                <th scope="col">Date </th>
                <th scope="col">Type </th>
                <th scope="col">Name Student </th>
                <th scope="col">Last Name Student </th>
                <th scope="col">Actions </th>

            </tr>
        </thead>
        <tbody>
        <?php foreach($AcademicDiploma as $academicdiploma){?>
        <tr class="">
            <td> <?php echo $academicdiploma['title']; ?></td>
            <td> <?php echo $academicdiploma['date']; ?></td>
            <td> <?php echo $academicdiploma['type']; ?></td>
            <td> <?php echo $academicdiploma['name']; ?></td>
            <td> <?php echo $academicdiploma['lastName']; ?></td>

            <td> 
            <a href="edit.php?idAcademicDiploma=<?php echo $academicdiploma['idAcademicDiploma']; ?>"class="btn btn-warning"><i class="bi bi-pencil"></i></a>
           <a href="delete.php?idAcademicDiploma=<?php echo $academicdiploma['idAcademicDiploma']; ?>"onclick="return confirm('Do you really want to delete?')" class="btn btn-danger"><i class="bi bi-trash3-fill"></i></a>
              </td>
    </tr>        
            <?php } ?>  
        </tbody>
    </table>
    </div>
    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#crear">Add</button>
<a href="../Menu/index.html"><input type="button" class="btn btn-outline-dark" value="Return"></a>
<?php include("create.php");?>
<?php include("../foter.php");?>
