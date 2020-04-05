<?php defined('BASEPATH') OR exit('No direct script access allowed');

Class My_Lms extends MY_Site {
    
    public function __construct()
    {
      parent::__construct();

        /**
         * Set Language
         */
        $this->_Language->load(['lms']);

        /**
         * Load Meta Data
         */
        $this->load->model('lms/M_Site_Meta');
        $this->site = $this->M_Site_Meta->init();

        /**
         * Load Template Widget
         */
        $this->load->model('lms/M_Template_Widget');
        $template_widget = $this->M_Template_Widget->init($this->site,$this->template);
        if ($template_widget) $this->widget = $template_widget;  

        /**
        * Record Visitor
        * Place here because if caching active record not running.
        */
        $this->load->model('site/M_Site_Visitor');
        $this->M_Site_Visitor->record($this->site);   
    }    

}