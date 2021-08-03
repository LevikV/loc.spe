<?php
class ControllerExtensionModuleTreeCats extends Controller {

    protected function debug($data) {
        echo '<pre>' . print_r($data, 1) . '</pre>';
    }

    public function index() {
		$this->load->language('extension/module/tree_cats');
		$data['my_title'] = $this->language->get('heading_title');

		//Подключаем аккордион меню
        $this->document->addScript('catalog/view/javascript/jquery-vertical-accordion-menu/js/jquery.cookie.js');
        $this->document->addScript('catalog/view/javascript/jquery-vertical-accordion-menu/js/jquery.hoverIntent.minified.js');
        $this->document->addScript('catalog/view/javascript/jquery-vertical-accordion-menu/js/jquery.dcjqaccordion.2.7.min.js');


		//Получаем ID категории
        if (isset($this->request->get['path'])) {
            $parts = explode('_', (string)$this->request->get['path']);
        } else {
            $parts = array();
        }
        //Получаем ID активной категории
        if (!empty($parts)) {
            $data['active'] = end($parts);
        } else {
            $data['active'] = 0;
        }
        //Подключаем модель
        $this->load->model('catalog/tree_cats');

        $data['categories'] = array();

        //Получаем все категории одним массивом
        $categories = $this->model_catalog_tree_cats->getTreeCats();
        //Получаем URL для каждой категории
        foreach ($categories as $id => $category) {
            $categories[$id]['href'] = $this->url->link('product/category', 'path=' . $category['category_id']);
        }
        //Получаем дерево категории
        $data['categories_tree'] = $this->model_catalog_tree_cats->getMapTree($categories);

        //$this->debug($data['categories_tree']);

        $data['_class'] = 'my_cats';
        $data['_id'] = 'accordion';

        return $this->load->view('extension/module/tree_cats', $data);
	}

	public function getTreeCats () {
        //Подключаем модель
        $this->load->model('catalog/tree_cats');

        //Получаем все категории одним массивом
        $categories = $this->model_catalog_tree_cats->getTreeCats();
        //Получаем URL для каждой категории
        foreach ($categories as $id => $category) {
            $categories[$id]['href'] = $this->url->link('product/category', 'path=' . $category['category_id']);
        }
        //Получаем дерево категории
        $categories_tree = $this->model_catalog_tree_cats->getMapTree($categories);

        return($categories_tree);
    }
}