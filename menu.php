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
    <div class="col-sm-6">
        <table width='100%' border="1">
            <tr>
                <th>Nome</th>
                <th>Preço</th>
                <th>Quantidade</th>
                <th>Subtotal</th>
                <th>Remover</th>
            </tr>
            <?php
            $con = new mysqli("localhost", 'root', '', 'express');
            $st=$con->prepare("SELECT items.id,qty,name,price from items inner join temp_order on items.id=temp_order.itemid where email=?");
            $st->bind_param("s", $_SESSION["user"]);
            $st->execute();
            $rs = $st->get_result();
            $total = 0;
            while ($row = $rs->fetch_assoc()) {
                echo '<tr>';
                echo '<td>'.$row["name"].'</td>';
                echo '<td>'.$row["price"].'</td>';
                echo '<td>'.$row["qty"].'</td>';
                echo '<td>'.$row["price"]*$row["qty"].'</td>';
                echo '<td><a href=delete_item.php?id='.$row["id"].'><img src=images/delete.png height=24px width=24px</a></td>';
                echo '</tr>';
                $total = $total + ($row["price"]*$row["qty"]);
            }
            ?>
        </table>
        <?php
        echo '<h3>Total é de R$'.$total.'</h3>'
        ?>
        <form action="add_order.php" method='post'>
            <input type="submit" class="btn btn-primary" value='Peça agora!'>
        </form>
    </div>

    </div>

</div>
<?php include 'footer.php'; ?>
