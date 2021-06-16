<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<?php
session_start();
ini_set("xdebug.var_display_max_children", -1);
ini_set("xdebug.var_display_max_data", -1);
ini_set("xdebug.var_display_max_depth", -1);

?>
<html>    
    <head>
        <title>Prueba - Sergio Amaya</title>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <style>
            #mapid { 
                height: 300px; 
            }
        </style>        
        <link rel="stylesheet" href="https://unpkg.com/leaflet@1.7.1/dist/leaflet.css" integrity="sha512-xodZBNTC5n17Xt2atTPuE1HxjVMSvLVW9ocqUKLsCC5CXdbqCmblAshOMAS6/keqq/sMZMZ19scR4PsZChSR7A==" crossorigin="">
        <link rel="stylesheet" href="pub/bootstrap.min.css">
        <link rel="stylesheet" href="pub/choices.min.css">
        <link rel="stylesheet" href="pub/font-awesome.min.css">        

        <script src="https://unpkg.com/leaflet@1.7.1/dist/leaflet.js" integrity="sha512-XQoYMqMTK8LvdxXYG3nZ448hOEQiglfqkJs1NOQV44cWnUrBc8PkAOcXy20w0vlaXaVUearIOBhiXZ5V3ynxwA==" crossorigin=""></script>
        <script src="https://code.jquery.com/jquery-3.6.0.js" integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk=" crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/crypto-js/3.1.9-1/crypto-js.js"></script>

        <script src="pub/choices.min.js"></script>
        <script src="pub/bootstrap.bundle.min.js"></script>
    </head>
    <body>
        
        <div id="mapid"></div>        
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        <b>Consultar Ciudades</b>
        <table>
            <tr>
                <td>
                    <?php include('select.php') ?>
                </td>
            </tr>
            <tr>
                <td>
                    <section class="pb-5">                        
                        <div class="container">
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="card border-0">                                        
                                        <div class="card-body p-0"> 
                                            <a href="busquedas.php" target="_blank">Consultar Busquedas</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </section>
                </td>
            </tr>
        </table>
        
        <script>
            $(document).ready(function() {
                $('#ciudades').trigger('change');
            });
            
            var map = L.map('mapid').setView([40.7751, -80.2105], 3);

            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
            }).addTo(map);

            var LeafIcon = L.Icon.extend({
                options: {
                    iconSize: [38, 38]
                }
            });

            var icon = new LeafIcon({iconUrl: 'pub/logo.png'});            
            
            $('#ciudades').change(function () {
                var datos = JSON.parse($(this).val());
                var appId = '2e9355f535431279bc7320ae290d2010';
                var method = 'GET';
                var url = 'http://api.openweathermap.org/data/2.5/weather';
                var parameters = {'lat': datos.lat, 'lon': datos.lng, 'appid': appId, 'city' : datos.city};
                var markers = [];
                $(".leaflet-marker-icon").remove();
                $(".leaflet-popup").remove();
                $.ajax({
                    url: url + '?' + $.param(parameters),
                    method: method,
                    success: function (data) {
                        markers.push(data.coord.lat);
                        markers.push(data.coord.lon);
                        var message = "Ciudad: " + data.name + "<br>";
                        message += "Clima: " + data.weather[0].description + "<br>";
                        message += "Velocidad del Viento: " + data.wind.speed;
                        L.marker(markers, {icon: icon}).bindPopup(data.name).addTo(map);
                        L.popup()
                                .setLatLng(markers)
                                .setContent(message)
                                .openOn(map);
                        var url = 'searchSave.php';
                        var parameters = {'name': datos.city, 'user': appId};
                        $.ajax({
                            url: url + '?' + $.param(parameters),
                            method: method,
                            success: function (data) {
                                
                            }
                        });
                    }
                });


                /*Inicio Codigo realizado para el API Solicitada*/
//                var url = 'http://weather-ydn-yql.media.yahoo.com/forecastrss';
//                var method = 'GET';
//                var app_id = 'V4N5AV9Q';
//                var consumer_key = 'dj0yJmk9S3d1a0trSEFMbXo4JmQ9WVdrOVZqUk9OVUZXT1ZFbWNHbzlNQT09JnM9Y29uc3VtZXJzZWNyZXQmc3Y9MCZ4PTMy';
//                var consumer_secret = '605656af2b6fc646880cf479c5d8d736d3bf066f';
//                var concat = '&';
//                var query = {'lat': data.latitud, 'lon': data.longitud,'format': 'json'};
//                var oauth = {
//                    'oauth_consumer_key': consumer_key,
//                    'oauth_nonce': Math.random().toString(36).substring(2),
//                    'oauth_signature_method': 'HMAC-SHA1',
//                    'oauth_timestamp': parseInt(new Date().getTime() / 1000).toString(),
//                    'oauth_version': '1.0'
//                };
//
//                var merged = {};
//                $.extend(merged, query, oauth);
//    
//                var merged_arr = Object.keys(merged).sort().map(function (k) {
//                    return [k + '=' + encodeURIComponent(merged[k])];
//                });
//                var signature_base_str = method
//                        + concat + encodeURIComponent(url)
//                        + concat + encodeURIComponent(merged_arr.join(concat));
//
//                var composite_key = encodeURIComponent(consumer_secret) + concat;
//                var hash = CryptoJS.HmacSHA1(signature_base_str, composite_key);
//                var signature = hash.toString(CryptoJS.enc.Base64);
//
//                oauth['oauth_signature'] = signature;
//                var auth_header = 'OAuth ' + Object.keys(oauth).map(function (k) {
//                    return [k + '="' + oauth[k] + '"'];
//                }).join(',');
//
//                $.ajax({
//                    url: url + '?' + $.param(query),
//                    headers: {
//                        'Authorization': auth_header,
//                        'X-Yahoo-App-Id': app_id
//                    },
//                    method: 'GET',
//                    success: function (data) {
//                        console.log(data);
//                    }
//                });

                /* FIN Codigo realizado para el API Solicitada */
            });



        </script>
    </body>
</html>

