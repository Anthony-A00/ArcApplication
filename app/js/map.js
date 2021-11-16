require([
    "esri/config",
    "esri/Map",
    "esri/views/MapView",
    "esri/Graphic",
    "esri/layers/TileLayer",
    "esri/layers/FeatureLayer",
    "esri/widgets/BasemapToggle"
], function (esriConfig, Map, MapView, Graphic, TileLayer, FeatureLayer, BasemapToggle) {

    esriConfig.apiKey = "AAPK3caf5416e071495dbef2b50c1a3d0b554SBBx6txR1NFhGOV9_urSjIkWoTXoAC4IRXbKuMHg6ezJlv_uqdr7nQiLTISDPa8";

    //Map Variable/Grabs Base map
    const map = new Map({
        basemap: "hybrid",
        ground: "world-elevation"
    });
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
    //Layer Data

    const datas = new TileLayer({
        url: "https://server.arcgisonline.com/arcgis/rest/services/Reference/World_Transportation/MapServer"
    });
    const datawr = new TileLayer({
        url: "https://server.arcgisonline.com/arcgis/rest/services/Reference/World_Reference_Overlay/MapServer"
    });
    map.add(datawr);
    map.add(datas);

    //Layer Toggling

    //streets
    const streets = document.getElementById("streets");
    streets.addEventListener("change", () => {
        datas.visible = streets.checked;
    });

    //world ref
    const wr = document.getElementById("county");
    wr.addEventListener("change", () => {
        datawr.visible = wr.checked;
    });

    const basemapToggle = new BasemapToggle({
        view: view,
        nextBasemap: "topo"
    });
    view.ui.add(basemapToggle,"top-right");


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
