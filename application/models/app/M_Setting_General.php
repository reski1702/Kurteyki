<?php if (!defined('BASEPATH')) {exit('No direct script access allowed');}

class M_Setting_General extends CI_Model
{

	public $table_site = 'tb_site';

	public function read_data(){
		$read_site = $this->_Process_MYSQL->read_data($this->table_site, 'type', 'ASC')->result_array();      

		foreach ($read_site as $data_site) {
			$site[$data_site['type']] = $data_site['data'];
		}

		$site['comment'] = json_decode($site['comment'],true);

		return $site;
	}

	public function data_post(){

		$post = $this->input->post();

		foreach ($post as $key => $value) {

			if ($key == 'image_old') continue;
			if ($key == 'icon_old') continue;
			if ($key == 'no_image_old') continue;
			if ($key == 'comment_type') continue;			
			if ($key == 'disqus_shortname') continue;
			if ($key == 'disqus_developer') continue;
			if ($key == 'moderate') continue;
			if ($key == 'message') continue;			

			$data [] = [
				'type' => $key,
				'data' => $value,
			];
		}

		/**
		 * build comment data
		 */
		
		$comment_data = [
			'type' => $post['comment_type'],
			'disqus_shortname' => $post['disqus_shortname'],
			'disqus_developer' => $post['disqus_developer'],
			'moderate' => $post['moderate'],
			'message' => $post['message']
		];

		$data[] = [
			'type' => 'comment',
			'data' => json_encode($comment_data,true),
		];

		// echo json_encode($data);		
		// exit;

		/**
		 * if new image
		 */
		if (!empty($_FILES['image']['name'])) {

			$image_old = $post['image_old'];

			$upload_image = $this->_Process_Upload->Upload_File(
				'image', // config upload
				'storage/images/', // dir upload
				'image', // file post data
				$image_old, // delete file
				'logo', // file name
				true //is image
			);

			$data[] = [
				'type' => 'image',
				'data' => $upload_image['image'],
			];
		}
		
		/**
		 * if new icon
		 */
		if (!empty($_FILES['icon']['name'])) {

			$icon_old = $post['icon_old'];

			$upload_icon = $this->_Process_Upload->Upload_File(
				'image', // config upload
				'storage/images/', // dir upload
				'icon', // file post data
				$icon_old, // delete file
				'icon', // file name
				true //is image
			);

			$data[] = [
				'type' => 'icon',
				'data' => $upload_icon['icon'],
			];
		}		

		/**
		 * if new no_image
		 */
		if (!empty($_FILES['no_image']['name'])) {

			$no_image_old = $post['no_image_old'];

			$upload_no_image = $this->_Process_Upload->Upload_File(
				'image', // config upload
				'storage/images/', // dir upload
				'no_image', // file post data
				$no_image_old, // delete file
				'no_image', // file name
				true //is image
			);

			$data[] = [
				'type' => 'no_image',
				'data' => $upload_no_image['no_image'],
			];
		}

		/**
		 * Delete Cache if not active
		 */
		if ($post['cache'] == 'No') {
			$this->output->clear_all_cache();
		}

		return $data;
	}

	public function process_update(){
		return $this->_Process_MYSQL->update_data_multiple($this->table_site,$this->data_post(),'type');
	}
}