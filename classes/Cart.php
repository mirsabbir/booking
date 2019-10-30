<?php 
	$filepath = realpath(dirname(__FILE__));
	include_once ($filepath.'/../lib/database.php');
	include_once ($filepath.'/../helpers/Format.php');
 ?>

<?php
class Cart{
	private $db;
	private $fm;

	public function __construct(){
		$this->db = new Database();
		$this->fm = new Format();
	}

	public function addingToCart($id,$date,$time){
		$productId = $this->fm->validation($id);
		$productId = mysqli_real_escape_string($this->db->link,$id);

		$date = $this->fm->validation($date);
		$date = mysqli_real_escape_string($this->db->link,$date);

		$time = $this->fm->validation($time);
		$time = mysqli_real_escape_string($this->db->link,$time);
		$sId = session_id();

		$squery = "SELECT * FROM tbl_product WHERE productId = '$productId'";
		$result = $this->db->select($squery)->fetch_assoc();

		//to see what we got
		//echo "<pre>";
		// print_r($time);
		// print_r($date);
		// print_r($result);
		// echo "</pre>";

		$productName = $result['productName'];
		$price = $result['price'];
		$image = $result['image'];

		$chquery = "SELECT * FROM tbl_cart WHERE productId = '$productId' AND sId = '$sId' AND date = '$date' AND time = '$time'";
		$getPro = $this->db->select($chquery);
		if ($getPro) {
			$msg = "<span class='error'>Product already added</span>";
			return $msg;
			die();
		} else{

		$query = "INSERT INTO tbl_cart(sId, productId, productName, date, time, price, image) VALUES('$sId','$productId','$productName','$date','$time','$price','$image')";

		    	$inserted_row = $this->db->insert($query);
		 		if ($inserted_row) {
		 			header("Location:cart.php");
		 		} else {
		 			header("Location:404.php");
		 		}
		 }
	}

	

	public function getCartProduct(){
		$sId = session_id();
		$query = "SELECT * FROM tbl_cart WHERE sId ='$sId'";
			$result = $this->db->select($query);
			return $result;
	}

	public function updateCartQuantity($cartId, $quantity){
		$cartId = $this->fm->validation($cartId);
		$cartId = mysqli_real_escape_string($this->db->link,$cartId);

		$quantity = $this->fm->validation($quantity);
		$quantity = mysqli_real_escape_string($this->db->link,$quantity);

		$query = "UPDATE tbl_cart
		 			SET
		 			quantity = '$quantity'
		 			WHERE cartId = '$cartId'";
		 		$updated_row = $this->db->update($query);
		 		if ($updated_row) {
		 			header("Location:cart.php");
		 		} else {
		 			$msg = "<span class='error'>Quantity not updated</span>";
		 			return $msg;
		 		}
	}

	public function delProductByCart($delId){
		$delId = $this->fm->validation($delId);
		$delId = mysqli_real_escape_string($this->db->link,$delId);
		$query = "DELETE FROM tbl_cart WHERE cartId = '$delId'";
			$deldata = $this->db->delete($query);
			if ($deldata) {
				header("Location:cart.php");
			} else {
				$msg = "<span class='error'>Product not deleted</span>";
		 			return $msg;
			}
	}

	public function checkCartTable(){
		$sId = session_id();
		$query = "SELECT * FROM tbl_cart WHERE sId ='$sId'";
		$result = $this->db->select($query);
		return $result;
	}

	public function delCustomerCart(){
		$sId = session_id();
		$query = "DELETE FROM tbl_cart WHERE sId ='$sId'";
		$this->db->delete($query);
	}

	public function orderProduct($cmrId){
		$sId = session_id();
		$query = "SELECT * FROM tbl_cart WHERE sId ='$sId'";
		$getPro = $this->db->select($query);
		if ($getPro) {
			while ($result = $getPro->fetch_assoc()) {
				$productId = $result['productId'];
				$productName = $result['productName'];
				$date = $result['date'];
				$time = $result['time'];
				$price = $result['price'];
				$image = $result['image'];

				$query = "INSERT INTO tbl_order(cmrId, productId, productName, date, time, price, image) VALUES('$cmrId','$productId','$productName','$date','$time','$price','$image')";

		    	$inserted_row = $this->db->insert($query);
			}
		}
	}

	public function PayableAmount($cmrId){
		$query = "SELECT price FROM tbl_order WHERE cmrId ='$cmrId' AND timeOfOrder = now()";
		$result = $this->db->select($query);
		return $result;
	}

