<?php defined('SYSTEM_INIT') or die('Invalid Usage.');
$shopFrm->setFormTagAttribute('onsubmit', 'setupShop(this); return(false);');
$shopFrm->setFormTagAttribute('class', 'form form--horizontal');

$shopFrm->developerTags['colClassPrefix'] = 'col-lg-4 col-md-';
$shopFrm->developerTags['fld_default_col'] = 4;

$countryFld = $shopFrm->getField('shop_country_id');
$countryFld->setFieldTagAttribute('id', 'shop_country_id');
$countryFld->setFieldTagAttribute('onChange', 'getCountryStates(this.value,'.$stateId.',\'#shop_state\')');

$stateFld = $shopFrm->getField('shop_state');
$stateFld->setFieldTagAttribute('id', 'shop_state');

$stateFld = $shopFrm->getField('shop_state');
$stateFld->setFieldTagAttribute('id', 'shop_state');
$stateFld->setFieldTagAttribute('onChange', 'getCountryStatesCities(\'#shop_country_id\', this.value, '. $cityId.' ,\'#shop_city_id\')');

$cityFld = $shopFrm->getField('shop_city_id');
$cityFld->setFieldTagAttribute('id', 'shop_city_id');

$latitudeFld = $shopFrm->getField('shop_latitude');
$latitudeFld->setFieldTagAttribute('id', 'shop_latitude');

$longitudeFld = $shopFrm->getField('shop_longitude');
$longitudeFld->setFieldTagAttribute('id', 'shop_longitude');


$fld = $shopFrm->getField('map_html');
$fld->setWrapperAttribute('class', 'col-lg-12');
$fld->developerTags['col'] = 12;                       
     
$getPositionFld = $shopFrm->getField('btn_position');
$getPositionFld->setFieldTagAttribute('onclick', "codeAddress()");
                      
$urlFld = $shopFrm->getField('urlrewrite_custom');
$urlFld->setFieldTagAttribute('id', "urlrewrite_custom");
$urlFld->setFieldTagAttribute('onkeyup', "getSlugUrl(this,this.value)");
$urlFld->htmlAfterField = "<p class='note' id='shopurl'>" . CommonHelper::generateFullUrl('Shops', 'View', array($shop_id), '/').'</p>';
$IDFld = $shopFrm->getField('shop_id');
$IDFld->setFieldTagAttribute('id', "shop_id");
$identiFierFld = $shopFrm->getField('shop_identifier');
$identiFierFld->setFieldTagAttribute('onkeyup', "Slugify(this.value,'urlrewrite_custom','shop_id','shopurl')");
$variables= array('language'=>$language,'siteLangId'=>$siteLangId,'shop_id'=>$shop_id,'action'=>$action);
$this->includeTemplate('seller/_partial/shop-navigation.php', $variables, false); ?>
<div class="cards">
    <div class="cards-content pt-3 pl-4 pr-4 ">
        <div class="tabs__content">
            <div class="row">
                <div class="col-lg-12 col-md-12" id="shopFormBlock"> <?php echo $shopFrm->getFormHtml(); ?> </div>
            </div>
        </div>
    </div>
