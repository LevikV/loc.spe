<?php
class ControllerExtensionModuleSpebannerproduct extends Controller {
	private $error = array();

	public function index() {
		$this->load->language('extension/module/spebannerproduct');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('setting/module');

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {
			if (!isset($this->request->get['module_id'])) {
				$this->model_setting_module->addModule('spebannerproduct', $this->request->post);
			} else {
				$this->model_setting_module->editModule($this->request->get['module_id'], $this->request->post);
			}

			$this->session->data['success'] = $this->language->get('text_success');

			$this->response->redirect($this->url->link('marketplace/extension', 'user_token=' . $this->session->data['user_token'] . '&type=module', true));
		}

		if (isset($this->error['warning'])) {
			$data['error_warning'] = $this->error['warning'];
		} else {
			$data['error_warning'] = '';
		}

		if (isset($this->error['name'])) {
			$data['error_name'] = $this->error['name'];
		} else {
			$data['error_name'] = '';
		}

		if (isset($this->error['width'])) {
			$data['error_width'] = $this->error['width'];
		} else {
			$data['error_width'] = '';
		}

		if (isset($this->error['height'])) {
			$data['error_height'] = $this->error['height'];
		} else {
			$data['error_height'] = '';
		}

		$data['breadcrumbs'] = array();

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_home'),
			'href' => $this->url->link('common/dashboard', 'user_token=' . $this->session->data['user_token'], true)
		);

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_extension'),
			'href' => $this->url->link('marketplace/extension', 'user_token=' . $this->session->data['user_token'] . '&type=module', true)
		);

		if (!isset($this->request->get['module_id'])) {
			$data['breadcrumbs'][] = array(
				'text' => $this->language->get('heading_title'),
				'href' => $this->url->link('extension/module/spebannerproduct', 'user_token=' . $this->session->data['user_token'], true)
			);
		} else {
			$data['breadcrumbs'][] = array(
				'text' => $this->language->get('heading_title'),
				'href' => $this->url->link('extension/module/spebannerproduct', 'user_token=' . $this->session->data['user_token'] . '&module_id=' . $this->request->get['module_id'], true)
			);
		}

		if (!isset($this->request->get['module_id'])) {
			$data['action'] = $this->url->link('extension/module/spebannerproduct', 'user_token=' . $this->session->data['user_token'], true);
		} else {
			$data['action'] = $this->url->link('extension/module/spebannerproduct', 'user_token=' . $this->session->data['user_token'] . '&module_id=' . $this->request->get['module_id'], true);
		}

		$data['cancel'] = $this->url->link('marketplace/extension', 'user_token=' . $this->session->data['user_token'] . '&type=module', true);

		if (isset($this->request->get['module_id']) && ($this->request->server['REQUEST_METHOD'] != 'POST')) {
			$module_info = $this->model_setting_module->getModule($this->request->get['module_id']);
		}

		$data['user_token'] = $this->session->data['user_token'];

		if (isset($this->request->post['name'])) {
			$data['name'] = $this->request->post['name'];
		} elseif (!empty($module_info)) {
			$data['name'] = $module_info['name'];
		} else {
			$data['name'] = '';
		}

		$this->load->model('catalog/product');



		$data['products'] = array();

		if (!empty($this->request->post['product'])) {
			$products = $this->request->post['product'];
		} elseif (!empty($module_info['product'])) {
			$products = $module_info['product'];
		} else {
			$products = array();
		}

		foreach ($products as $product_id) {
			$product_info = $this->model_catalog_product->getProduct($product_id);

			if ($product_info) {
				$data['products'][] = array(
					'product_id' => $product_info['product_id'],
					'name'       => $product_info['name']
				);
			}
		}


        //
        if (isset($this->request->post['title-main'])) {
            $data['title_main'] = $this->request->post['title-main'];
        } elseif (!empty($module_info)) {
            $data['title_main'] = $module_info['title-main'];
        } else {
            $data['title_main'] = '';
        }
        //
        if (isset($this->request->post['title-product'])) {
            $data['title_product'] = $this->request->post['title-product'];
        } elseif (!empty($module_info)) {
            $data['title_product'] = $module_info['title-product'];
        } else {
            $data['title_product'] = '';
        }
        //
        if (isset($this->request->post['advant'])) {
            $data['advant'] = $this->request->post['advant'];
        } elseif (!empty($module_info)) {
            $data['advant'] = $module_info['advant'];
        } else {
            $data['advant'] = '';
        }
        //
        if (isset($this->request->post['advant2'])) {
            $data['advant2'] = $this->request->post['advant2'];
        } elseif (!empty($module_info)) {
            $data['advant2'] = $module_info['advant2'];
        } else {
            $data['advant2'] = '';
        }
        //
        if (isset($this->request->post['advant3'])) {
            $data['advant3'] = $this->request->post['advant3'];
        } elseif (!empty($module_info)) {
            $data['advant3'] = $module_info['advant3'];
        } else {
            $data['advant3'] = '';
        }
        //
        if (isset($this->request->post['advant4'])) {
            $data['advant4'] = $this->request->post['advant4'];
        } elseif (!empty($module_info)) {
            $data['advant4'] = $module_info['advant4'];
        } else {
            $data['advant4'] = '';
        }
        //
        if (isset($this->request->post['advant5'])) {
            $data['advant5'] = $this->request->post['advant5'];
        } elseif (!empty($module_info)) {
            $data['advant5'] = $module_info['advant5'];
        } else {
            $data['advant5'] = '';
        }
        //
        if (isset($this->request->post['advant6'])) {
            $data['advant6'] = $this->request->post['advant6'];
        } elseif (!empty($module_info)) {
            $data['advant6'] = $module_info['advant6'];
        } else {
            $data['advant6'] = '';
        }
        //
        if (isset($this->request->post['subtxt'])) {
            $data['subtxt'] = $this->request->post['subtxt'];
        } elseif (!empty($module_info)) {
            $data['subtxt'] = $module_info['subtxt'];
        } else {
            $data['subtxt'] = '';
        }

        //Код выбора своего изображения для баннера

        $this->load->model('tool/image');

        if (isset($this->request->post['banner_image'])) {
            $banner_image = $this->request->post['banner_image'];
            if (is_file(DIR_IMAGE . $banner_image)) {
                $data['banner_image'] = $banner_image;
                $banner_image_thumb = $banner_image;
                $data['banner_image_thumb'] = $this->model_tool_image->resize($banner_image_thumb, 100, 100);
            } else {
                $data['banner_image'] = '';
                $data['banner_image_thumb'] = $this->model_tool_image->resize('../image/no_image.png', 100, 100);
            }

        } elseif (!empty($module_info)) {
            $data['banner_image'] = $module_info['banner_image'];
            $data['banner_image_thumb'] = $this->model_tool_image->resize($module_info['banner_image'], 100, 100);

        } else {
            $data['banner_image'] = '';
            $data['banner_image_thumb'] = $this->model_tool_image->resize('../image/no_image.png', 100, 100);;
        }




		if (isset($this->request->post['limit'])) {
			$data['limit'] = $this->request->post['limit'];
		} elseif (!empty($module_info)) {
			$data['limit'] = $module_info['limit'];
		} else {
			$data['limit'] = 1;
		}

		if (isset($this->request->post['width'])) {
			$data['width'] = $this->request->post['width'];
		} elseif (!empty($module_info)) {
			$data['width'] = $module_info['width'];
		} else {
			$data['width'] = 200;
		}

		if (isset($this->request->post['height'])) {
			$data['height'] = $this->request->post['height'];
		} elseif (!empty($module_info)) {
			$data['height'] = $module_info['height'];
		} else {
			$data['height'] = 200;
		}

		if (isset($this->request->post['status'])) {
			$data['status'] = $this->request->post['status'];
		} elseif (!empty($module_info)) {
			$data['status'] = $module_info['status'];
		} else {
			$data['status'] = '';
		}

		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');

		$this->response->setOutput($this->load->view('extension/module/spebannerproduct', $data));
	}

	protected function validate() {
		if (!$this->user->hasPermission('modify', 'extension/module/spebannerproduct')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}

		if ((utf8_strlen($this->request->post['name']) < 3) || (utf8_strlen($this->request->post['name']) > 64)) {
			$this->error['name'] = $this->language->get('error_name');
		}

		if (!$this->request->post['width']) {
			$this->error['width'] = $this->language->get('error_width');
		}

		if (!$this->request->post['height']) {
			$this->error['height'] = $this->language->get('error_height');
		}

		return !$this->error;
	}
}
