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
        $this->db->query("INSERT INTO " . DB_PREFIX . "spemenu SET title = '" . $this->db->escape($data['title']) . "', link = '" . $this->db->escape($data['link']) . "', parent_id = " . (int)$data['parent'] . ", type_item = '" . $this->db->escape($data['type']) . "'");
        return $this->db->getLastId();
    }

    public function editItem($spemenu_id, $data) {
        $this->db->query("UPDATE " . DB_PREFIX . "spemenu SET title = '" . $this->db->escape($data['title']) . "', link = '" . $this->db->escape($data['link']) . "', parent_id = " . (int)$data['parent'] .", type_item = '" . $this->db->escape($data['type']) . "'" . " WHERE id = '" . (int)$spemenu_id . "'");
    }

    public function getItem($spemenu_id) {
        $query = $this->db->query("SELECT * FROM " . DB_PREFIX . "spemenu WHERE id = '" . (int)$spemenu_id . "'");

        return $query->row;
    }

    public function deleleteItemMenu($spemenu_id) {
        $query = $this->db->query("DELETE FROM " . DB_PREFIX . "spemenu WHERE id = '" . (int)$spemenu_id . "'");

    }

}