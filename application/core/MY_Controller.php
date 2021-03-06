<?php

class MY_Controller extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
	}

	/**
	 * Upload a single file
	 *
	 * @param $name_field
	 * @param array $config
	 * @return bool
	 */
	public function uploadFile($name_field,$config = array())
	{
		$upload_config = $this->getUploadConfig();

		$this->load->library('upload', $upload_config);

		if(!$this->upload->do_upload($name_field)){
			$this->form_validation->set_message('cover_image', $this->upload->display_errors());
			return false;
		}
		$this->cover_image = $this->upload->data();
		return $this->cover_image;
	}


	/**
	 * Create thumbnail of image using upload_data
	 *
	 * @param array $upload_data CI upload data array
	 * @param array $config resize config array
	 * @return bool
	 */
	public function createThumb($upload_data,$config = array())
	{

		if (empty($config)){

			$config['image_library'] = 'gd2';
			$config['create_thumb'] = TRUE;
			$config['maintain_ratio'] = TRUE;
			$config['width'] = 800;
			$config['height'] = 600;
		}


		$config['source_image'] = product_images_path($upload_data['file_name']);
		$this->load->library('image_lib', $config);

		return $this->image_lib->resize();
	}
}

?>
