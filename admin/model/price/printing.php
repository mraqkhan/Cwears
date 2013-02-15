<?php
class ModelPricePrinting extends Model {
	
	public function savePrice($data) {
		$sql  = "DELETE FROM " . DB_PREFIX . "printing_quantity  ";
		$this->db->query($sql);
		$sql  = "DELETE FROM " . DB_PREFIX . "printing_quantity_price ";
		$this->db->query($sql);
		
		if(isset($data['quantities']) && isset($data['price']))
		{
			foreach($data['quantities'] as $quantity_index => $quantity)
			{
				
				$sql  = "INSERT INTO " . DB_PREFIX . "printing_quantity SET ";
				$sql .= " quantity_index = '" . $quantity_index . "',";
				$sql .= " quantity = '" . $quantity . "' ";
				$this->db->query($sql);
				
				foreach($data['price'] as $num_colors => $price)
				{					
					$sql  = "INSERT INTO " . DB_PREFIX . "printing_quantity_price SET ";
					$sql .= " quantity_index = '" . $quantity_index . "', ";
					$sql .= " num_colors = '" . $num_colors . "', ";
					$sql .= " price = '" . $price[$quantity_index] . "' ";
					$this->db->query($sql);
				}
			}
		}

	}
	public function getPrice() {
		$price = array();
		foreach ($this->getQuantities() as $quantity_index => $quantity) {
			$sql = "SELECT * FROM " . DB_PREFIX . "printing_quantity_price pp, " . DB_PREFIX . "printing_quantity q WHERE q.quantity='".$quantity."' AND q.quantity_index=pp.quantity_index  "; 
			$query = $this->db->query($sql);
			foreach ($query->rows as $result) {
				$price[$result['num_colors']][$quantity_index] = $result['price'];
			}
    	}	
		return $price;
	}
	public function getQuantities() {
		$sql = "SELECT quantity FROM " . DB_PREFIX . "printing_quantity ORDER BY quantity ASC "; 
		$query = $this->db->query($sql);
		
		$array = array();
		foreach ($query->rows as $result) {
			$array[] = $result['quantity'];
    	}	
		return $array;
	}	
	
	public function getMaxColors()
	{
		$sql = "SELECT MAX(num_colors) as maximum FROM " . DB_PREFIX . "printing_quantity_price  ";
		$query = $this->db->query($sql);
		if($query->row["maximum"]=="")
		{
			return false;
		}else
		{
			return $query->row["maximum"];
		}

	}

}
?>