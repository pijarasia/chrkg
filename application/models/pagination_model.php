<?php
class Pagination_Model extends CI_Model
{
	public function __construct()
	{
		parent::__construct();
	}

	public function _pagination_init($base_url = NULL, $total_rows = NULL, $per_page = NULL, $cur_page = NULL,$config = array()){
      $this->load->library('pagination');
      $config["base_url"] = $base_url;
      $config["total_rows"] = $total_rows;
      $config["per_page"] = $per_page;
      $config["use_page_numbers"] = TRUE;
      $config["current_page"] = $cur_page;
      $config["first_link"] = TRUE;
      $config["last_link"] = TRUE;
      //pagination customization using bootstrap styles
      $config['full_tag_open'] = '<div class="pagination pagination-centered"><ul class="page_test">'; // I added class name 'page_test' to used later for jQuery
      $config['full_tag_close'] = '</ul></div><!--pagination-->';
      $config['first_link'] = '&laquo; First';
      $config['first_tag_open'] = '<li class="prev page">';
      $config['first_tag_close'] = '</li>';

      $config['last_link'] = 'Last &raquo;';
      $config['last_tag_open'] = '<li class="next page">';
      $config['last_tag_close'] = '</li>';

      $config['next_link'] = '<i class="icon-forward"></i>';
      $config['next_tag_open'] = '<li class="next page">';
      $config['next_tag_close'] = '</li>';

      $config['prev_link'] = '<i class="icon-backward"></i>';
      $config['prev_tag_open'] = '<li class="prev page">';
      $config['prev_tag_close'] = '</li>';

      $config['cur_tag_open'] = '<li class="active"><a href="">';
      $config['cur_tag_close'] = '</a></li>';

      $config['num_tag_open'] = '<li class="page">';
      $config['num_tag_close'] = '</li>';
      $config['anchor_class'] = 'class="follow_link"';

      $this->pagination->initialize($config);
    }
}
