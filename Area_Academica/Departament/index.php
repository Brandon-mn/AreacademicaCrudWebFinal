<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.2/font/bootstrap-icons.css" integrity="sha384-b6lVK+yci+bfDmaY1u0zE8YYJt0TZxLEAFyYSLHId4xoVvsrQu3INevFKo+Xir8e" crossorigin="anonymous">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.1/css/all.min.css">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
<?php include("../conexion.php");
$stm=$conexion->prepare("SELECT * FROM department where status = 1");
$stm->execute();
$Department=$stm->fetchAll(PDO::FETCH_ASSOC);
?>
<?php include("../header.php");?>
<div class="table-responsive">
    <table class="table">
        <thead class="table table-dark">
            <tr>
                <th scope="col">Name</th>
                <th scope="col">Description </th>
                <th scope="col">Director </th>
                <th scope="col">Founding Date</th>
                <th scope="col">Phone</th>
                <th scope="col">Email</th>
                <th scope="col">Location</th>
                <th scope="col">Opening Hour</th>
                <th scope="col">Closing Hour</th>
                <th scope="col">ID Employee</th>


            </tr>
        </thead>
        <tbody>
        <?php foreach($Department as $department){?>
        <tr class="">
            <td> <?php echo $department['name']; ?></td>
            <td> <?php echo $department['description']; ?></td>
            <td> <?php echo $department['director']; ?></td>
            <td> <?php echo $department['foundingDate']; ?></td>
            <td> <?php echo $department['phone']; ?></td>
            <td> <?php echo $department['email']; ?></td>
            <td> <?php echo $department['location']; ?></td>
            <td> <?php echo $department['openingHour']; ?></td>
            <td> <?php echo $department['closingHour']; ?></td>
            <td> <?php echo $department['idEmployee']; ?></td>


            <td> 
            <a href="edit.php?idDepartment=<?php echo $department['idDepartment']; ?>"class="btn btn-warning"><i class="bi bi-pencil"></i></a>
           <a href="delete.php?idDepartment=<?php echo $department['idDepartment']; ?>"onclick="return confirm('Do you really want to delete?')" class="btn btn-danger"><i class="bi bi-trash3-fill"></i></a>
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
