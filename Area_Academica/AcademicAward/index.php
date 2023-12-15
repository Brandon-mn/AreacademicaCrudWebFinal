<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.2/font/bootstrap-icons.css" integrity="sha384-b6lVK+yci+bfDmaY1u0zE8YYJt0TZxLEAFyYSLHId4xoVvsrQu3INevFKo+Xir8e" crossorigin="anonymous">

<?php include("../conexion.php");
$stm=$conexion->prepare("SELECT * FROM academicaward INNER JOIN student ON academicaward.idstudent = student.idstudent
 where academicaward.status = 1");
$stm->execute();
$AcademicAwar=$stm->fetchAll(PDO::FETCH_ASSOC);
?>
<?php include("../header.php");?>
<!-- Button trigger modal -->

<div class="table-responsive">
    <table class="table">
        <thead class="table table-dark">
            <tr>
                <th scope="col">Date</th>
                <th scope="col">Name Academic Award  </th>
                <th scope="col">Description</th>
                <th scope="col">Recipients</th>
                <th scope="col">Middle Name</th>
                <th scope="col">Phone Number </th>
                <th scope="col">Email </th>
                <th scope="col">Actions</th>

            </tr>
        </thead>
        <tbody>
        <?php foreach($AcademicAwar as $academicaward){?>
        <tr class="">
            <td> <?php echo $academicaward['date']; ?></td>
            <td> <?php echo $academicaward['nameAcademicAward']; ?></td>
            <td> <?php echo $academicaward['description']; ?></td>
            <td> <?php echo $academicaward['recipients']; ?></td>
            <td> <?php echo $academicaward['middleName']; ?></td>
            <td> <?php echo $academicaward['phoneNumber']; ?></td>
            <td> <?php echo $academicaward['email']; ?></td>


            <td>
            <a href="edit.php?idAcademicAward=<?php echo $academicaward['idAcademicAward']; ?>"class="btn btn-warning"><i class="bi bi-pencil"></i></a>
           <a href="delete.php?idAcademicAward=<?php echo $academicaward['idAcademicAward']; ?>"onclick="return confirm('Do you really want to delete?')" class="btn btn-danger"><i class="bi bi-trash3-fill"></i></a>
             </td>
    </tr>
   
            <?php } ?>  
        </tbody>
    </table>
    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#crear">Add</button>
<a href="../Menu/index.html"><input type="button" class="btn btn-outline-dark" value="Return"></a>


</div>
<?php include("create.php");?>

<?php include("../foter.php");?>
