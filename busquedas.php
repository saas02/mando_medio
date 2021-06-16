
<?php
session_start();
ini_set("xdebug.var_display_max_children", -1);
ini_set("xdebug.var_display_max_data", -1);
ini_set("xdebug.var_display_max_depth", -1);

if (isset($_GET['city']) && !empty($_GET['city'])) {
    require_once 'src/CitiesData.php';
    $citiesData = new CitiesData();
    $cities = $citiesData->citySearch($_GET);
    echo json_encode($cities);
} else {
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

            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            <b>Consultar Busquedas de Ciudades</b>
            <table>
                <tr>
                    <td>
                        <?php include('select.php') ?>
                </td>
                <tr>
                    <td>
                        <div id="data" name="data">
                            
                        </div>
                    </td>
                </tr>
            </tr>
        </table>

        <script>

            $('#ciudades').change(function () {
                var data = JSON.parse($(this).val());
                var method = 'GET';
                var url = 'busquedas.php';
                var parameters = {'city': data.city};

                $.ajax({
                    url: url + '?' + $.param(parameters),
                    method: method,
                    success: function (data) {
                        console.log(data);
                        var data = JSON.parse(data);
                        var infoData = '';
                        for (var i = 0; i < data.length; i++) {
                            infoData += data[i].city_name + " - " + data[i].date_search + "<br/>";                            
                        }
                        $('#data').html(infoData);
                    }
                });
            });
        </script>
    </body>
</html>
<?php
}



