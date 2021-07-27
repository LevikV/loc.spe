<?php

class ModelCatalogSpeproduct extends Model
{
    public function getMainCategory($product_id)
    {
        $query = $this->db->query("SELECT ptc.category_id as category_id, cd.name as category_name FROM " . DB_PREFIX . "product_to_category ptc LEFT JOIN " . DB_PREFIX . "category_description cd ON (ptc.category_id = cd.category_id) WHERE ptc.product_id = '" . (int)$product_id . "' AND ptc.main_category=1");

        if ($query->num_rows) {
            $category = array(
                'category_name' => $query->row['category_name'],
                'category_id' => $query->row['category_id'],
            );
            return $category;
        } else {
            return false;
        }
    }

}