</div>
<script language="javascript">
    $(document).ready(function() {
        getCountryStates($("#shop_country_id").val(), <?php echo $stateId ;?>, '#shop_state', '#shop_city_id');
		getCountryStatesCities("#shop_country_id", <?php echo $stateId ;?>, <?php echo $cityId ;?>, '#shop_city_id');
    });
    
    
    
    setTimeout(addBasedOnLatitudeLongitude, 1000);
    var map = false;
    var infowindow = false;
    var marker = false;
    var geocoder = false;
    var stateName = '';
    var current_address = '';
    var confirmMapText = 'Please click on Confirm Location button';

    function addBasedOnLatitudeLongitude() {
        $('.map-wrap').find('.error').remove();
        var myOptions = {
            zoom: 10,
            mapTypeId: google.maps.MapTypeId.ROADMAP
        };
        map = new google.maps.Map(document.getElementById("shop_map"), myOptions);
        if (!geocoder) {
            geocoder = new google.maps.Geocoder();
        }
        
        markerObj = {
                map: map,
                draggable: true,
                animation: google.maps.Animation.DROP,
            };
        
        var lat = parseFloat(document.getElementById("shop_latitude").value);
        var lng = parseFloat(document.getElementById("shop_longitude").value);
        
        var flag = 1
        if (lat != '' && lng != '') {
            var latlng = new google.maps.LatLng(lat, lng);
            var geocoder = geocoder = new google.maps.Geocoder();
            geocoder.geocode({ 'latLng': latlng }, function (results, status) {
        
                $('.map-wrap').find('.error').remove();
                if (status == google.maps.GeocoderStatus.OK) {
                    flag = 0;
                    addListnerAndMarker(results, markerObj);
                } else {
                    flag = 1;
                }
            });
        }
        
        if (flag == 1) {
            codeAddress();
        }
        
    }
    
    function codeAddress() 
    {
        $('.map-wrap').find('.error').remove();
        var myOptions = {
            zoom: 10,
            mapTypeId: google.maps.MapTypeId.ROADMAP
        };
        map = new google.maps.Map(document.getElementById("shop_map"), myOptions);
        if (!geocoder) {
            geocoder = new google.maps.Geocoder();
        }
        
        markerObj = {
                map: map,
                draggable: true,
                animation: google.maps.Animation.DROP,
            };       
                
        current_address = getAddress();
        geocoder.geocode({'address': current_address}, function (results, status) {
            if (status == google.maps.GeocoderStatus.OK) {
                addListnerAndMarker(results, markerObj);
            } else {
                var element = document.getElementById("shop_country_id");
                var value = (element.selectedIndex == -1) ? "" : element.options[element.selectedIndex].text;
                current_address = value;
                geocoder.geocode({'address': current_address}, function (results, status) {
                    $('.map-wrap').find('.error').remove();
                    if (status == google.maps.GeocoderStatus.OK) {
                        addListnerAndMarker(results, markerObj);
                    }
                });
            }
        });

    }
    
    function addListnerAndMarker(results, markerObj) 
    {
        place = results[0];
        if (typeof (place) !== "undefined") {
            markerObj.position = place.geometry.location;
            markerObj.title = place.formatted_address;
            map.setCenter(place.geometry.location);

            if (typeof (place.geometry.location) !== "undefined") {
                $('#shop_latitude').val(place.geometry.location.lat( ));
                $('#shop_longitude').val(place.geometry.location.lng( ));
                $submitAddress = true;
            }
            if (marker) {
                marker.setMap(null);
            }
            marker = new google.maps.Marker(markerObj);
            google.maps.event.addListener(marker, 'dragend', function () {
                geocodePosition(marker.getPosition( ));
            });
            marker.addListener('click', function ( ) {
                changeInfiWindow(map, marker);
            });
        }
    }
    
    function geocodePosition(pos) 
    {
        geocoder = new google.maps.Geocoder( );
        geocoder.geocode({latLng: pos}, function (results, status) {
            if (status != google.maps.GeocoderStatus.OK) {
                $('#shop_latitude, #shop_longitude').val('');
                return;
            }
            place = results[0];
            if (typeof (place) == "undefined") {
                $('#shop_latitude, #shop_longitude').val('');
                return;
            }
            current_address = place.formatted_address
            if (typeof (place.geometry.location) == "undefined") {
                $('#shop_latitude, #shop_longitude').val('');
                return;
            }
            getAddressComponent(place.address_components);
            $('#shop_latitude').val(place.geometry.location.lat( ));
            $('#shop_longitude').val(place.geometry.location.lng( ));
            changeInfiWindow(map, marker);
        });
    }
    
    function getAddress() 
    {
        var ids = ['shop_city_id', 'shop_state', 'shop_country_id'];
        var address = '';
        ids.forEach(function (id, key) {
            if (document.getElementById(id)) {
                var element = document.getElementById(id);
                if (id == 'shop_city_id' || id == 'shop_state' || id == 'shop_country_id') {
                    var value = (element.selectedIndex == -1) ? "" : element.options[element.selectedIndex].text;
                } else {
                    var value = document.getElementById(id).value;
                }
                if (value) {
                    address += (address) ? ', ' + value : value;
                }
            }
        });
        return address;
    }
    
    function changeInfiWindow(map, marker)
    {
        contentString = '<div id="google_map_address">' + current_address + '</div>';
        if (infowindow)
            infowindow.close();
        infowindow = new google.maps.InfoWindow({content: contentString});
        infowindow.open(map, marker);
    }
    
    function getAddressComponent(addressObj) 
    {
        if (typeof addressObj != 'object')
            return false;
        var address1 = '';
        var address2 = '';
        var city = '';
        var state = '';
        var country = '';
        var zipcode = '';
        var state_code = '';
        var country_id = '';
        var city_id = '';
        addressObj.forEach(function (addressElement, index) {
            if (typeof addressElement != 'object')
                return false;
            if (!addressElement.hasOwnProperty('types'))
                return false;
            if (typeof addressElement.types != 'object')
                return false;
            if (addressElement.types.length <= 0)
                return false;
            if (addressElement.types.indexOf("premise") !== -1 || addressElement.types.indexOf("sublocality") !== -1 || addressElement.types.indexOf("route") !== -1 || addressElement.types.indexOf("street_number") !== -1 || addressElement.types.indexOf("neighborhood") !== -1) {
                address1 += ((address1 != '') ? ', ' + addressElement.long_name : addressElement.long_name);
            } else if (addressElement.types.indexOf("locality") !== -1) {
                address2 += ((address2 != '') ? ', ' + addressElement.long_name : addressElement.long_name);
            } else if (addressElement.types.indexOf("administrative_area_level_2") !== -1) {
                city = addressElement.long_name;
            } else if (addressElement.types.indexOf("administrative_area_level_1") !== -1) {
                state = addressElement.long_name;
                state_code = addressElement.short_name;
            } else if (addressElement.types.indexOf("country") !== -1) {
                country = addressElement.long_name;
            } else if (addressElement.types.indexOf("postal_code") !== -1) {
                zipcode = addressElement.long_name;
            }
        });

        $("#shop_country_id option").each(function () {
            if ($(this).text() == country) {
                $(this).attr('selected', 'selected');
                country_id = $(this).val();
            }
        });
        getCountryStates(country_id, 0, '#shop_state', state_code, state, city)
        return true;
    }
    
</script>
