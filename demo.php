<!-- after line 16 -->
<?php
    if (isset($_GET['cstmrId']) && null!= $_GET['status']) {
        $id = $_GET['cstmrId'];
        $status = $_GET['status'];
        $upCusStatus = $ct->getproductconfirmed($id,$status);
    }
?>


<!-- after line 79 -->
header("?cstmrId=<?php echo $cmrId; ?>& status=2");


<!-- after line 213 in Cart.php -->
public function getproductconfirmed($id,$status){
		$id = $this->fm->validation($id);
		$id = mysqli_real_escape_string($this->db->link,$id);

		$status = $this->fm->validation($status);
		$status = mysqli_real_escape_string($this->db->link,$status);

		$query = "SELECT COUNT(status) FROM tbl_order WHERE status = '2' AND cmrId = '$id'";
		$counted_row = $this->db->select($query);
		if ($counted_row <= 2) {
			$sql = "UPDATE tbl_customer
				SET
				custype = 'user'
				WHERE id = '$id'";
			$updated_row = $this->db->update($sql);
			return $updated_row;
		}else{
			$sql = "UPDATE tbl_customer
				SET
				custype = 'silver'
				WHERE id = '$id'";
			$updated_row = $this->db->update($sql);
			return $updated_row;
		}
	}