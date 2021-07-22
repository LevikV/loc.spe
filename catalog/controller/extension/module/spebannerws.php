<?php
class ControllerExtensionModuleSpebannerws extends Controller {
	public function index($setting) {


		$this->load->model('tool/image');


        $this->document->addStyle('catalog/view/theme/spe/template/extension/module/spebannersw/css/spebannerws.css');

        $data['banner_image'] = $this->model_tool_image->resize($setting['banner_image'], $setting['width'], $setting['height']);
        $data['title'] = $setting['title'];
        $data['descrip'] = $setting['descrip'];
        $data['btntxt'] = $setting['btntxt'];
        $data['link'] = $setting['link'];



		return $this->load->view('extension/module/spebannerws/spebannerws', $data);
	}
}