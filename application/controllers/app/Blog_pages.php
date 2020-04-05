<?php defined('BASEPATH') or exit('No direct script access allowed');

class Blog_pages extends My_App
{

    public $index = 'app/blog_pages/index';
    public $form = 'app/blog_pages/form';
    public $redirect = 'app/blog_pages';

    public function __construct(){
        parent::__construct();

        $this->load->model('app/M_Blog_Pages');         
    }    

    public function index()
    {

        $data = [
            'title' => 'Blog Pages',
        ];

        $this->load->view($this->index, array_merge($data,$this->M_Blog_Pages->datatables()));
    }    


    public function datatables()
    {

        $data = $this->M_Blog_Pages->data_table();

        echo $data;
    }

    public function create()
    {

        $data = array(
            'title' => 'Create',
            'ckeditor' => true,
        );

        $this->load->view($this->form, $data);
    }    

    public function update($id){
        $data = array(
            'title' => 'Update',
            'ckeditor' => true,
            'blog_pages' => $this->M_Blog_Pages->data_update($id),
        );

        $this->load->view($this->form, $data);
    }    

    public function delete($id)
    {
        if ($this->M_Blog_Pages->process_delete($id) == TRUE) {
            echo true;
        }else {
            echo false;
        }
    }

    public function process(){

        if (!empty($this->input->post('id'))) {

            if ($this->M_Blog_Pages->process_update() == TRUE) {

                $this->session->set_flashdata([
                    'message' => true,
                    'message_type' => 'info',
                    'message_text' => $this->lang->line('success_update'),
                ]);
            }   

        }else {

            if ($this->M_Blog_Pages->process_create() == TRUE) {

                $this->session->set_flashdata([
                    'message' => true,
                    'message_type' => 'info',
                    'message_text' => $this->lang->line('success_create'),
                ]);
            }   

        }

        if (!empty($this->input->post('save'))) {
            redirect($this->input->post('save'),'refresh');
        }else {                
            redirect(base_url($this->redirect));
        }
    }

    public function process_multiple()
    {

        $id = explode(',', $this->input->post('id'));
        $action = $this->input->post('action');

        /**
         * Update Post to Published
         */
        if ($action == 'post') {

            foreach ($id as $key => $item) 
            {
                $data[] = array(
                    'id' => $id[$key],
                    'status' => 'Published',
                );
            }

            if ($this->M_Blog_Pages->process_multiple_update($data) == TRUE) {
                echo true;
            }else {
                echo false;
            }
        }        

        /**
         * Update Post to Draft
         */
        if ($action == 'draft') {

            foreach ($id as $key => $item) 
            {
                $data[] = array(
                    'id' => $id[$key],
                    'status' => 'Draft',
                );
            }

            if ($this->M_Blog_Pages->process_multiple_update($data) == TRUE) {
                echo true;
            }else {
                echo false;
            }
        }

        /**
         * Delete Post
         */
        if ($action == 'delete') {

            if ($this->M_Blog_Pages->process_multiple_delete($id) == TRUE) {
                echo true;
            }else {
                echo false;
            }
        }

    }    

}
