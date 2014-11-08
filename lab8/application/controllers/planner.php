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
        $this->load->helper('formfields_helper');
        $this->data['title'] = 'Ferry Trip Planner!';
        $this->data['pagebody'] = 'prompt';


        // get all the ports from our model
        $ports = $this->ferryschedule->getPorts();
        
        //making view
        $this->data['leaving'] = makeComboField("Leaving from", "leaving", "TS", $ports);
        $this->data['destination'] = makeComboField("Destination", "destination", "LH", $ports);
        $this->data['submit'] = makeSubmitButton("Submit", "Submit");
                
        $this->render();
    }
 
    function display() {
        $this->data['pagebody'] = 'tripresult';
        $this->data['title'] = "Custom Travel Plan";
        
        
        $fields = $this->input->post(); // gives us an associative array
        
        // test the incoming fields
       
        if($fields['start'] == $fields['end'])
        {
            $this->errors[] = 'Sorry, but your start and end can\'t be the same stop';
        }
        
        
        // update if ok
        if (count($this->errors) < 1) {
            
            $trips = array();
            $stops = "";
            $ferrytrip = simplexml_load_file('data/ferryschedule.xml');
            $start = $fields['start'];
            $end   = $fields['end'];
            $count = 0;
            $name = "";
            
            foreach($ferrytrip->sailing as $trip)
            {
                foreach($trip->stop as $stop)
                {
                    //$name =  (string)$stop;
                    $stops .= $stop['port'] . ", "; 
                    
                    
                }
                $string = $trip['origin'] . " " . $trip['destination'];
               
                $trips[] = array(   'sail'  => $string,
                                    'depart' => $trip['depart'],  
                                    'arrive' => $trip['arrive'],
                                    'stops' => $stops
                                );
                
                $stops = "";
                
     
                
            }
            $this->data['sail'] = '';
            $this->data['start'] = $fields['start'];
            $this->data['end']   = $fields['end'];
            $this->data['trips'] = $trips;
            
             
            $this->render();
        } else {
            $this->index();
        }
    }
    function tripresult()
    {
        $this->data['pagebody'] = 'tripresult';
        $this->data['title'] = "Custom Travel Plan";
        
        $ports = $this->ferryschedule->getPorts();
        
	$origin = $ports[$this->input->post('leaving')];
        $depart = $ports[$this->input->post('destination')];
        
        $this->data['origin'] = $origin;
        $this->data['destination'] = $depart;
        
	$sailings = array();
        
	// get the result from the model
        $result = $this->ferryschedule->findSailings(
                  $this->input->post('leaving'), 
                  $this->input->post('destination'));
        
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

}

/* End of file planner.php */
/* Location: application/controllers/planner.php */