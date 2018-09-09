// Theme Panel
$( "#theme-panel .panel-button" ).click(function(){
	$( "#theme-panel" ).toggleClass( "close-theme-panel", "open-theme-panel", 1000 );
	$( "#theme-panel" ).toggleClass( "open-theme-panel", "close-theme-panel", 1000 );
	return false;
});

// Boxed
$( "#layout-config-boxed" ).click(function(){
	$( "html" ).toggleClass( "boxed" );
	initIsotopeGrid();
	return false;
});	

// Wide Mode
$( "#layout-config-wide" ).click(function(){
	$( "html" ).removeClass( "boxed" ).toggleClass( "wide" );
	initIsotopeGrid();
	return false;
});	



// Boxed Mode Backgrounds
function boxedMode(){
	$( "html" ).removeClass( "boxed-solid boxed-image boxed-pattern" );
}

// Boxed Mode Backgrounds
$( "#bg-config-color, #bg-config-pattern, #bg-config-image" ).click(function(){
	
	boxedMode();
	
	if($(this).attr('id') == 'bg-config-color' ){	
		$( "html.boxed" ).addClass( "boxed-solid" );
		
	}else if($(this).attr('id') == 'bg-config-pattern' ){
		$( "html.boxed" ).addClass( "boxed-pattern" );
		
	}else{
		$( "html.boxed" ).addClass( "boxed-image" );	
	}
	
	return false;
	
});	
