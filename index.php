<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="initial-scale=1, maximum-scale=1, user-scalable=no">
    <title>Sorc [HTPS]</title>
    <!--Custom CSS and ArcGIS CSS-->
    <link rel="stylesheet" href="https://js.arcgis.com/4.19/esri/themes/light/main.css">
    <link rel="stylesheet" href="app/css/jquery-ui-themes-1.13.0/jquery-ui.css"/>
    <link rel="stylesheet" href="app/css/jquery-ui-themes-1.13.0/theme.ccs"/>
    <link rel="stylesheet" href="app/css/main.css">

    <script type="text/javascript" src="https://code.jquery.com/jquery-3.1.1.js"></script>
    <script type="text/javascript" src="app/js/jquery-ui.min.js"></script>
    <!--ArcJS-->
    <script src="https://js.arcgis.com/4.19/"></script>

    <!--Map Script-->
    <script>
        require([
            "esri/config",
            "esri/Map",
            "esri/views/MapView",
            "esri/Graphic",
            "esri/layers/TileLayer",
            "esri/layers/FeatureLayer"
        ], function (esriConfig, Map, MapView, Graphic, TileLayer, FeatureLayer) {

            esriConfig.apiKey = "AAPK3caf5416e071495dbef2b50c1a3d0b554SBBx6txR1NFhGOV9_urSjIkWoTXoAC4IRXbKuMHg6ezJlv_uqdr7nQiLTISDPa8";

            const roads = new TileLayer({
                url: "https://server.arcgisonline.com/arcgis/rest/services/Reference/World_Transportation/MapServer"
            });
            const worldref = new TileLayer({
                url: "https://server.arcgisonline.com/arcgis/rest/services/Reference/World_Reference_Overlay/MapServer"
            });
            const topo = new FeatureLayer({
                url: "https://server.arcgisonline.com/ArcGIS/rest/services/World_Topo_Map/MapServer"
            });
            //Map Variable/Grabs Base map
            const map = new Map({
                basemap: "hybrid", // Basemap layer
                layers: [roads]
            });
            map.layers.add(worldref);
            //Map view
            const view = new MapView({
                map: map,
                center: [-86.902, 38.8945],
                zoom: 15, // scale: 72223.819286
                container: "viewDiv",
                constraints: {
                    snapToZoom: false,
                }
            });

            // "Data" Layers
            const streetsLayerToggle = document.getElementById("streets");
            // Listen to the change event for the checkbox
            streetsLayerToggle.addEventListener("change", () => {
                roads.visible = streetsLayerToggle.checked;
            });

            const county = document.getElementById("county");
            // Listen to the change event for the checkbox
            county.addEventListener("change", () => {
                worldref.visible = county.checked;
            });

            //end Layers
            
        // City, ST Search Bar Functionality
        $('#search').submit(function(e) {
                e.preventDefault();
                $.ajax({
                    type: "POST",
                    url: 'app/script/forms.php',
                    data: $(this).serialize()
                }).then(
                    function(response)
                    {
                        var Data = JSON.parse(response);
                        if (Data.success == "1")
                        {
                            var message = JSON.parse(Data.message);
                            location.href = `#`;
                            const view = new MapView({
                                map: map,
                                center: [message.longitude, message.latitude],
                                scale: 72223.819286,
                                container: "viewDiv",
                                constraints: {
                                    snapToZoom: false,
                                }
                            });
                        }
                        else
                        {
                            alert('Invalid Credentials!');
                        }
                    },
                    function()
                    {
                        alert('There was some error!');
                    }
                );
             });

        });
    </script>
</head>

<body>
<div class="controllermenu">
    <img src="app/logo.png" class="logo"/>
    <div class="controller">
        <div class="inner">
        <form method="POST" id="search" action="app/script/forms.php">
            <input type="search" name="search" id="search" placeholder="Search..."/>
            <span class="icon"><i class="fa fa-search"></i></span>
        </form>
        </div>
    </div>
</div>

<div class="maps">
    <ul class="bMap">
        <li class="dropdown">
            Layers/Data
            <ul class="dropdown_menu">
                <li class="dropdown_item"><a href="#">World Reference </a><br><input type="checkbox" id="county" checked/></li>
                <li class="dropdown_item"><a href="#">Transportation </a><br><input type="checkbox" id="streets" checked/></li>
            </ul>
        </li>
        <li class="dropdown">
            Base map
            <ul class="dropdown_menu">
                <li class="dropdown_item"><a href="#">Topographic</a><br><input type="checkbox" id="topo" unchecked/></li>
                <li class="dropdown_item"><a href="#">Hybrid </a><br><input type="checkbox" id="hybrid" checked/></li>
                <li class="dropdown_item"><a href="#">OSM Light Gray </a><br><input type="checkbox" id="lgray" unchecked/></li>
                <li class="dropdown_item"><a href="#">OSM Dark Gray </a><br><input type="checkbox" id="dgray" unchecked/></li>
            </ul>
        </li>
    </ul>
</div>
<script>
    $("#search").autocomplete({
        source: 'app/script/cities.php'
    });
</script>
<div id="viewDiv">
</div>
</body>

</html>