<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class Menuitems extends CI_Controller
{
    function __construct() {
        parent::__construct();
    }
    
    function index()
    {
        $this->load->library('xmlrpc');
        $this->load->library('xmlrpcs');

        $config['functions']['getItems'] = array('function' => 'Menuitem.getItems');
        $config['functions']['updateItems'] = array('function' => 'Menuitem.updateItems');
        $config['object'] = $this;

        $this->xmlrpcs->initialize($config);
        $this->xmlrpcs->serve();
    }
    
    function getItems()
    {
        $parameters = $request->output_parameters();

        $data = $this->menu->getItems();

        $response = array(
            $data,
            'struct'
        );
        return $this->xmlrpc->send_response($response);
    }
    
    function updateItems()
    {
        
    }
}