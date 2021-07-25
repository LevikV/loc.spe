<?php
// *	@source		See SOURCE.txt for source and other copyright.
// *	@license	GNU General Public License version 3; see LICENSE.txt

class ControllerExtensionModuleSpeblogLatest extends Controller {
	public function index($setting) {
		$this->load->language('extension/module/speblog_latest');

		$this->load->model('blog/article');

		$this->load->model('tool/image');

        $data['articles'] = array();

		if (!empty($setting['article_category'])) {
            $categories = array_slice($setting['article_category'], 0);
            foreach ($categories as $category_id) {
                $filter_data = array(
                    'sort'  => 'p.date_added',
                    'order' => 'DESC',
                    'start' => 0,
                    'filter_blog_category_id' => $category_id,
                    'limit' => $setting['limit']
                );

                $results = $this->model_blog_article->getArticles($filter_data);

                if ($results) {
                    foreach ($results as $result) {
                        if ($result['image']) {
                            $image = $this->model_tool_image->resize($result['image'], $setting['width'], $setting['height']);
                        } else {
                            $image = $this->model_tool_image->resize('placeholder.png', $setting['width'], $setting['height']);
                        }

                        if ($this->config->get('configblog_review_status')) {
                            $rating = $result['rating'];
                        } else {
                            $rating = false;
                        }

                        $data['articles'][] = array(
                            'article_id'  => $result['article_id'],
                            'thumb'       => $image,
                            'name'        => $result['name'],
                            'description' => utf8_substr(strip_tags(html_entity_decode($result['description'], ENT_QUOTES, 'UTF-8')), 0, $this->config->get('configblog_article_description_length')) . '..',
                            'rating'      => $rating,
                            'date_added'  => date($this->language->get('date_format_short'), strtotime($result['date_added'])),
                            'viewed'      => $result['viewed'],
                            'href'        => $this->url->link('blog/article', 'article_id=' . $result['article_id'])
                        );
                    }
                }


            }
            echo '<pre>';
            print_r($categories);
            echo '/<pre>';
            return $this->load->view('extension/module/speblog_latest/speblog_latest', $data);

        }




	}
}
