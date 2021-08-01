<?php

class ControllerExtensionModuleSpemenu extends Controller {

    private $error = array();

    public function index() {
        $this->load->language('extension/module/spemenu');

        $this->document->addStyle('view/stylesheet/spemenu.css');

        $this->document->setTitle($this->language->get('heading_title'));

        $this->load->model('extension/module/spemenu');

        $this->getList();
    }

    public function getList() {
        $url = '';

        $data['breadcrumbs'] = array();

        $data['breadcrumbs'][] = array(
            'text' => $this->language->get('text_home'),
            'href' => $this->url->link('common/dashboard', 'user_token=' . $this->session->data['user_token'], true)
        );

        $data['breadcrumbs'][] = array(
            'text' => $this->language->get('heading_title'),
            'href' => $this->url->link('extension/module/spemenu', 'user_token=' . $this->session->data['user_token'] . $url, true)
        );

        if (isset($this->error['warning'])) {
            $data['error_warning'] = $this->error['warning'];
        } else {
            $data['error_warning'] = '';
        }

        if (isset($this->session->data['success'])) {
            $data['success'] = $this->session->data['success'];

            unset($this->session->data['success']);
        } else {
            $data['success'] = '';
        }

        $data['add'] = $this->url->link('extension/module/spemenu/add', 'user_token=' . $this->session->data['user_token'], true);

        $menu_data = $this->model_extension_module_spemenu->getTreeItems();
        $spemenu_tree = $this->model_extension_module_spemenu->getMapTree($menu_data);

        $data['spemenu'] = $this->treeToHtml($spemenu_tree);


        $data['header'] = $this->load->controller('common/header');
        $data['column_left'] = $this->load->controller('common/column_left');
        $data['footer'] = $this->load->controller('common/footer');

        $this->response->setOutput($this->load->view('extension/module/spemenu', $data));
    }

    public function add() {
        $this->load->language('extension/module/spemenu');
        $this->document->setTitle($this->language->get('heading_title'));
        $this->load->model('extension/module/spemenu');

        if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
            // save form
            $this->model_extension_module_spemenu->addItem($this->request->post['spemenu']);
            $this->session->data['success'] = $this->language->get('text_success');
            $this->cache->delete('spemenu');
            $this->response->redirect($this->url->link('extension/module/spemenu', 'user_token=' . $this->session->data['user_token'], true));
        }

        $data['text_form'] = $this->language->get('text_add');

        if (isset($this->error['warning'])) {
            $data['error_warning'] = $this->error['warning'];
        } else {
            $data['error_warning'] = '';
        }

        if (isset($this->error['title'])) {
            $data['error_title'] = $this->error['title'];
        } else {
            $data['error_title'] = array();
        }

        if (isset($this->error['link'])) {
            $data['error_link'] = $this->error['link'];
        } else {
            $data['error_link'] = array();
        }

        $data['breadcrumbs'] = array();
        $data['breadcrumbs'][] = array(
            'text' => $this->language->get('text_home'),
            'href' => $this->url->link('common/dashboard', 'user_token=' . $this->session->data['user_token'], true)
        );
        $data['breadcrumbs'][] = array(
            'text' => $this->language->get('heading_title'),
            'href' => $this->url->link('extension/module/spemenu', 'user_token=' . $this->session->data['user_token'], true)
        );

        $data['action'] = $this->url->link('extension/module/spemenu/add', 'user_token=' . $this->session->data['user_token'], true);
        $data['cancel'] = $this->url->link('extension/module/spemenu', 'user_token=' . $this->session->data['user_token'], true);

        $data['user_token'] = $this->session->data['user_token'];

        $this->load->model('localisation/language');

        $data['languages'] = $this->model_localisation_language->getLanguages();

        $data['header'] = $this->load->controller('common/header');
        $data['column_left'] = $this->load->controller('common/column_left');
        $data['footer'] = $this->load->controller('common/footer');

        if (isset($this->request->post['spemenu'])) {
            $data['spemenu_data'] = $this->request->post['spemenu'];
        }

        $menu_data = $this->model_extension_module_spemenu->getTreeItems();
        $spemenu_tree = $this->model_extension_module_spemenu->getMapTree($menu_data);
        $data['spemenu_select'] = $this->treeToHtml($spemenu_tree, 'select');

