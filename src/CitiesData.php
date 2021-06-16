<?php

require_once 'Modelo.php';

class CitiesData {
    
    public function consultarCiudades(){
        $modelo = new modelo();
        
        $ciudadesResult = [];
        
        try{                        
            foreach($modelo->ciudades() as $key => $ciudades){
                $ciudadesResult[$key]['name'] = $ciudades['city'];
                $ciudadesResult[$key]['data'] = json_encode($ciudades);
            }
        }catch(\Exception $e){
            $ciudadesResult = [];
        }        
        
        return $ciudadesResult;
                     
    }        
    
    public function insertSearch($post) {
        $modelo = new modelo();
        
        try{                        
            $searchInsert = $modelo->insertSearch($post);
        }catch(\Exception $e){
            $searchInsert = [];
        }        
        
        return $searchInsert;
                
    }     
    
    public function citySearch($post) {
        $modelo = new modelo();
        
        try{                        
            $searchInsert = $modelo->citySearch($post);
        }catch(\Exception $e){
            $searchInsert = [];
        }        
        
        return $searchInsert;
                
    }     
    
    

}
