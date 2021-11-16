<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="initial-scale=1, maximum-scale=1, user-scalable=no">
    <title>Sorc Simple Map Application</title>
    <!--Custom CSS and ArcGIS CSS-->
    <link rel="stylesheet" href="https://js.arcgis.com/4.19/esri/themes/light/main.css">
    <link rel="stylesheet" href="app/css/jquery-ui-themes-1.13.0/jquery-ui.css"/>
    <link rel="stylesheet" href="app/css/main.css">
    <script type="text/javascript" src="https://code.jquery.com/jquery-3.1.1.js"></script>
    <!--ArcJS-->
    <script src="https://js.arcgis.com/4.19/"></script>
    <script src="app/js/map.js"></script>
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
    </ul>
</div>
<div id="viewDiv">
</div>
</body>

</html>
