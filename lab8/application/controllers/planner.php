<?php

/**
 * Our homepage.
 * 
 * Present a summary of the completed orders.
 * 
 * controllers/planner.php
 *
 * ------------------------------------------------------------------------
 */
class Planner extends Application {

    function __construct() {
        parent::__construct();
    }

    //-------------------------------------------------------------
    //  The normal pages
    //-------------------------------------------------------------

    function index() {
        $this->load->library('xmlrpc');
        $this->load->helper('formfields_helper');
        $this->data['title'] = 'Ferry Trip Planner!';
        $this->data['pagebody'] = 'prompt';


        // get all the ports from our model
        $ports = $this->ferryschedule->getPorts();
        
        //xmlrpc client
        //$ports = $this->get_ports_remotely();

        //making view
        $this->data['leaving'] = makeComboField("Leaving from", "leaving", "TS", $ports);
        $this->data['destination'] = makeComboField("Destination", "destination", "LH", $ports);
        $this->data['submit'] = makeSubmitButton("Submit", "Submit");
                
        $this->render();
    }
 
    function tripresult()
    {
        $this->data['pagebody'] = 'tripresult';
        $this->data['title'] = "Custom Travel Plan";
        
        $ports = $this->ferryschedule->getPorts();
        
        //xml rpc
        //$ports = $this->get_ports_remotely();
        
	$origin = $ports[$this->input->post('leaving')];
        $depart = $ports[$this->input->post('destination')];
        
        $this->data['origin'] = $origin;
        $this->data['destination'] = $depart;
        
	$sailings = array();
        
	// get the result from the model
        //$result = $this->ferryschedule->findSailings(
        //$this->input->post('leaving'), 
        // $this->input->post('destination'));
        
        $result = $this­>get_trips_remotely(post('leaving'), post('destination'));

        
	// add each result to our sailings array
        foreach($result as $sailing) 
	{
            $sailings[] = $sailing;
        }
        
	// display an error if there are no sailings
        if (empty($sailings)) 
	{
            $this->errors[] = "Sorry, but you can't get there from here!";
        }
        $this->data['sailings'] = $sailings;
        
        $this->render();
    }

    function get_ports_remotely() 
    {
        $ports = array();
        $from  = 'LH';
        $to    = 'TS';
        
        $this->xmlrpc->server($server_url, $port);
        
        //still
        $this->xmlrpc->method('getPorts');

        $request = array($from, $to);
        
        $this->xmlrpc->request($request);

        if (!$this->xmlrpc->send_request()) {
            echo $this->xmlrpc->display_error();
        }
        $ports = $this->xmlrpc->display_response();
        
        return $ports;
    }
}



/* End of file planner.php */
/* Location: application/controllers/planner.php */