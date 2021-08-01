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

    public function addItem($data) {
        $this->db->query("INSERT INTO " . DB_PREFIX . "spemenu SET title = '" . $this->db->escape($data['title']) . "', link = '" . $this->db->escape($data['link']) . "', parent_id = " . (int)$data['parent']);
        return $this->db->getLastId();
    }


}