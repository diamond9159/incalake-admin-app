<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Disponibilidad extends CI_Controller{
    function __construct()
    {
        parent::__construct();
        $this->load->model('disponibilidad_model','Disponibilidad_model');
    } 

    /*
     * Listing of disponibilidades
     */
    function index()
    {
        $params['limit'] = RECORDS_PER_PAGE; 
        $params['offset'] = ($this->input->get('per_page')) ? $this->input->get('per_page') : 0;
        
        $config = $this->config->item('pagination');
        $config['base_url'] = site_url('disponibilidad/index?');
        $config['total_rows'] = $this->Disponibilidad_model->get_all_disponibilidades_count();
        $this->pagination->initialize($config);

        $data['disponibilidades'] = $this->Disponibilidad_model->get_all_disponibilidades($params);
        
        $data['_view'] = 'disponibilidad/index';
        $this->load->view('layouts/main',$data);
    }

    /*
     * Adding a new disponibilidad
     */
    function add()
    {   
        $this->load->library('form_validation');

		$this->form_validation->set_rules('fecha_inicio','Fecha Inicio','required');
		$this->form_validation->set_rules('fecha_fin','Fecha Fin','required');
		$this->form_validation->set_rules('color_disponibilidad','Color Disponibilidad','required');
		$this->form_validation->set_rules('dias_activos','Dias Activos','required');
		$this->form_validation->set_rules('dias_no_activos','Dias No Activos','required');
		$this->form_validation->set_rules('id_bus','Id Bus','required');
		
		if($this->form_validation->run())     
        {   
            $params = array(
				'id_bus' => $this->input->post('id_bus'),
				'fecha_inicio' => $this->input->post('fecha_inicio'),
				'fecha_fin' => $this->input->post('fecha_fin'),
				'color_disponibilidad' => $this->input->post('color_disponibilidad'),
				'dias_activos' => $this->input->post('dias_activos'),
				'dias_no_activos' => $this->input->post('dias_no_activos'),
				'descripcion_disponibilidad' => $this->input->post('descripcion_disponibilidad'),
				'dias_especiales' => $this->input->post('dias_especiales'),
				'meses_inactivos' => $this->input->post('meses_inactivos'),
            );
            
            $disponibilidad_id = $this->Disponibilidad_model->add_disponibilidad($params);
            redirect('disponibilidad/index');
        }
        else
        {
			$this->load->model('Bus_model');
			$data['all_buses'] = $this->Bus_model->get_all_buses();
            
            $data['_view'] = 'disponibilidad/add';
            $this->load->view('layouts/main',$data);
        }
    }  

    /*
     * Editing a disponibilidad
     */
    function edit($id_disponibilidad)
    {   
        // check if the disponibilidad exists before trying to edit it
        $data['disponibilidad'] = $this->Disponibilidad_model->get_disponibilidad($id_disponibilidad);
        
        if(isset($data['disponibilidad']['id_disponibilidad']))
        {
            $this->load->library('form_validation');

			$this->form_validation->set_rules('fecha_inicio','Fecha Inicio','required');
			$this->form_validation->set_rules('fecha_fin','Fecha Fin','required');
			$this->form_validation->set_rules('color_disponibilidad','Color Disponibilidad','required');
			$this->form_validation->set_rules('dias_activos','Dias Activos','required');
			$this->form_validation->set_rules('dias_no_activos','Dias No Activos','required');
			$this->form_validation->set_rules('id_bus','Id Bus','required');
		
			if($this->form_validation->run())     
            {   
                $params = array(
					'id_bus' => $this->input->post('id_bus'),
					'fecha_inicio' => $this->input->post('fecha_inicio'),
					'fecha_fin' => $this->input->post('fecha_fin'),
					'color_disponibilidad' => $this->input->post('color_disponibilidad'),
					'dias_activos' => $this->input->post('dias_activos'),
					'dias_no_activos' => $this->input->post('dias_no_activos'),
					'descripcion_disponibilidad' => $this->input->post('descripcion_disponibilidad'),
					'dias_especiales' => $this->input->post('dias_especiales'),
					'meses_inactivos' => $this->input->post('meses_inactivos'),
                );

                $this->Disponibilidad_model->update_disponibilidad($id_disponibilidad,$params);            
                redirect('disponibilidad/index');
            }
            else
            {
				$this->load->model('Bus_model');
				$data['all_buses'] = $this->Bus_model->get_all_buses();

                $data['_view'] = 'disponibilidad/edit';
                $this->load->view('layouts/main',$data);
            }
        }
        else
            show_error('The disponibilidad you are trying to edit does not exist.');
    } 

    /*
     * Deleting disponibilidad
     */
    function remove($id_disponibilidad)
    {
        $disponibilidad = $this->Disponibilidad_model->get_disponibilidad($id_disponibilidad);

        // check if the disponibilidad exists before trying to delete it
        if(isset($disponibilidad['id_disponibilidad']))
        {
            $this->Disponibilidad_model->delete_disponibilidad($id_disponibilidad);
            redirect('disponibilidad/index');
        }
        else
            show_error('The disponibilidad you are trying to delete does not exist.');
    }
    
}
