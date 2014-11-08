<?php

/**
 * XML-RPC for COMP4711 Lab 10
 * 
 */
class Remote extends CI_Controller {

    function __construct() {
        parent::__construct();
    }

    // Entry point to the XML-RPC server
    function index() {
        $this->load->library('xmlrpc');
        $this->load->library('xmlrpcs');

        $config['functions']['getBoroughs'] = array('function' => 'remote.getBoroughs');
        $config['functions']['getSales'] = array('function' => 'remote.getSales');
        $config['object'] = $this;

        $this->xmlrpcs->initialize($config);
        $this->xmlrpcs->serve();
    }

    // Return a list of boroughs
    function getBoroughs($request) {
        $parameters = $request->output_parameters();

        $data = array(
            '1' => 'Manhattan',
            '2' => 'Bronx',
            '3' => 'Brooklyn',
            '4' => 'Queens',
            '5' => 'Staten Island'
        );

        $response = array(
            $data,
            'struct'
        );
        return $this->xmlrpc->send_response($response);
    }

    // Return the sales for a specific borough
    function getSales($request) {
        $parameters = $request->output_parameters();
        $which = $parameters['0'];

        $sales = array(
            'units' => '100', 'min' => '100000', 'avg' => '123456', 'max' => '444444'
        );

        $response = array($sales, 'array');

        return $this->xmlrpc->send_response($response);
    }

}

/* End of file remote.php */
/* Location: ./application/controllers/remote.php */