<?php
class ModelOpentshirtsPricePrinting extends Model {
	
	public function getMaxColors()
	{
		$sql = "SELECT MAX(num_colors) as maximum FROM ".DB_PREFIX."printing_quantity_price  ";
		$query = $this->db->query($sql);
		if($query->row["maximum"]=="")
		{
			return false;
		}else
		{
			return $query->row["maximum"];
		}

	}
	
	/**
	* return an array where key=number_of_colors, value=price
	*/
	public function getPrintingPricesFromQuantity($quantity)
	{
		$sql  = " SELECT quantity_index FROM ".DB_PREFIX."printing_quantity  ";
		$sql .= " WHERE quantity<=".(int)$quantity." ";
		$sql .= " ORDER BY quantity DESC LIMIT 1 ";
		
		$query = $this->db->query($sql);
		if($query->num_rows==0) {
			return false;
		} else {

			$quantity_index = $query->row["quantity_index"]; //column to take prices from
			
			$sql  = " SELECT price, num_colors FROM  ".DB_PREFIX."printing_quantity_price "; 
			$sql .= " WHERE quantity_index=".(int)$quantity_index." ";
			$query = $this->db->query($sql);
			
			if($query->num_rows==0) {
				return false;
			} else {
				$prices = array();
				foreach ($query->rows as $result) {
					$prices[$result["num_colors"]] = $result["price"];
				}
				return $prices;
			}
		}
	}

	/**
	* returns the unit price for a number of designs $quantity with $num_colors colors
	*/
	public function getUnitPrice($num_colors,$quantity)
	{
		if($num_colors==0)
		{
			return 0;
		}
		$prices = $this->getPriceArrayFromQuantity($quantity);
		return $prices[$num_colors];
	}

}
?>