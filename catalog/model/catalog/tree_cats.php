<?php
class ModelCatalogTreeCats extends Model {

    public function getTreeCats()
    {
        $query = $this->db->query(
            "SELECT * FROM " . DB_PREFIX . "category c 
            LEFT JOIN " . DB_PREFIX . "category_description cd ON (c.category_id = cd.category_id) 
            LEFT JOIN " . DB_PREFIX . "category_to_store c2s ON (c.category_id = c2s.category_id) 
            WHERE cd.language_id = '" . (int)$this->config->get('config_language_id') . "' AND c2s.store_id = '" . (int)$this->config->get('config_store_id') . "'  AND c.status = '1' ORDER BY c.sort_order, LCASE(cd.name)");
        //Устанавливаем ключами массива ID категории
        $cats = [];
        foreach ($query->rows as $row) {
            $cats[$row['category_id']] = $row;
        }

        return $cats;
        //return $query->rows;


    }

    public function getMapTree ($dataset) {
        $tree = array ();
        foreach ($dataset as $id => &$node) {
            if (!$node['parent_id']) {
                $tree[$id] = &$node;
            } else {
                $dataset[$node['parent_id']]['childs'][$id] = &$node;
            }
        }
        return $tree;
    }


}