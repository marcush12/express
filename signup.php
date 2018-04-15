<?php include 'header.php'; ?>
<center>
    <form action="signup.php" class="form-group" method='post'>
        <input type="email" class='form-control' style='width:40%' name='email' placeholder="E-Mail required"><br>
        <input type="password" class='form-control' style='width:40%' name='password' placeholder="password" required><br>
        <input type="password" class='form-control' style='width:40%' name='confirm' placeholder="confirm" required><br>
        <input type="text" class='form-control' style='width:40%' name='name' placeholder="name" required><br>
        <input type="text" class='form-control' style='width:40%' name='mobile' placeholder="mobile"><br>
        <input type="text" class='form-control' style='width:40%' name='address' placeholder="address"><br>
        <input type="submit" name='sub' class='btn btn-primary' value="Sign Up">
    </form>
</center>
<?php
    if (isset($_POST['sub'])) {
        if ($_POST['password']==$_POST['confirm']) {
            $con = new mysqli('localhost', 'root', '', 'express');
            $st_check=$con->prepare("SELECT * FROM users where email=?");
            $st_check->bind_param("s", $_POST['email']);
            $st_check->execute();
            $result = $st_check->get_result();
            if ($result->num_rows>0) {
                echo "<script> alert('Esse email já existe.');</script>";
            } else {
                $st=$con->prepare("INSERT INTO users(email, password, name, mobile, address) values(?, ?, ?, ?, ?)");
                $st->bind_param("sssss", $_POST['email'], $_POST['password'], $_POST['name'], $_POST['mobile'], $_POST['address']);//sssss 5 strings
                $st->execute();
                $_SESSION['user'] = $_POST['email'];//colocmos o email na session
                echo "<script>window.location='menu.php';</script>";
            }
        }  else {
                echo "<script> alert('Senhas não são iguais.');</script>";

        }
    }
?>

<?php include 'footer.php'; ?>

