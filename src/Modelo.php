<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
date_default_timezone_set('America/Bogota');
require_once "Conexion.php";

class Modelo extends Conexion {

    public function __construct() {
        parent::__construct();
    }  
    
    public function ciudades() {
    
        $query = "SELECT * FROM worldcities where admin_name IS NOT NULL and admin_name <> '' order by city asc";                
        
        $result = $this->_db->query($query);
    
        try{
            $dataUser = $result->fetch_all(MYSQLI_ASSOC);
        } catch (\ErrorException $e){
            $dataUser = [];
        }
                     
        return $dataUser;
    }

    public function insertSearch($data) {
                
        $query = $this->_db->query('INSERT INTO searchcities (city_name, user_search_api) VALUES ("' . $data['name'] . '", "' . $data['user'] . '")');
        
        if ($query === TRUE) {
            $result['status'] = 1;
            $result['message'] = 'success';
        } else {
            $result['error'] = 1;            
            $result['message'] = $this->_db->error;            
        }
        
        return $result;
    }
    
        public function citySearch($data) {
                
        $query = "SELECT * FROM searchcities where city_name like '%".$data['city']."%'";
        
        $result = $this->_db->query($query);
    
        try{
            $dataUser = $result->fetch_all(MYSQLI_ASSOC);
        } catch (\ErrorException $e){
            $dataUser = [];
        }
                     
        return $dataUser;
    }
    
    
    
}