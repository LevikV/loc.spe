<?php
class ModelExtensionModuleSpemenu extends Model {

    public function getTreeItems() {
        $query = $this->db->query("SELECT * FROM " . DB_PREFIX . "spemenu");
        $menu = [];
        foreach ($query->rows as $row) {
            $menu[$row['id']] = $row;
        }
        return $menu;
    }

    public function getMapTree($dataset) {
        $tree = [];
        foreach ($dataset as $id => &$node) {
            if (!$node['parent_id']) {
                $tree[$id] = &$node;
            } else {
                $dataset[$node['parent_id']]['children'][$id] = &$node;
            }
        }
        return $tree;
    }


}