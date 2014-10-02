scnShortcodeMeta={
	attributes:[
		{
			label:"Slides",
			id:"content",
			controlType:"tab-control"
		}
		],
		disablePreview:true,
		customMakeShortcode: function(b){
				
			var a=b.data;
			var tabTitles = new Array();
			
			if(!a)return"";
			
			var c=a.content;
			var r= ' '+b.rotation;
			
			var g = ''; // The shortcode.
			
			for ( var i = 0; i < a.numTabs; i++ ) {
			
				var currentField = 'tle_' + ( i + 1 );

				if ( b[currentField] == '' ) {
				
					tabTitles.push( 'Slide ' + ( i + 1 ) );
				
				} else {
				
					var currentTitle = b[currentField];
					
					currentTitle = currentTitle.replace( /"/gi, "'" );
					
					tabTitles.push( currentTitle );
				
				} // End IF Statement
			
			} // End FOR Loop
			
			g += '[text_slider'+r+']<br/><br/>';
			
			for ( var t in tabTitles ) {
			
				g += '[text_slide title="' + tabTitles[t] + '"]' + tabTitles[t] + ' content goes here.[/text_slide] <br/><br/>';
			
			} // End FOR Loop

			g += '[/text_slider]';

			return g
		
		}
};