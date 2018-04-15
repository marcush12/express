<?php include 'header.php'; ?>
<div class='container-fluid text-center'>
    <div class="row text-center">
        <div class="col-sm-2">
            <ul id="side_menu">
                <?php
                    $con = new mysqli("localhost", 'root', '', 'express');
                    $st = $con->prepare("SELECT distinct category FROM items");
                    $st->execute();
                    $rs = $st->get_result();
                    while ($row = $rs->fetch_assoc()) {
                        echo '<li><a href="?cat='.$row["category"].'">'.$row["category"].'</a></li>';
                    }
                ?>
            </ul>
        </div>
        <?php
        if (!isset($_GET["cat"])) {
            $cat = "Pizza";
        } else {
            $cat = $_GET["cat"];
        }
            $con = new mysqli("localhost", 'root', '', 'express');
            $st = $con->prepare("SELECT * FROM items where category=?");
            $st->bind_param("s", $cat);
            $st->execute();
            $rs = $st->get_result();
            while ($row = $rs->fetch_assoc()) {
                echo '<div class="col-sm-1">
                        <div class="thumbnail">
                            <img src="images/'.$row["photo"].'" width="400" height="300" alt="">
                            <p><strong>'.$row["name"].'</strong></p>
                            <p>R$ '.$row["price"].'</p>
                            <a href="add_item.php?id='.$row["id"].'">Add</a>
                        </div>
                    </div>';
            }
        ?>

    </div>

</div>
<?php include 'footer.php'; ?>