	public function getOrderedProduct($cmrId){
		$query = "SELECT * FROM tbl_order WHERE cmrId ='$cmrId' ORDER BY timeOfOrder DESC ";
		$result = $this->db->select($query);
		return $result;
	}

	public function checkOrder($cmrId){
		$query = "SELECT * FROM tbl_order WHERE cmrId ='$cmrId'";
		$result = $this->db->select($query);
		return $result;
	}
	public function gteAllOrderProduct(){
		$query = "SELECT * FROM tbl_order ORDER BY timeOfOrder DESC";
		$result = $this->db->select($query);
		return $result;
	}

	public function productShifted($id, $time, $price){
		$id = $this->fm->validation($id);
		$id = mysqli_real_escape_string($this->db->link,$id);

		$time = $this->fm->validation($time);
		$time = mysqli_real_escape_string($this->db->link,$time);

		$price = $this->fm->validation($price);
		$price = mysqli_real_escape_string($this->db->link,$price);

		$query = "UPDATE tbl_order
		 			SET
		 			status = '1'
		 			WHERE cmrId = '$id' AND timeOfOrder='$time' AND price='$price'";
		 		$updated_row = $this->db->update($query);
		 		if ($updated_row) {
		 			$msg = "<span class='success'>Updated Successfully</span>";
		 				return $msg;
		 		} else {
		 			$msg = "<span class='error'>Not Updated</span>";
		 			return $msg;
		 		}
	}

	public function delProductShifted($id, $time, $price){
		$id = $this->fm->validation($id);
		$id = mysqli_real_escape_string($this->db->link,$id);

		$time = $this->fm->validation($time);
		$time = mysqli_real_escape_string($this->db->link,$time);

		$price = $this->fm->validation($price);
		$price = mysqli_real_escape_string($this->db->link,$price);
		$query = "DELETE FROM tbl_order WHERE cmrId = '$id' AND timeOfOrder='$time' AND price='$price'";
			$deldata = $this->db->delete($query);
			if ($deldata) {
				$msg = "<span class='success'>Data Deleted Successfully</span>";
		 				return $msg;
			} else {
				$msg = "<span class='error'>Data not deleted</span>";
		 			return $msg;
			}
	}

	public function productShiftConfirm($id, $time, $price){
		$id = $this->fm->validation($id);
		$id = mysqli_real_escape_string($this->db->link,$id);

		$time = $this->fm->validation($time);
		$time = mysqli_real_escape_string($this->db->link,$time);

		$price = $this->fm->validation($price);
		$price = mysqli_real_escape_string($this->db->link,$price);
		$query = "UPDATE tbl_order
		 			SET
		 			status = '2'
		 			WHERE cmrId = '$id' AND date='$time' AND price='$price'";
		 		$updated_row = $this->db->update($query);
		 		if ($updated_row) {
		 			$msg = "<span class='success'>Updated Successfully</span>";
		 				return $msg;
		 		} else {
		 			$msg = "<span class='error'>Not Updated</span>";
		 			return $msg;
		 		}
	}

	public function orderCancelRequest($id, $time, $price){
		$id = $this->fm->validation($id);
		$id = mysqli_real_escape_string($this->db->link,$id);

		$time = $this->fm->validation($time);
		$time = mysqli_real_escape_string($this->db->link,$time);

		$price = $this->fm->validation($price);
		$price = mysqli_real_escape_string($this->db->link,$price);
		$query = "UPDATE tbl_order
		 			SET
		 			status = '3'
		 			WHERE cmrId = '$id' AND date='$time' AND price='$price'";
		 		$updated_row = $this->db->update($query);
		 		if ($updated_row) {
		 			$msg = "<span class='success'>Updated Successfully</span>";
		 				return $msg;
		 		} else {
		 			$msg = "<span class='error'>Not Updated</span>";
		 			return $msg;
		 		}
	}

	public function getproductconfirmed($id){
		$id = $this->fm->validation($id);
		$id = mysqli_real_escape_string($this->db->link,$id);

		$query = "SELECT status FROM tbl_order WHERE status = '2' AND cmrId = '$id'";
		$counted_row = $this->db->select($query);

		if ($counted_row->num_rows <= 2) {
			$sql = "UPDATE tbl_customer
				SET
				custype = 'user'
				WHERE id = '$id'";
			$updated_row = $this->db->update($sql);
			return $updated_row;
		}elseif($counted_row->num_rows > 2){
			$sql = "UPDATE tbl_customer
				SET
				custype = 'silver'
				WHERE id = '$id'";
			$updated_row = $this->db->update($sql);
			return $updated_row;
		}
		
	}

	

	
}
?>