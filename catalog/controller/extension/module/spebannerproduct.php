<?php
class ControllerExtensionModuleSpebannerproduct extends Controller {
	public function index($setting) {
		$this->load->language('extension/module/spebannerproduct');

		$this->load->model('catalog/product');

		$this->load->model('tool/image');

		$data['products'] = array();


		if (!$setting['limit']) {
			$setting['limit'] = 1;
		}

        $data['title_main'] = $setting['title-main'];
        $data['title_product'] = $setting['title-product'];
        $data['subtxt'] = $setting['subtxt'];
        $data['advant'] = $setting['advant'];
        $data['advant2'] = $setting['advant2'];
        $data['advant3'] = $setting['advant3'];
        $data['advant4'] = $setting['advant4'];
        $data['advant5'] = $setting['advant5'];
        $data['advant6'] = $setting['advant6'];
        if ($setting['banner_image']) {
            $data['banner_image'] = $this->model_tool_image->resize($setting['banner_image'], $setting['width'], $setting['height']);
        } else {
            $data['banner_image'] = $this->model_tool_image->resize('placeholder.png', $setting['width'], $setting['height']);
        }




        //Получаем данные по продуктам вкладки 1
		if (!empty($setting['product'])) {


			$products = array_slice($setting['product'], 0, (int)$setting['limit']);

            $product_id = $products[0];
            $product_info = $this->model_catalog_product->getProduct($product_id);

            if ($product_info) {



                if ($this->customer->isLogged() || !$this->config->get('config_customer_price')) {
                    $price = $this->currency->format($this->tax->calculate($product_info['price'], $product_info['tax_class_id'], $this->config->get('config_tax')), $this->session->data['currency']);
                } else {
                    $price = false;
                }

                if ((float)$product_info['special']) {
                    $special = $this->currency->format($this->tax->calculate($product_info['special'], $product_info['tax_class_id'], $this->config->get('config_tax')), $this->session->data['currency']);
                } else {
                    $special = false;
                }

                if ((float)$product_info['quantity'] > 0) {
                    $stock = true;
                } else {
                    $stock = false;
                }


                $data['product'] = array(
                    'product_id'  => $product_info['product_id'],
                    'name'        => $product_info['name'],
                    'price'       => $price,
                    'special'     => $special,
                    'stock'     => $stock,
                    'href'        => $this->url->link('product/product', 'product_id=' . $product_info['product_id'])
                );
            }

			//

		}



        //
        return $this->load->view('extension/module/spebannerproduct/spebannerproduct', $data);
	}
}