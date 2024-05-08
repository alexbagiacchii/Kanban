<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <?php
    if(isset($_POST['login'])){
        $user = $_POST['user'];
        $psw = $_POST['psw'];
        //Faccio l'hash della password
        $hashed_psw = password_hash($psw, PASSWORD_DEFAULT);
    }
    
    $conn = mysqli_connect("10.1.0.52", "5i1", "5i1", "5i1_dylanbagiacchi");
    if(!$conn){
        die("Failed to connect to db!");
    }
    $query = "select nomeUtente, password from utente";
    $result = mysqli_query($conn, $query);
    if(mysqli_num_rows($result) > 0) {
        while($row = mysqli_fetch_assoc($result)){
            if($row['nomeUtente'] == $user && $hashed_psw){

            } else {
                echo "failed to log, please retry";
            }
        }
    }

    ?>
</body>
</html>