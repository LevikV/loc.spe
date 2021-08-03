<?php
class ControllerExtensionModuleSpemenu extends Controller {
	public function index() {

		$this->load->model('extension/module/spemenu');

        $this->document->addStyle('catalog/view/theme/spe/template/extension/module/spebannerproduct/css/spebannerproduct.css');







        //
        return $this->load->view('extension/module/spemenu', $data);
	}
}