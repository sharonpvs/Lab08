<?php

/**
 * XML-RPC for COMP4711 Lab 10
 * 
 */
class Schedules extends CI_Controller {

    function __construct() {
        parent::__construct();
    }

    // Entry point to the XML-RPC server
    function index() 
    {
        $this->load->library('xmlrpc');
        $this->load->library('xmlrpcs');

        $config['functions']['getPorts'] = array('function' => 'schedules.getPorts');
        $config['functions']['findSailings'] = array('function' => 'schedules.findSailings');
        $config['object'] = $this;

        $this->xmlrpcs->initialize($config);
        $this->xmlrpcs->serve();
    }

    // Return a list of ports
    function getPorts($request)
    {
        $parameters = $request->output_parameters();

        $data = $this->ferryschedule->getPorts();

        $response = array(
            $data,
            'struct'
        );
        return $this->xmlrpc->send_response($response);
    }

    // Return the the sailing trips for the custom trip plan
    function findSailings($request)
    {
        $parameters = $request->output_parameters();
        $which = $parameters['0'];
        $whic2 = $parameters['1'];

        $data = $this->ferryschedules->findSailings($which, $whic2);

        $response = array(
                        $data,
                        'array'
                    );

        return $this->xmlrpc->send_response($response);
    }

}

/* End of file remote.php */
/* Location: ./application/controllers/remote.php */