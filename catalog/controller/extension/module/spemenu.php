<?php
class ControllerExtensionModuleSpemenu extends Controller {
	public function index() {

		$this->load->model('extension/module/spemenu');



        $menu_data = $this->model_extension_module_spemenu->getTreeItems();
        $spemenu_tree = $this->model_extension_module_spemenu->getMapTree($menu_data);


        foreach ($spemenu_tree as &$item) {
            if ($item['type_item'] === 'type-cat') {
                $item['children']  = $this->load->controller('extension/module/tree_cats/getTreeCats');
            }
        }


        $data['spemenu'] = $spemenu_tree;



        //
        return $this->load->view('extension/module/spemenu', $data);
	}
}