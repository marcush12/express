<?php include 'header.php';  ?>
<div class="container-fluid text-center">
    <?php
    $con = new mysqli("localhost", 'root', '', 'express');
    $st_bill = $con->prepare("SELECT * FROM bill WHERE bill_no = ?");
    $st_bill->bind_param("i", $_GET["bno"]);
    $st_bill->execute();
    $rs_bill = $st_bill->get_result();
    $row_bill = $rs_bill->fetch_assoc();
    echo '<h4>Conta Número: '.$row_bill["bill_no"].'</h4>';
    echo '<h4>Data: '.$row_bill["bill_date"].'</h4>';

                $st_det=$con->prepare("select name,price,itemqty from items inner join bill_det on items.id=bill_det.itemid where bill_no=?");
                $st_det->bind_param("i", $_GET["bno"]);
                $st_det->execute();
                $rs_det=$st_det->get_result();
                echo '<table width="80%" border="1">';
                echo '<tr>';
                echo '<th>Nome</th>';
                echo '<th>Preço</th>';
                echo '<th>Quantidade</th>';
                echo '<th>Subtotal</th>';
                echo '</tr>';
                $total=0;
                while ($row_det=$rs_det->fetch_assoc()) {
                    echo '<tr>';
                    echo '<td>'.$row_det["name"].'</td>';
                    echo '<td>'.$row_det["price"].'</td>';
                    echo '<td>'.$row_det["itemqty"].'</td>';
                    echo '<td>'.$row_det["price"]*$row_det["itemqty"].'</td>';
                    echo '</tr>';
                    $total=$total + ($row_det["price"]*$row_det["itemqty"]);
                }
                echo '</table>';

                echo '<h4>Total de R$'.$total.'</h4>';
                ?>
    <form action="https://www.sandbox.paypal.com/cgi-bin/webscr" method="post">
        <input type="hidden" name="business" value="-facilitator@gmail.com">
        <input type="hidden" name="cmd" value="_xclick"/>
        <input type="hidden" name="item_name" value="Order Express Menu"/>
        <input type="hidden" name="amount" value="<?php echo $total; ?>"/>
        <input type="hidden" name="currency_code" value="BRL">
        <input type="image" name="submit" border="0" src="images/PayPal-Express@2x.png" />
    </form>
</div>
<?php include 'footer.php';  ?>
