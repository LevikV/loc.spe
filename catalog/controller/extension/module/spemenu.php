<?php
class ControllerExtensionModuleSpemenu extends Controller {
	public function index() {

		$this->load->model('extension/module/spemenu');
        $this->load->model('tool/image');


        $menu_data = $this->model_extension_module_spemenu->getTreeItems();
        $spemenu_tree = $this->model_extension_module_spemenu->getMapTree($menu_data);

        $categories = $this->load->controller('extension/module/tree_cats/getTreeCats');

        foreach ($categories as &$category) {
            if ($category['image'] != '') {
                $category['image'] = $this->model_tool_image->resize($category['image'], 80, 80);
            }
        }

        foreach ($spemenu_tree as &$item) {
            if ($item['type_item'] === 'type-cat') {
                $item['children']  = $categories;
                $item['sub_cat_img_thumb'] = $this->model_tool_image->resize($item['sub_cat_img'], 345, 172);
            }
        }

        //print_r($spemenu_tree);

        $data['spemenu'] = $spemenu_tree;



        //
        return $this->load->view('extension/module/spemenu', $data);
	}
}