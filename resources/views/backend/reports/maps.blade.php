@extends('backend.layouts.main')
@section('title', 'User')
@section('content')

{{-- <div class="form-group">
    <input class="form-control" name="search" type="search">
</div> --}}
<div class="row" style="padding-top: 50px">
    <div class="col-md-10 col-md-offset-1">
        <div id="map" style="height: 600px">
            </div>
    </div>
</div>
<script src="https://maps.googleapis.com/maps/api/js?key={{env('GOOGLE_MAP_KEY')}}&libraries=places&callback=initMap" async defer></script>
<script>
    var mapObject;
   
    function initMap(){
        mapObject = new google.maps.Map(document.getElementById('map'), {
            center: {lat: 21.022184, lng: 105.796349},
            zoom: 8
        });

        var jobs = {!! json_encode($market->toArray()) !!};
        for(var i = 0 ; i < jobs.length ; i++){
            addMarket(jobs[i] , mapObject);
        }
    }

    function addMarket(data , map){
        var lat = data.lat;
        var lng = data.lng;
        var checkData = false;
        if(lat != undefined && lat != null && lat !== ""){
            lat = Number(lat);

            if(lng != undefined && lng != null && lng !== ""){
                checkData = true;
                lng = Number(lng);
            }
        }
        
        if(checkData){
            var marker = new google.maps.Marker({
            position: {
                lat: lat,
                lng: lng
            },
            map: map,
            title: 'Hello World!'
            });
        }
        
    }
</script>
@stop