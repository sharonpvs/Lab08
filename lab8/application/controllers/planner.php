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
        $this->data['title'] = 'Jim\'s Joint!';
        $this->data['pagebody'] = 'prompt';


        //get ports from xml document
        $stops = array();
        
        // get the xml ferry document
        $ferrytrip = simplexml_load_file('data/ferryschedule.xml');
        
        
        foreach($ferrytrip->ports->port as $stop)
        {
            $stops[] = array( 'port' => $stop['code'], 'name' => (string)$stop);
        }
     

        // and pass these on to the view
        $this->data['ports'] = $stops;
        $this->data['ports2'] = $stops;
        
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
            $this->data['sail'] = 
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
       
        
        
        $this->render();
    }

}

/* End of file planner.php */
/* Location: application/controllers/planner.php */