<?php
class ModelOpentshirtsProductColor extends Model {
	
	public function getColors() {		
		$color_data = array();
		
		$sql="SELECT *  FROM ".DB_PREFIX."printable_product_color pc, ".DB_PREFIX."printable_product_color_flat_color fc WHERE fc.id_product_color=pc.id_product_color AND pc.deleted=0 ORDER BY pc.name ASC "; 
	
		$query = $this->db->query($sql);
		
		foreach ($query->rows as $result) {
			$id_product_color = $result["id_product_color"];
			$color_data[$id_product_color]["id_product_color"] = $id_product_color;
			$color_data[$id_product_color]["name"] = $result["name"];
			$color_data[$id_product_color]["id_product_color_group"] = $result["id_product_color_group"];
			$color_data[$id_product_color]["need_white_base"] = $result["need_white_base"];
			$color_data[$id_product_color]["option_value_id"] = $result["option_value_id"];
			$color_data[$id_product_color]["hexa"][] = $result["hexa"];
		}
		
		return $color_data;	
	}

}
?>