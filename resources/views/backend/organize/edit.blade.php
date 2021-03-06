@extends('backend.layouts.main')
@section('title', 'User')
@section('content')

@if (Session::has('msg_organization'))
   	<script type="text/javascript">
        $(function() {
            jAlert('{{Session::get("msg_organization")}}', 'Thông báo');
        });
   	</script>
@endif
<section class="content-header">
  <h1>
    {{-- {{ __('label.organize.organize_create') }} --}}
    {{ __('label.organize.edit_organization') }}
    <small>Control panel</small>
  </h1>
  <ol class="breadcrumb">
    <li><a href="{{route('backend.site.index')}}"><i class="fa fa-dashboard"></i> Home</a></li>
    <li class="active">
        {{-- {{ __('label.organize.organize_create') }} --}}
        {{ __('label.organize.edit_organization') }}
    </li>
  </ol>
</section>
<section class="content">
	{!! Form::open(['route' => ['organize.update', $organize->id] , 'method' => 'PUT' , 'id' => 'create_organize' , 'files' => true] ) !!}
        <input type="hidden" name="id" value="{{ $organize->id }}" />
        <div class="row">
			<div class="col-md-6">
				<div class="box box-primary">
					<div class="box-header with-border">
						@if(!empty($buttons))
							@include('backend.component.button_bar')
						@endif
						<h3 class="box-title" style="margin-top: 15px">{{ __('label.organize.general_information') }}</h3>
					</div>
						<div class="box-body">
							
							<div class="form-group">
								<label>{{ __('label.organize.type') }}</label>
								<select autocomplete="off" id="level" class="form-control" name="level">
									<option selected="selected" value="" disabled="disabled">{{ __('label.organize.type') }}</option>	
									<option {{ ($organize->level == "1") ? 'selected' : '' }} value="1">{{ __('label.organize.organizing_scientific_and_technological_department') }}</option>								
									<option {{ ($organize->level == "2") ? 'selected' : '' }} value="2">{{ __('label.organize.support_organization') }}</option>
									<option {{ ($organize->level == "3") ? 'selected' : '' }} value="3">{{ __('label.organize.expert_support') }}</option>
									<option {{ ($organize->level == "4") ? 'selected' : '' }} value="4">{{ __('label.organize.investment_funds') }}</option>
									<option {{ ($organize->level == "6") ? 'selected' : '' }} value="6">{{ __('label.organize.investors') }}</option>
									<option {{ ($organize->level == "5") ? 'selected' : '' }} value="5">{{ __('label.organize.startup') }}</option>
								</select>
							</div>   
							
							<div class="form-group">
								<label for="">{{ __('label.organize.name') }}</label>
                            <input class="form-control" name="name" value="{{ $organize->name }}" type="text">
							</div>
							
                            <input id="type" type="hidden" name="type" value="{{$organize->type}}" />

							<div class="form-group {{$errors->has('parent_id') ? 'has-error' : ''}}">
								<label>{{ __('label.organize.parent') }}</label><br/>
								<select class="form-control select2" id="parent_id" name="parent_id" style="width: 50%;">
									@foreach($listOrganization as $item)
										<option {{ ($organize->parent_id == $item->id) ? 'selected' : '' }} value="{{$item->id}}">{{$item->name}}</option>
									@endforeach
								</select>
								<span class="help-block">{{$errors->first("parent_id")}}</span>
							</div>
							
							<div class="form-group">
								<label>{{ __('label.organize.code') }}</label>
                                <input class="form-control" value="{{$organize->code}}" name="code" type="text">
							</div>
						</div>
					
				</div>
			</div>
			<!-- Thông tin riêng -->
			<div id="information" class="col-md-6">
				<div class="box box-success">
                    @if($organize->level == "1")
                        @include('backend.organize.includes.department_science_technology')
                    @elseif($organize->level == "2")
                        @include('backend.organize.includes.startup_support_organization')
                    @elseif($organize->level == "3")
                        @include('backend.organize.includes.startup_support_professional')
                    @elseif($organize->level == "4")
                        @include('backend.organize.includes.investment_funds')
                    @elseif($organize->level == "5")
						@include('backend.organize.includes.startup')
					@elseif($organize->level == "6")
                        @include('backend.organize.includes.investors')
                    @endif
				</div>
			</div>
		</div>
		<button type="submit" class="btn btn-primary"> {{ __('label.organize.edit_organization') }}</button>
	{!! Form::close() !!}
</section>
<script src="https://maps.googleapis.com/maps/api/js?key={{env('GOOGLE_MAP_KEY')}}&libraries=places&callback=googleInput" async defer></script>
<style>
	#select2-parent_id-container{
		margin-top: -7px !important;
	}
	input{
		border-radius: 4px !important;
	}
	.select2-selection__choice{
		background-color: #3c8dbc !important;
		border-color: #367fa9 !important;
		padding: 1px 10px !important;
		color: #fff !important;
	}
	.error{
		color: red;
	}
	.has-error{
		border-color: red;
	}
