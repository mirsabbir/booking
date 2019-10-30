<?php include 'inc/header.php'; ?>
 <div class="main">
    <div class="content">
    	<?php
			$getFBpd = $pd->getFirstBrandProduct();
			if ($getFBpd) { 
		?>
				
    	<div class="content_top">
    		<div class="heading">
    		<h3>Conference Room</h3>
    		</div>
    		<div class="clear"></div>
    	</div>
    	
	    <div class="section group">
	    <?php while ($result = $getFBpd->fetch_assoc()) {?>
			<div class="grid_1_of_4 images_1_of_4">
				 <a href="details.php?proid=<?php echo $result['productId']; ?>"><img src="admin/<?php echo $result['image']; ?>" alt="" /></a>
				 <h2><?php echo $result['productName']; ?></h2>
				<p><?php echo $fm->textShorten($result['body'],60); ?></p>
				<p><span class="price">$<?php echo $result['price']; ?></span></p>
			     <div class="button"><span><a href="details.php?proid=<?php echo $result['productId']; ?>" class="details">Details</a></span></div>
			</div>
		<?php } } ?>
		</div>
		
		<?php
			$getSBpd = $pd->getSecondBrandProduct();
			if ($getSBpd) {
		?>
				
		<div class="content_bottom">
    		<div class="heading">
    		<h3>Computer Lab</h3>
    		</div>
    		<div class="clear"></div>
    	</div>
    	
		<div class="section group">
		<?php while ($result = $getSBpd->fetch_assoc()) { ?>
			<div class="grid_1_of_4 images_1_of_4">
				 <a href="details.php?proid=<?php echo $result['productId']; ?>"><img src="admin/<?php echo $result['image']; ?>" alt="" /></a>
				 <h2><?php echo $result['productName']; ?></h2>
				<p><?php echo $fm->textShorten($result['body'],60); ?></p>
				<p><span class="price">$<?php echo $result['price']; ?></span></p>
			     <div class="button"><span><a href="details.php?proid=<?php echo $result['productId']; ?>" class="details">Details</a></span></div>
			</div>
		<?php } } ?>
		</div>
		
		<?php
			$getTBpd = $pd->getThirdBrandProduct();
			if ($getTBpd) {
		?>
				
		<div class="content_bottom">
    		<div class="heading">
    		<h3>Class Room</h3>
    		</div>
    		<div class="clear"></div>
    	</div>
    	
		<div class="section group">
		<?php while ($result = $getTBpd->fetch_assoc()) { ?>
			<div class="grid_1_of_4 images_1_of_4">
				 <a href="details.php?proid=<?php echo $result['productId']; ?>"><img src="admin/<?php echo $result['image']; ?>" alt="" /></a>
				 <h2><?php echo $result['productName']; ?></h2>
				<p><?php echo $fm->textShorten($result['body'],60); ?></p>
				<p><span class="price">$<?php echo $result['price']; ?></span></p>
			     <div class="button"><span><a href="details.php?proid=<?php echo $result['productId']; ?>" class="details">Details</a></span></div>
			</div>
		<?php } } ?>
		</div>
		
		<?php
			$getNpd = $pd->getNewProduct();
			if ($getNpd) {
		?>
				
		<div class="content_bottom">
    		<div class="heading">
    		<h3>Latest Resources</h3>
    		</div>
    		<div class="clear"></div>
    	</div>
    	
		<div class="section group">
		<?php while ($result = $getNpd->fetch_assoc()) { ?>
			<div class="grid_1_of_4 images_1_of_4">
				 <a href="details.php?proid=<?php echo $result['productId']; ?>"><img src="admin/<?php echo $result['image']; ?>" alt="" /></a>
				 <h2><?php echo $result['productName']; ?></h2>
				<p><?php echo $fm->textShorten($result['body'],60); ?></p>
				<p><span class="price">$<?php echo $result['price']; ?></span></p>
			     <div class="button"><span><a href="details.php?proid=<?php echo $result['productId']; ?>" class="details">Details</a></span></div>
			</div>
		<?php } } ?>
		</div>
		
    </div>
 </div>
<?php include 'inc/footer.php'; ?>