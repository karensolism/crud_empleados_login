<?php 
    session_start();
    include "authentication.php";
    include "config.php";

    $id = $_GET['id'];
    $fsql = "SELECT * FROM users WHERE id='$id'";
    $fquery = mysqli_query($link,$fsql);
    $result = mysqli_fetch_assoc($fquery);

    if(isset($_POST['submit'])){
        $name = $_POST['name'];
        $email = $_POST['email'];
        $photo = $_FILES['photo'];
        $fecha = $_POST['fecha'];
        $photo_name = $photo['name'];
        $photo_temp = $photo['tmp_name'];

        move_uploaded_file($photo_temp,'uploads/'.$photo_name);
        
        if(empty($photo_name)){
            $photo_name_old = $result['image'];
            $usql = "UPDATE users SET name='$name',email='$email',image='$photo_name_old',fecha='$fecha' WHERE id='$id'";
        }else{
            $usql = "UPDATE users SET name='$name',sex='$sex',phone='$phone',email='$email',image='$photo_name', fecha='$fecha' WHERE id='$id'";
            if($result['image'] != 'avatar.png'){
                $image_path = 'uploads/'.$result['image'];
                unlink($image_path);
            }
        }
        $uquery = mysqli_query($link,$usql);
        if($uquery){
            $log = getHostByName($_SERVER['HTTP_HOST']).' - '.date("F j, Y, g:i a").PHP_EOL.
            "Record updated_".time().PHP_EOL.
            "---------------------------------------".PHP_EOL;
            file_put_contents('logs/log_'.date("j-n-Y").'.log', $log, FILE_APPEND);
            
            $_SESSION['success'] = "Usuario actualizado satisfactoriamente";
            header('location:index.php');
        }else{
            $_SESSION['error'] = "Ha ocurrido un error, usuario no actualizado";
            header('location:index.php');
        }
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar usuario</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</head>
<body>
    <div class="container">
        <h1 class="text-center">Editar empleado existente</h1>
        <form action="" method="POST" enctype="multipart/form-data">
            <div class="form-group">
                <label for="name"><strong>Nombre</strong></label>
                <input type="text" class="form-control" placeholder="Ingrese su nombre completo" name="name" value="<?php echo $result['name'] ?>" required>
            </div>
           
          
            <div class="form-group">
                <label for="email"><strong>Correo</strong></label>
                <input type="email" class="form-control" placeholder="Ingrese su correo" name="email" value="<?php echo $result['email'] ?>" required>
            </div>
            <div class="form-group">
                <label for="photo"><strong>Foto</strong></label><br>
                <input type="file" name="photo">
            </div>
            <div class="form-group">
                <label for="fecha"><strong>Fecha de ingreso</strong></label>
                <input type="text" class="form-control" placeholder="Ingrese la fecha de ingreso" name="fecha" value="<?php echo $result['fecha'] ?>" required>
            </div>
            <div class="text-center mt-5">
                <button type="submit" class="btn btn-primary" name="submit">Actualizar</button>
                <a href="index.php" class="btn btn-secondary">Cancelar</a>
            </div>
        </form>
    </div>
</body>
</html>