</style>
<script>
	var lang = '{{Loc::current()}}';
	$(document).ready(function() {
		$('.select2').select2();
		$("#level").change(function(){
			var level = $(this).find(":selected").val();
			$("#type").val($(this).find(":selected").text());
			var aURL = "{{ route('backend.loadhtml.organize') }}";
			$.ajax({
				'url': aURL,
				'method': 'GET',
				'dataType': 'JSON',
				'data': {
					level: level
				},
				success: function(data, textStatus, jqXHR) {
					$("#information .box-success").html(data.html);
					$("#name_organize").text(data.name);
					validateElementsVi();
					googleInput();
					addRules();
					$('.select2').select2();
				},
				error: function(textStatus, error, errorThrown) {
					location.reload();
				}
			});
		});

		validateElementsVi();
		
		//Validate
	});

	function addFounder(){
		var item = new Date().getTime();
		var aURL = "{{ route('backend.organize.addFounder') }}";
		$.ajax({
			'url': aURL,
			'method': 'GET',
			'dataType': 'HTML',
			'data': {
				item: item
			},
			success: function(data, textStatus, jqXHR) {
				$("#legal_representative_area").append(data);
				if($(".item_legal_representative_area").length > 1){
					$(".delete_representative").show();
				}else{
					$(".delete_representative").hide();
				}

				addRules();
			},
			error: function(textStatus, error, errorThrown) {
				
			}
		});
	}

	function deleteRepresentative(args){
		$("#"+args).remove();
		var length = $(".item_legal_representative_area").length;
		if($(".item_legal_representative_area").length > 1){
			$(".delete_representative").show();
		}else{
			$(".delete_representative").hide();
		}
	}

	function googleInput(){
        var map = new google.maps.Map(document.getElementById('map'), {
            center: {lat: -33.8688, lng: 151.2195},
            zoom: 13,
            mapTypeId: 'roadmap'
        });

        var input = document.getElementById('address_map');
        var searchBox = new google.maps.places.SearchBox(input);
		map.controls[google.maps.ControlPosition.TOP_LEFT].push(input);
		searchBox.addListener('places_changed', function() {
			var places = searchBox.getPlaces();
			if(places.length > 0){
				$("#lat").val(places[0].geometry.location.lat());
				$("#lng").val(places[0].geometry.location.lng());
			}
		})
        
    }  
	function validateElementsVi(){
		$("#create_organize").validate({
			rules: {
				name: {
					required: true,
				},
				type: {
					required: true,
				},
				code: {
					required: true,
				},
				address: {
					required: true,
				},
				tel: {
					required: true,
				},
				email: {
					required: true,
					email: true
				},
				legal_representative_name: {
					required: true,
				},
				total_current_capital: {
					required: true,
				},
				certificate: {
					required: true,
				},
				established_date: {
					required: true,
				},
				support_type: {
					required: true,
				},
				support_description: {
					required: true,
				},
				properties: {
					required: true,
				},
				people_type: {
					required: true,
				},
				business_areas: {
					required: true,
				},
				target_market: {
					required: true,
				},
				investment_status: {
					required: true,
				},
			},
			messages:{
				name: {
					required: "{{ __('validation.organize.name') }}",
				},
				type: {
					required: "{{ __('validation.organize.type') }}",
				},
				code: {
					required: "{{ __('validation.organize.code') }}",
				},
				address: {
					required: "{{ __('validation.organize.address') }}",
				},
				tel: {
					required: "{{ __('validation.organize.tel') }}",
				},
				email: {
					required: "{{ __('validation.organize.email') }}",
					email: "{{ __('validation.organize.email') }}"
				},
				total_current_capital: {
					required: "{{ __('validation.organize.total_current_capital') }}",
				},
				certificate: {
					required: "{{ __('validation.organize.certificate') }}",
				},
				established_date: {
					required: "{{ __('validation.organize.established_date') }}",
				},
				"support_type[]": {
					required: "{{ __('validation.organize.support_type') }}",
				},
				support_description: {
					required: "{{ __('validation.organize.support_description') }}",
				},
				//
				support_time: {
					required: "{{ __('validation.organize.support_time') }}"
				},
				costs: {
					required: "{{ __('validation.organize.costs') }}",
				},
				people_type: {
					required: "{{ __('validation.organize.people_type') }}",
				},
				business_areas: {
					required: "{{ __('validation.organize.business_areas') }}",
				},
				target_market: {
					required: "{{ __('validation.organize.target_market') }}",
				},
				outstanding_features: {
					required: "{{ __('validation.organize.outstanding_features') }}",
				},
				investment_status: {
					required: "{{ __('validation.organize.investment_status') }}",
				},
				properties: {
					required: "{{ __('validation.organize.properties') }}"
				},
				level: {
					required: "{{ __('validation.organize.level') }}"
				},
				legal_representative_name: {
					required: "{{ __('validation.organize.legal_representative_name') }}"
				}
			},
			errorPlacement: function(error, element) {
				if (element.attr("name") == "properties"){
					error.insertAfter("#properties");
				}else if(element.attr("name") == "investment_status"){
					error.insertAfter("#investment_status");
				}else if(element.attr("name") == "people_type"){
					error.insertAfter("#people_type");
				}else if(element.attr("name") == "target_market"){
					error.insertAfter("#target_market");
				}else if(element.attr("name") == "established_date"){
					error.insertAfter("#established_date");
				}else{
					error.insertAfter(element);
				}		
			},
			highlight: function (element, errorClass) {
        		$(element).closest('.form-control').addClass('has-error');
    		},
    		unhighlight: function (element, errorClass) {
       			 $(element).closest(".form-control").removeClass("has-error");
    		}
		});

		$('select[name^="support_type"]').each(function() {
			$(this).rules('add', {
				required: true,
				messages: {
					required: "Chọn loại hình hỗ trợ"
				}
			});
		});
	}

	function addRules(){
		$('[name*="legal_representative_name"]').each(function () {
			$(this).rules('add', {
				required: true,
				messages: {
					required: "{{ __('validation.organize.legal_representative_name') }}"
				}
			});
		});

		$('[name*="dob"]').each(function () {
			$(this).rules('add', {
				required: true,
				messages: {
					required: "{{ __('validation.organize.dob') }}"
				}
			});
		});
	}
</script>
@stop