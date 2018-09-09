@extends('backend.layouts.main')
@section('title', 'User')
@section('content')
<script src="{{asset('backend/dist/js/canvasjs.min.js')}}"></script>
<script src="{{asset('backend/dist/js/jquery.canvasjs.min.js')}}"></script>
<div id="chart_business_areas" style="height: 300px; width: 100%;"></div>
<div id="chart_investment_sector" style="height: 300px; width: 100%;margin-top: 15px"></div>
<div id="chart_startup" style="height: 300px; width: 100%;margin-top: 15px"></div>
<div id="chartContainer" style="height: 300px; width: 100%;margin-top: 15px"></div>
<script>
    var chart_1 = {!! json_encode( $business_areas) !!};
    
    window.onload = function () {

        var chart_business_areas = new CanvasJS.Chart("chart_business_areas", {
            exportEnabled: true,
            animationEnabled: true,
            title:{
                text: "{{ __('label.organize.chart_fields_of_startups') }}",
                fontFamily: "tahoma",
            },
            legend:{
                cursor: "pointer",
                itemclick: explodePie
            },
            data: [{
                type: "pie",
                showInLegend: true,
                toolTipContent: "{name}: <strong>{y}%</strong>",
                indexLabel: "{name} - {y}%",
                dataPoints: chart_1
            }]
        });

        chart_business_areas.render();
        

        var chart_investment_sector_data = {!! json_encode( $investment_sector) !!};
        var chart_investment_sector = new CanvasJS.Chart("chart_investment_sector", {
            exportEnabled: true,
            animationEnabled: true,
            title:{
                text: "{{ __('label.organize.chart_investment_sector') }}",
                fontFamily: "tahoma",
            },
            legend:{
                cursor: "pointer",
                itemclick: explodePie
            },
            data: [{
                type: "pie",
                showInLegend: true,
                toolTipContent: "{name}: <strong>{y}%</strong>",
                indexLabel: "{name} - {y}%",
                dataPoints: chart_investment_sector_data
            }]
        });

        chart_investment_sector.render();
    }

    //start up
    var chart_startup_data = {!! json_encode( $startup) !!};
    var chart_startup = new CanvasJS.Chart("chart_startup", {
        animationEnabled: true,
        title:{
            fontFamily: "tahoma",
            text: "{{ __('label.organize.count_startup') }}",   
        },
        axisX:{
            includeZero: true,
            interval: 1
        },
        data: [{       
            xValueType: "number",
            type: "line",   
            dataPoints: chart_startup_data
        }]
    });
    chart_startup.render();

    //Biểu đồ 4
    var char_4_1 = {!! json_encode( $char_4_1) !!};
    var char_4_2 = {!! json_encode( $char_4_2) !!};
    var char_4_3 = {!! json_encode( $char_4_3) !!};
    var char_4_4 = {!! json_encode( $char_4_4) !!};
    var chart = new CanvasJS.Chart("chartContainer", {
        title: {
            fontFamily: "tahoma",
            text: "{{ __('label.organize.char_4')}}"
        },
        axisX:{
            includeZero: true,
            interval: 1
        },
        toolTip: {
            shared: true
        },
        legend: {
            cursor: "pointer",
            verticalAlign: "top",
            horizontalAlign: "center",
            dockInsidePlotArea: true,
            itemclick: toogleDataSeries
        },
        data: [{
            type:"line",
            axisYType: "secondary",
            name: "{{ __('label.organize.support_organization') }}",
            showInLegend: true,
            markerSize: 0,
            dataPoints: char_4_1
        },
        {
            type: "line",
            axisYType: "secondary",
            name: "{{ __('label.organize.expert_support') }}",
            showInLegend: true,
            markerSize: 0,
            dataPoints: char_4_2
        },
        {
            type: "line",
            axisYType: "secondary",
            name: "{{ __('label.organize.investment_funds') }}",
            showInLegend: true,
            markerSize: 0,
            dataPoints: char_4_3
        },
        {
            type: "line",
            axisYType: "secondary",
            name: "{{ __('label.organize.investors') }}",
            showInLegend: true,
            markerSize: 0,
            dataPoints: char_4_4
        }]
    });

    chart.render();

function toogleDataSeries(e){
	if (typeof(e.dataSeries.visible) === "undefined" || e.dataSeries.visible) {
		e.dataSeries.visible = false;
	} else{
		e.dataSeries.visible = true;
	}
	chart.render();
}


    function explodePie (e) {
        if(typeof (e.dataSeries.dataPoints[e.dataPointIndex].exploded) === "undefined" || !e.dataSeries.dataPoints[e.dataPointIndex].exploded) {
            e.dataSeries.dataPoints[e.dataPointIndex].exploded = true;
        } else {
            e.dataSeries.dataPoints[e.dataPointIndex].exploded = false;
        }
        e.chart.render();

    }



</script>
@stop