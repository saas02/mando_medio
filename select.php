<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
require_once 'src/CitiesData.php';
$citiesData = new CitiesData();
$cities = $citiesData->consultarCiudades();
?>

<section class="pb-5">                        
    <div class="container">
        <div class="row">
            <div class="col-lg-6">
                <div class="card border-0">                                        
                    <div class="card-body p-0">                                            
                        <select id="ciudades" name="ciudades" class="selectpicker form-control border-0 mb-1 px-4 py-4 rounded shadow">
                            <option>Seleccione</option>
                            <?php
                            if (!empty($cities)) {
                                foreach ($cities as $key => $city) {
                                    $selected = ($city['name'] == 'Miami') ? 'selected' : '';
                                    echo "<option " . $selected . " value='" . $city['data'] . "'>" . $city['name'] . "</option>";
                                }
                            }
                            ?> 
                        </select>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
