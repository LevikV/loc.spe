<?php
class ControllerExtensionModuleSpebannercolor extends Controller {
	public function index($setting) {
		static $module = 0;		

		$this->load->model('design/spebanner');
		$this->load->model('tool/image');

        $this->document->addStyle('catalog/view/theme/spe/template/extension/module/spebannercolor/css/spebannercolor.css');


		
		$data['banners'] = array();

		$results = $this->model_design_spebanner->getBanner($setting['banner_id']);

		foreach ($results as $result) {
			if (is_file(DIR_IMAGE . $result['image'])) {
				$data['banners'][] = array(
					'title' => $result['title'],
                    'title2' => $result['title2'],
                    'title3' => $result['title3'],
                    'title4' => $result['title4'],
                    'title5' => $result['title5'],
					'link'  => $result['link'],
					'image' => $this->model_tool_image->resize($result['image'], $setting['width'], $setting['height'])
				);
			}
		}

		$data['module'] = $module++;


        $data['spe_banner_color_name'] = $setting['name'];

		return $this->load->view('extension/module/spebannercolor/spebannercolor', $data);
	}
}