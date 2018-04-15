<?php include 'header.php'; ?>
<center>
    <form action="login.php" class="form-group" method='post'>
        <input type="email" class='form-control' style='width:40%' name='email' placeholder="E-Mail">
        <input type="password" class='form-control' style='width:40%' name='password' placeholder="password">
        <input type="submit" name='sub' class='btn btn-primary' value="Login">
    </form>
    <br>
    <a href="signup.php">Novo usuário</a>
</center>
<?php
    if (isset($_POST["sub"])) {
        $con = new mysqli('localhost', 'root', '', 'express');
        $st_check=$con->prepare("SELECT * FROM users where email=? and password=?");
        $st_check->bind_param("ss", $_POST['email'], $_POST['password']);
        $st_check->execute();
        $result = $st_check->get_result();
        if ($result->num_rows==0) {
            echo "<script> alert('Login falhou...');</script>";
        } else {
            $_SESSION['user'] = $_POST['email'];//colocmos o email na session
            echo "<script>window.location='menu.php';</script>";
        }
    }
?>
<?php include 'footer.php'; ?>
