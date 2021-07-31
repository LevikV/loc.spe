<?php

class ControllerExtensionModuleSpemenu extends Controller {

    private $error = array();

    public function index() {
        $this->load->language('extension/module/spemenu');

        $this->document->setTitle($this->language->get('heading_title'));

       // $this->load->model('extension/module/spemenu');

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


        $data['header'] = $this->load->controller('common/header');
        $data['column_left'] = $this->load->controller('common/column_left');
        $data['footer'] = $this->load->controller('common/footer');

        $this->response->setOutput($this->load->view('extension/module/spemenu', $data));
    }

}