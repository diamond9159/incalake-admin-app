<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Oferta extends CI_Controller{
    function __construct()
    {
        parent::__construct();
        $this->load->model('oferta_model','Oferta_model');
    } 

    /*
     * Listing of ofertas
     */
    function index()
    {
        $params['limit'] = RECORDS_PER_PAGE; 
        $params['offset'] = ($this->input->get('per_page')) ? $this->input->get('per_page') : 0;
        
        $config = $this->config->item('pagination');
        $config['base_url'] = site_url('oferta/index?');
        $config['total_rows'] = $this->Oferta_model->get_all_ofertas_count();
        $this->pagination->initialize($config);

        $data['ofertas'] = $this->Oferta_model->get_all_ofertas($params);
        
        $data['_view'] = 'oferta/index';
        $this->load->view('layouts/main',$data);
    }

    /*
     * Adding a new oferta
     */
    function add()
    {   
        $this->load->library('form_validation');

		$this->form_validation->set_rules('valor_oferta','Valor Oferta','required');
		$this->form_validation->set_rules('tipo_oferta','Tipo Oferta','required');
		$this->form_validation->set_rules('fecha_inicio','Fecha Inicio','required');
		$this->form_validation->set_rules('fecha_fin','Fecha Fin','required');
		$this->form_validation->set_rules('color_oferta','Color Oferta','required');
		$this->form_validation->set_rules('descripcion_oferta','Descripcion Oferta','required');
		$this->form_validation->set_rules('id_bus','Id Bus','required');
		
		if($this->form_validation->run())     
        {   
            $params = array(
				'id_bus' => $this->input->post('id_bus'),
				'valor_oferta' => $this->input->post('valor_oferta'),
				'tipo_oferta' => $this->input->post('tipo_oferta'),
				'fecha_inicio' => $this->input->post('fecha_inicio'),
				'fecha_fin' => $this->input->post('fecha_fin'),
				'color_oferta' => $this->input->post('color_oferta'),
				'descripcion_oferta' => $this->input->post('descripcion_oferta'),
            );
            
            $oferta_id = $this->Oferta_model->add_oferta($params);
            redirect('oferta/index');
        }
        else
        {
			$this->load->model('Bus_model');
			$data['all_buses'] = $this->Bus_model->get_all_buses();
            
            $data['_view'] = 'oferta/add';
            $this->load->view('layouts/main',$data);
        }
    }  

    /*
     * Editing a oferta
     */
    function edit($id_oferta)
    {   
        // check if the oferta exists before trying to edit it
        $data['oferta'] = $this->Oferta_model->get_oferta($id_oferta);
        
        if(isset($data['oferta']['id_oferta']))
        {
            $this->load->library('form_validation');

			$this->form_validation->set_rules('valor_oferta','Valor Oferta','required');
			$this->form_validation->set_rules('tipo_oferta','Tipo Oferta','required');
			$this->form_validation->set_rules('fecha_inicio','Fecha Inicio','required');
			$this->form_validation->set_rules('fecha_fin','Fecha Fin','required');
			$this->form_validation->set_rules('color_oferta','Color Oferta','required');
			$this->form_validation->set_rules('descripcion_oferta','Descripcion Oferta','required');
			$this->form_validation->set_rules('id_bus','Id Bus','required');
		
			if($this->form_validation->run())     
            {   
                $params = array(
					'id_bus' => $this->input->post('id_bus'),
					'valor_oferta' => $this->input->post('valor_oferta'),
					'tipo_oferta' => $this->input->post('tipo_oferta'),
					'fecha_inicio' => $this->input->post('fecha_inicio'),
					'fecha_fin' => $this->input->post('fecha_fin'),
					'color_oferta' => $this->input->post('color_oferta'),
					'descripcion_oferta' => $this->input->post('descripcion_oferta'),
                );

                $this->Oferta_model->update_oferta($id_oferta,$params);            
                redirect('oferta/index');
            }
            else
            {
				$this->load->model('Bus_model');
				$data['all_buses'] = $this->Bus_model->get_all_buses();

                $data['_view'] = 'oferta/edit';
                $this->load->view('layouts/main',$data);
            }
        }
        else
            show_error('The oferta you are trying to edit does not exist.');
    } 

    /*
     * Deleting oferta
     */
    function remove($id_oferta)
    {
        $oferta = $this->Oferta_model->get_oferta($id_oferta);

        // check if the oferta exists before trying to delete it
        if(isset($oferta['id_oferta']))
        {
            $this->Oferta_model->delete_oferta($id_oferta);
            redirect('oferta/index');
        }
        else
            show_error('The oferta you are trying to delete does not exist.');
    }
    
}
