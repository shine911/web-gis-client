@extends('layouts/master_nosidebar')
@section('title', 'Web GIS Client')
@section('content')
    <div class="app-main__inner">
        <!-- 
        <div class="app-page-title">
            <div class="page-title-wrapper">
                <div class="page-title-heading">
                    <div class="page-title-icon">
                        <i class="pe-7s-map icon-gradient bg-premium-dark">
                        </i>
                    </div>
                    <div>Bản đồ
                        <div class="page-title-subheading">Bản đồ ĐHCT khu II
                        </div>
                    </div>
                </div>
            </div>
        </div>
        -->
        <div class="row">
            <div class="col-md-12">
                <div class="main-card mb-3 card">
                    <div class="card-body">
                        <div class="card-title">Bản đồ</div>
                        <div id="map" class="map"></div>
                        <div id="info"></div>
                         <div id="popup" class="ol-popup">
                           <a href="#" id="popup-closer" class="ol-popup-closer"></a>
                           <div id="popup-content"></div>
                         </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="https://ajax.aspnetcdn.com/ajax/jQuery/jquery-3.4.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/gh/openlayers/openlayers.github.io@master/en/v6.4.2/build/ol.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/blueimp-md5/2.17.0/js/md5.min.js" type="text/javascript"></script>
    <script type="text/javascript">
        var container = document.getElementById('popup');
        var content = document.getElementById('popup-content');
        var closer = document.getElementById('popup-closer');
        function encode(value){
            return md5(md5(md5(md5(md5(value)))));
        }
        console.log("Starting...");
    //https://qldiem.ctu.edu.vn/htql/quanly/webservices/getinfo.php?mode=$mode&value=$value&validate=$validate&time=$time
        function getinfodiadiem(madiadiem,mode){
            var mode_encode = encode(mode);
            var value_encode = encode(madiadiem);
            var time = Date.now()
            var validate = encode('qlph.'+value_encode+time);
            var data = $.ajax({
                type: 'GET',
                url: "https://qldiem.ctu.edu.vn/htql/quanly/webservices/getinfo.php?mode="+mode_encode+"&value="+value_encode+"&validate="+validate+"&time="+time+"",
                dataType: 'json',
                success: function(data) { jsonFile = data; },
                async: true
            });	
        }
        console.log("Creating Overlay...");
        var overlay = new ol.Overlay({
           element: container,
           autoPan: true,
           id:"overlay",
           autoPanAnimation: {
            duration: 250
           }
        });
        console.log("Get Json File...");
        //get JSON file from localhost
        var jsonFile=[];	
        var data = $.ajax({
            type: 'GET',
            url: "http://localhost:8000/diadiem.json",
            dataType: 'json',
            success: function(data) { jsonFile = data; },
            async: false
        });	
        if(jsonFile.length!=0){
            console.log("Get list ok!");
        }
        // set a styleFunction based on status's variable (on json file) condition 
        var sttURL='';	
        var styleFunction = function(feature) {
            
            for ( var j in jsonFile){
            
                if(feature.get('diadiem')===jsonFile[j].madiadiem && jsonFile[j].trangthai==="YES"){
                    sttURL='{{$app->make('url')->to('/')}}/images/icon_red.svg';
                    break;
                }
                else if(feature.get('diadiem')===jsonFile[j].madiadiem && jsonFile[j].trangthai==="NO"){
                    sttURL='{{$app->make('url')->to('/')}}/images/icon_blue.svg';
                    break;
                }
                else{
                    continue;
                }
            }
            return [new ol.style.Style({
                image: new ol.style.Icon({
                    anchor:[0.5,25],
                    anchorXUnits: 'fraction',
                    anchorYUnits: 'pixels',
                    opacity: 0.75,
                    src:sttURL
                })
            })];
        };
    
        //define layers
        var url0="http://localhost:8600/geoserver/ctu/wfs?service=WFS&version=1.1.0&request=GetFeature&typeName=ctu%3Acampus2_point&outputFormat=json";
        var vectorLayer = new ol.layer.Vector({
            source: new ol.source.Vector({
            format: new ol.format.GeoJSON(),
            url: url0
            }),
            style: styleFunction
        });
        
        var map = new ol.Map({
            overlays: [overlay],
            target: 'map',
            layers: [
              new ol.layer.Tile({
                source: new ol.source.OSM()
              }),
              vectorLayer
            ],
            
            view: new ol.View({
              center: ol.proj.fromLonLat([105.77, 10.03]),
              zoom: 17
            })
          });
          
          closer.onclick = function() {
            overlay.setPosition(undefined);
            closer.blur();
            return false;
          };
          
          map.on('click', function(evt) {
          
            var f = map.forEachFeatureAtPixel(
                evt.pixel,
                function(ft,layer){return ft;}
            );
            alert(f.values_.diadiem);
            getinfodiadiem(f.values_.diadiem,'hdnk');
            if (f && f.values_ && f.values_.diadiem) {				
                const info = jsonFile.find(function(point){
                    return point.madiadiem === f.values_.diadiem;
            });
            //SHOW POP UP INFO
                content.innerHTML = '<p>INFOMATION</p><code>DIA DIEM: ' + info.tendiadiem + 
                                    '<br>KHU VUC: ' + info.tenkhuvuc + 
                                    '<br>TRANG THAI: '+ info.trangthai + '</code>';
                overlay.setPosition(evt.coordinate);			
            } else { 
                //popup.hide(); 
            }		
        });
        </script>	
@endsection