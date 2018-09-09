@extends('backend.layouts.main')
@section('title', 'User')
@section('content')
@inject('sCommon', 'App\Http\Services\Common')
{{-- <div class="form-group">
    <input class="form-control" name="search" type="search">
</div> --}}
@if($type == 0)
	<h3 style="padding: 5px">{{__('label.organize.map_of_business')}}</h2>
@else
	<h3 style="padding: 5px">{{__('label.organize.map_the_startup_near_you')}}</h2>
@endif

@if($type == 0)
    <div class="row">
        <div class="col-sm-5 col-sm-offset-1" style="display: inline-flex">
            <div style="width: 20px;height: 20px; background: #fe7569"></div> {{ __('label.organize.support_organization') }}
        </div>
        <div class="col-sm-6" style="display: inline-flex">
            <div style="width: 20px;height: 20px; background: #2f36f0"></div> {{ __('label.organize.expert_support') }}
        </div>
    </div>
    <div class="row" style="margin-top: 10px">
        <div class="col-sm-5 col-sm-offset-1" style="display: inline-flex">
            <div style="width: 20px;height: 20px; background: #67f02f"></div> {{ __('label.organize.investment_funds') }}
        </div>
    
        <div class="col-sm-6" style="display: inline-flex">
            <div style="width: 20px;height: 20px; background: #f9f700"></div> {{ __('label.organize.investors') }}
        </div>
    </div>
@else
    <div class="row">
        <div class="col-sm-3 col-sm-offset-1" style="display: inline-flex">
            <div style="width: 20px;height: 20px; background: #fe7569"></div> {!! $sCommon->getDropdownName("et") !!}
        </div>
        <div class="col-sm-4" style="display: inline-flex">
            <div style="width: 20px;height: 20px; background: #639ba1"></div> {!! $sCommon->getDropdownName("ft") !!}
        </div>
        <div class="col-sm-4" style="display: inline-flex">
            <div style="width: 20px;height: 20px; background: #fea83f"></div> {!! $sCommon->getDropdownName("mt") !!}
        </div>
    </div>
    <div class="row" style="margin-top: 10px;">
        <div class="col-sm-3 col-sm-offset-1" style="display: inline-flex">
            <div style="width: 20px;height: 20px; background: #18b8b5"></div> {!! $sCommon->getDropdownName("at") !!}
        </div>
        <div class="col-sm-4" style="display: inline-flex">
            <div style="width: 20px;height: 20px; background: #2bb7da"></div> {!! $sCommon->getDropdownName("foodt") !!}
        </div>
        <div class="col-sm-4" style="display: inline-flex">
            <div style="width: 20px;height: 20px; background: #f351dc"></div> {!! $sCommon->getDropdownName("tot") !!}
        </div>
    </div>
    <div class="row" style="margin-top: 10px;">
        <div class="col-sm-3 col-sm-offset-1" style="display: inline-flex">
            <div style="width: 20px;height: 20px; background: #3421ce"></div> {!! $sCommon->getDropdownName("bt") !!}
        </div>
        <div class="col-sm-4" style="display: inline-flex">
            <div style="width: 20px;height: 20px; background: #0dd3c9"></div> {!! $sCommon->getDropdownName("tech") !!}
        </div>
        <div class="col-sm-4" style="display: inline-flex">
            <div style="width: 20px;height: 20px; background: #75f0b1"></div> {!! $sCommon->getDropdownName("tac") !!}
        </div>
    </div>
@endif

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
		var current = {!! json_encode($current->toArray()) !!};
		var lat = 21.022184;
		var lng = 105.796349;
		if(current != "" && current != null){
			lat = Number(current.lat);
        	lng = Number(current.lng);
		}
		if(lat == 0 || lng == 0){
		 	lat = 21.022184;
		 	lng = 105.796349;
		}
		mapObject = new google.maps.Map(document.getElementById('map'), {
			center: {lat: lat, lng: lng},
			zoom: 13
		});

		var jobs = {!! json_encode($listOrganize->toArray()) !!};
		for(var i = 0 ; i < jobs.length ; i++){
			addMarket(jobs[i] , mapObject);
		}
	}

    function addMarket(data , map){
        var lat = data.lat;
        var lng = data.lng;
		var name = data.name;
		var investment_sector = data.investment_sector;
		var data_inve = "";
		if(investment_sector != null){
			data_inve = "|"+investment_sector.substring(1);
		}
        var checkData = false;
        if(lat != undefined && lat != null && lat !== ""){
            lat = Number(lat);

            if(lng != undefined && lng != null && lng !== ""){
                checkData = true;
                lng = Number(lng);
            }
        }

		if(lat != undefined && lat != null && lat !== ""){
            lat = Number(lat);
        }
        
        var pinColor = "fe7569";
        @if($type == 0)
            if(data.level == 2){
                pinColor = "fe7569";
            }else if(data.level == 3){
                pinColor = "2f36f0";
            }else if(data.level == 4){
                pinColor = "67f02f";
            }else if(data.level == 6){
                pinColor = "f9f700";
            }
        @else
            var business_areas = data.business_areas.split(",")[0];
            if(business_areas == "et"){
                pinColor = "fe7569";
            }else if(business_areas == "ft"){
                pinColor = "639ba1";
            }else if(business_areas == "mt"){
                pinColor = "fea83f";
            }else if(business_areas == "at"){
                pinColor = "18b8b5";
            }else if(business_areas == "foodt"){
                pinColor = "2bb7da";
            }else if(business_areas == "tot"){
                pinColor = "f351dc";
            }else if(business_areas == "bt"){
                pinColor = "3421ce";
            }else if(business_areas == "tech"){
                pinColor = "0dd3c9";
            }else if(business_areas == "tac"){
                pinColor = "75f0b1";
            }
        @endif

        var pinImage = new google.maps.MarkerImage("http://chart.apis.google.com/chart?chst=d_map_pin_letter&chld=%E2%80%A2|" + pinColor);
        
        if(checkData){
            var marker = new google.maps.Marker({
                position: {
                    lat: lat,
                    lng: lng
                },
                icon: pinImage,
                map: map,
                title: name + data_inve
            });
        }
        
    }
</script>
@stop