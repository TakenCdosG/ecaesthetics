scnShortcodeMeta={
	attributes:[
		{
			label:"Toggle",
			id:"content",
			controlType:"tab-control"
		},
		{
		label:"Default Active",
		id:"active_toggle_item",
		help:"Choose the number of the toggle that should be active on default", 
		controlType:"select-control", 
		selectValues:['','1', '2', '3', '4', '5', '6'],
		defaultValue: '', 
		defaultText: 'none'
    }
		],
		disablePreview:true,
		customMakeShortcode: function(b){
				
			var a=b.data;
			var tabTitles = new Array();
			
			if(!a)return"";
			
			var c=a.content;
			var r= b.active_toggle_item;
			var k = b.keep_open;
			
			if(k == 'yes')
			{
				k = 'keep_open="false" ';
			}
			else
			{
				k='keep_open="true" ';
			}
			
			r = 'initial_open="'+r+'"';
			
			
			var g = ''; // The shortcode.
			
			for ( var i = 0; i < a.numTabs; i++ ) {
			
				var currentField = 'tle_' + ( i + 1 );

				if ( b[currentField] == '' ) {
				
					tabTitles.push( 'Toggle ' + ( i + 1 ) );
				
				} else {
				
					var currentTitle = b[currentField];
					
					currentTitle = currentTitle.replace( /"/gi, "'" );
					
					tabTitles.push( currentTitle );
				
				} // End IF Statement
			
			} // End FOR Loop
			
			g += '[accordion '+k+r+']<br/><br/>';
			
			for ( var t in tabTitles ) {
			
				g += '[accordion_unit title="' + tabTitles[t] + '"]' + tabTitles[t] + ' content goes here.[/accordion_unit] <br/><br/>';
			
			} // End FOR Loop

			g += '[/accordion]';

			return g
		
		}
};