        $this->response->setOutput($this->load->view('extension/module/spemenu_form', $data));
    }

    public function edit() {
        $this->load->language('extension/module/spemenu');
        $this->document->setTitle($this->language->get('heading_title'));
        $this->load->model('extension/module/spemenu');

        if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
            // save form
            $this->model_extension_module_spemenu->editItem($this->request->get['spemenu_id'], $this->request->post['spemenu']);
            $this->session->data['success'] = $this->language->get('text_success');
            $this->cache->delete('spemenu');
            $this->response->redirect($this->url->link('extension/module/spemenu', 'user_token=' . $this->session->data['user_token'], true));
        }

        $data['text_form'] = $this->language->get('text_edit');

        if (isset($this->error['warning'])) {
            $data['error_warning'] = $this->error['warning'];
        } else {
            $data['error_warning'] = '';
        }

        if (isset($this->error['title'])) {
            $data['error_title'] = $this->error['title'];
        } else {
            $data['error_title'] = array();
        }

        if (isset($this->error['link'])) {
            $data['error_link'] = $this->error['link'];
        } else {
            $data['error_link'] = array();
        }

        $data['breadcrumbs'] = array();
        $data['breadcrumbs'][] = array(
            'text' => $this->language->get('text_home'),
            'href' => $this->url->link('common/dashboard', 'user_token=' . $this->session->data['user_token'], true)
        );
        $data['breadcrumbs'][] = array(
            'text' => $this->language->get('heading_title'),
            'href' => $this->url->link('extension/module/spemenu', 'user_token=' . $this->session->data['user_token'], true)
        );

        $data['action'] = $this->url->link('extension/module/spemenu/edit', 'user_token=' . $this->session->data['user_token'] . '&spemenu_id=' . $this->request->get['spemenu_id'], true);

        $data['cancel'] = $this->url->link('extension/module/spemenu', 'user_token=' . $this->session->data['user_token'], true);

        $data['user_token'] = $this->session->data['user_token'];

        $this->load->model('localisation/language');

        $data['languages'] = $this->model_localisation_language->getLanguages();

        $data['header'] = $this->load->controller('common/header');
        $data['column_left'] = $this->load->controller('common/column_left');
        $data['footer'] = $this->load->controller('common/footer');

        $data['spemenu_data'] = $this->model_extension_module_spemenu->getItem($this->request->get['spemenu_id']);

        $menu_data = $this->model_extension_module_spemenu->getTreeItems();
        $spemenu_tree = $this->model_extension_module_spemenu->getMapTree($menu_data);
        $data['spemenu_select'] = $this->treeToHtml(
            $spemenu_tree, 'select', '', $data['spemenu_data']['parent_id']
        );

        $this->response->setOutput($this->load->view('extension/module/spemenu_form', $data));
    }

    protected function treeToHtml($tree, $tpl = 'list', $tab = '', $parent_id = 0){
        $str = '';
        foreach ($tree as $item) {
            $str .= $this->treeToTemplate($item, $tpl, $tab, $parent_id);
        }
        return $str;
    }

    protected function treeToTemplate($item, $tpl, $tab, $parent_id){
        ob_start();

        if(!isset($item['children'])){
            $delete_link = $this->url->link('extension/module/spemenu/delete', 'user_token=' . $this->session->data['user_token'] . '&spemenu_id=' . $item['id'], true);
            $delete = '<a href="' . $delete_link . '" class="delete btn btn-danger"><i class="fa fa-trash-o"></i></a>';
        }
        $edit = $this->url->link('extension/module/spemenu/edit', 'user_token=' . $this->session->data['user_token'] . '&spemenu_id=' . $item['id'], true);
        ?>

        <?php if($tpl == 'list'): ?>
            <p class="item-p">
                <a class="list-group-item" href="<?= $edit; ?>"><?=$item['title'];?></a>
                <?php if(isset($delete)): ?>
                    <span><?=$delete;?></span>
                <?php endif; ?>
            </p>
            <?php if(isset($item['children'])): ?>
                <div class="list-group">
                    <?= $this->treeToHtml($item['children']); ?>
                </div>
            <?php endif; ?>
        <?php endif; ?>

        <?php if($tpl == 'select'): ?>
            <option
                value="<?= $item['id']; ?>"
                <?php if($item['id'] == $parent_id) echo ' selected'; ?>
                <?php if(isset($_GET['spemenu_id']) && $item['id'] == $_GET['spemenu_id']) echo ' disabled'; ?>>
                <?= $tab . $item['title']; ?>
            </option>
            <?php if(isset($item['children'])): ?>
                <?= $this->treeToHtml($item['children'], 'select', '&nbsp;' . $tab. '-', $parent_id); ?>
            <?php endif; ?>
        <?php endif ?>

        <?php
        return ob_get_clean();
    }

    protected function validateForm () {
        if (!$this->user->hasPermission('modify', 'extension/module/spemenu')) {
            $this->error['warning'] = $this->language->get('error_permission');
        }

        $title = trim($this->request->post['spemenu']['title']);
        if (empty($title)) {
            $this->error['title'] = $this->language->get('error_title');
        }

        $link = trim($this->request->post['spemenu']['link']);
        if (empty($link)) {
            $this->error['link'] = $this->language->get('error_link');
        }

        if ($this->error && !isset($this->error['warning'])) {
            $this->error['warning'] = $this->language->get('error_warning');
        }

        return !$this->error;
    }

}