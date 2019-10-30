<?php include 'inc/header.php'; ?>
<?php
    if (isset($_GET['proid'])) {
        $id = preg_replace('/[^-a-zA-z0-9_]/', '', $_GET['proid']);
    }
    if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['date'])) {
    	$id = $_GET['proid'];
    	$date = $_POST['date'];
    	$temp = $pd->getScheduleByDate($date,$id);

    }

    if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['subtime'])){
    	$id = $_GET['proid'];
    	$date = $_POST['date1'];
    	$time = $_POST['time'];
    	$addtocart = $ct->addingToCart($id,$date,$time);
    }
    
    
?>
<?php
	$cmrId = Session::get("cmrId");
    if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['compare'])) {
    	$productId = $_POST['productId'];
        $insertCom = $pd->insertCompareData($productId,$cmrId);
    }
?>
<?php
    if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['wlist'])) {
        $saveWlist = $pd->saveWishListData($id,$cmrId);
    }
?>
<style>
	.mubutton{
		width: 100px;
		float: left;
		margin-right: 50px;
	}
</style>
 <div class="main">
    <div class="content">
    	<div class="section group">
				<div class="cont-desc span_1_of_2">	
					<?php
						$getpd = $pd->getSingleProduct($id);
						if ($getpd) {
							while ($result = $getpd->fetch_assoc()) {

					?>			
					<div class="grid images_3_of_2">
						<img src="admin/<?php echo $result['image']; ?>" alt="" />
					</div>
					<div class="desc span_3_of_2">
						<h2><?php echo $result['productName']; ?></h2>					
						<div class="price">
							<p>Price: <span>$<?php echo $result['price']; ?></span></p>
							<p>Category: <span><?php echo $result['catName']; ?></span></p>
							<p>Brand:<span><?php echo $result['brandName']; ?></span></p>
						</div>
						<div class="add-cart">
							
								
								<form action="" method="post" name="chooseDate">
									<input type="date" name="date" value="<?php if(isset($date)) echo $date; ?>" onchange="chooseDate.submit()" >
								</form>	
								<?php
								if(isset($date)) { ?>
								<form action="" method="post">
									<select name="time">
										<option value="" disabled selected>
											Select Any Time
										</option>
										<option value="10:00 AM - 11:00 AM" <?php
											if ($temp != false) {
												while ($result = $temp->fetch_assoc()) {
													if ($result['time'] == '10:00 AM - 11:00 AM') {
														echo "disabled";
														break;
													}else{
														echo "selected";
													}
												}
											}
										?>
										>10:00 AM - 11:00 AM</option>
										<option value="11:00 AM - 12:00 AM" <?php
											if ($temp != false) {
												while ($result = $temp->fetch_assoc()) {
													if ($result['time'] == '11:00 AM - 12:00 AM') {
														echo "disabled";
														break;
													}else{
														echo "selected";
													}
												}
											}
										?>
										>11:00 AM - 12:00 AM</option>

									</select>
									<input type="hidden" class="buyfield" name="date1" value="<?php echo $date; ?>"/>
									<input type="submit" class="buysubmit" name="subtime" value="Confirm"/>
								</form>
							<?php } ?>	
								
								
										
						</div>
						<span style="color:red; font-size: 18px;">
							<?php
								if (isset($addtocart)) {
									echo $addtocart;
								}

							?>
						</span>
							<?php
								if (isset($insertCom)) {
									echo $insertCom;
								}
								if (isset($saveWlist)) {
									echo $saveWlist;
								}
							?>
							<?php
								$login = Session::get("cuslogin");
								if ($login == true) { 
							?>
						<div class="add-cart">
							<div class="mubutton">
							<form action="" method="post">
								<input type="hidden" class="buyfield" name="productId" value="<?php echo $result['productId']; ?>"/>
								<input type="submit" class="buysubmit" name="compare" value="Add to compare"/>
							</form>	
							</div>	
							<div class="mubutton">
							<form action="" method="post">
								
								<input type="submit" class="buysubmit" name="wlist" value="Save to List"/>
							</form>	
							</div>	
						</div>
						<?php }?>
					</div>
					<div class="product-desc">
						<h2>Product Details</h2>
						<p><?php echo $result['body']; ?></p>
				    </div>
					<?php } } ?>	
				</div>
				<div class="rightsidebar span_3_of_1">
					<h2>CATEGORIES</h2>
					<ul>
						<?php
							$getCat = $cat->getAllCat();
							if ($getCat) {
								while ($result = $getCat->fetch_assoc()) {

						?>
				      	<li><a href="productbycat.php?catId=<?php echo $result['catId']; ?>"><?php echo $result['catName']; ?></a></li>
				      	<?php } } ?>
    				</ul>
    	
 				</div>
 		</div>
 	</div>
	<?php include 'inc/footer.php'; ?>

