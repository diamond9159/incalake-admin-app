<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Bloqueo extends CI_Controller{
    function __construct()
    {
        parent::__construct();
        $this->load->model('bloqueo_model','Bloqueo_model');
    } 

    /*
     * Listing of bloqueos
     */
    function index()
    {
        $params['limit'] = RECORDS_PER_PAGE; 
        $params['offset'] = ($this->input->get('per_page')) ? $this->input->get('per_page') : 0;
        
        $config = $this->config->item('pagination');
        $config['base_url'] = site_url('bloqueo/index?');
        $config['total_rows'] = $this->Bloqueo_model->get_all_bloqueos_count();
        $this->pagination->initialize($config);

        $data['bloqueos'] = $this->Bloqueo_model->get_all_bloqueos($params);
        
        $data['_view'] = 'bloqueo/index';
        $this->load->view('layouts/main',$data);
    }

    /*
     * Adding a new bloqueo
     */
    function add()
    {   
        $this->load->library('form_validation');

		$this->form_validation->set_rules('fecha_inicio','Fecha Inicio','required');
		$this->form_validation->set_rules('fecha_fin','Fecha Fin','required');
		$this->form_validation->set_rules('color_bloqueo','Color Bloqueo','required');
		
		if($this->form_validation->run())     
        {   
            $params = array(
				'id_bus' => $this->input->post('id_bus'),
				'fecha_inicio' => $this->input->post('fecha_inicio'),
				'fecha_fin' => $this->input->post('fecha_fin'),
				'color_bloqueo' => $this->input->post('color_bloqueo'),
				'descripcion_bloqueo' => $this->input->post('descripcion_bloqueo'),
            );
            
            $bloqueo_id = $this->Bloqueo_model->add_bloqueo($params);
            redirect('bloqueo/index');
        }
        else
        {
			$this->load->model('Bus_model');
			$data['all_buses'] = $this->Bus_model->get_all_buses();
            
            $data['_view'] = 'bloqueo/add';
            $this->load->view('layouts/main',$data);
        }
    }  

    /*
     * Editing a bloqueo
     */
    function edit($id_bloqueo)
    {   
        // check if the bloqueo exists before trying to edit it
        $data['bloqueo'] = $this->Bloqueo_model->get_bloqueo($id_bloqueo);
        
        if(isset($data['bloqueo']['id_bloqueo']))
        {
            $this->load->library('form_validation');

			$this->form_validation->set_rules('fecha_inicio','Fecha Inicio','required');
			$this->form_validation->set_rules('fecha_fin','Fecha Fin','required');
			$this->form_validation->set_rules('color_bloqueo','Color Bloqueo','required');
		
			if($this->form_validation->run())     
            {   
                $params = array(
					'id_bus' => $this->input->post('id_bus'),
					'fecha_inicio' => $this->input->post('fecha_inicio'),
					'fecha_fin' => $this->input->post('fecha_fin'),
					'color_bloqueo' => $this->input->post('color_bloqueo'),
					'descripcion_bloqueo' => $this->input->post('descripcion_bloqueo'),
                );

                $this->Bloqueo_model->update_bloqueo($id_bloqueo,$params);            
                redirect('bloqueo/index');
            }
            else
            {
				$this->load->model('Bus_model');
				$data['all_buses'] = $this->Bus_model->get_all_buses();

                $data['_view'] = 'bloqueo/edit';
                $this->load->view('layouts/main',$data);
            }
        }
        else
            show_error('The bloqueo you are trying to edit does not exist.');
    } 

    /*
     * Deleting bloqueo
     */
    function remove($id_bloqueo)
    {
        $bloqueo = $this->Bloqueo_model->get_bloqueo($id_bloqueo);

        // check if the bloqueo exists before trying to delete it
        if(isset($bloqueo['id_bloqueo']))
        {
            $this->Bloqueo_model->delete_bloqueo($id_bloqueo);
            redirect('bloqueo/index');
        }
        else
            show_error('The bloqueo you are trying to delete does not exist.');
    }
    
}
