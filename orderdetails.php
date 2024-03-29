<?php include 'inc/header.php'; ?>
<?php
    $login = Session::get("cuslogin");
    if ($login == false) {
        header("Location:login.php");
    }
?>
<?php
    if (isset($_GET['customerId'])) {
        $id = $_GET['customerId'];
        $time = $_GET['time'];
        $price = $_GET['price'];
        $confirm = $ct->productShiftConfirm($id, $time, $price);
        
    }
?>

<?php
    if (isset($_GET['CancelCustomerId'])) {
        $id = $_GET['CancelCustomerId'];
        $time = $_GET['time'];
        $price = $_GET['price'];
        $cancelorder = $ct->orderCancelRequest($id, $time, $price);
        
    }
?>

<style>
    .tblone tr td{
        text-align: justify;
    }
</style>

 <div class="main">
    <div class="content">
    	<div class="section group">
    		<div class="order">
    			<h2>Your Ordered Details</h2>
                <table class="tblone">
                    <tr>
                        <th>No</th>
                        <th>Product Name</th>
                        <th>Image</th>
                        <th>Date</th>
                        <th>Time</th>
                        <th>Total Price</th>
                        <th>Time of Order</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                    <?php
                        $cmrId = Session::get("cmrId");
                        $getOrder = $ct->getOrderedProduct($cmrId);
                        if ($getOrder) {
                            $i = 0;
                            while ($result = $getOrder->fetch_assoc()) {
                                $i++;

                    ?>
                    <tr>
                        <td><?php echo $i; ?></td>
                        <td><?php echo $result['productName']; ?></td>
                        <td><img src="admin/<?php echo $result['image']; ?>" alt=""/></td>
                        <td><?php echo $result['date']; ?></td>
                        <td><?php echo $result['time']; ?></td>
                        <td>$ <?php echo $result['price']; ?></td>
                        <td><?php echo $fm->formatDate($result['timeOfOrder']); ?></td>
                        <td><?php 
                            if ($result['status'] == '0') {
                                echo "Pending";
                            }elseif ($result['status'] == '1') {
                               echo "Shifted";
                            }else{
                                echo "Ok";
                            }

                        ?></td>
                        <?php
                            if ($result['status'] == '1') { ?>
                                <td><a href="?customerId=<?php echo $cmrId; ?>& price=<?php echo $result['price']; ?>& time=<?php echo $result['date']; ?>">Confirm</a></td>
                            <?php }elseif ($result['status'] == '2') {
                                if (isset($_GET['customerId'])) {
                                    $id = $_GET['customerId'];
                                    $upCusStatus = $ct->getproductconfirmed($id);
                                }
                            ?>
                                <td><a href="?CancelCustomerId=<?php echo $cmrId; ?>& price=<?php echo $result['price']; ?>& time=<?php echo $result['date']; ?>"><button>Cancle Booking</button></a></td>
                           <?php 
                               
                            }elseif ($result['status'] == '0') { ?>
                               <td>N/A</td>
                           <?php }else { ?>
                                <td><button>requested to cancel</button></td>
                           <?php } ?>

                        
                    </tr>
                    <?php } } ?>
                </table>
    		</div>
    	</div>
       	<div class="clear"></div>
    </div>
 </div>
<?php include 'inc/footer.php'; ?>

