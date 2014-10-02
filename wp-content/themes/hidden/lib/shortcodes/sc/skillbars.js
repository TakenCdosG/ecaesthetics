scnShortcodeMeta={
    attributes:[
        {
            label:"Skill bars",
            id:"content",
            controlType:"skills-control"
        }
    ],
    disablePreview:true,
    customMakeShortcode: function(b){

        var a=b.data;
        var tabTitles = new Array();
        var dataPercentage = new Array();

        if(!a)return"";

        var c=a.content;

        var g = ''; // The shortcode.

        for ( var i = 0; i < a.numTabs; i++ ) {

            var currentField = 'tle_' + ( i + 1 );

            if ( b[currentField] == '' ) {

                tabTitles.push( 'Skill bar title ' + ( i + 1 ) );

            } else {

                var currentTitle = b[currentField];

                currentTitle = currentTitle.replace( /"/gi, "'" );

                tabTitles.push( currentTitle );

            } // End IF Statement

            var currentFieldData = 'ta_' + ( i + 1 );

            if ( b[currentFieldData] == '' ) {

                dataPercentage.push( '50' );

            } else {

                var currentData = b[currentFieldData];

                currentData = currentData.replace( /"/gi, "'" );

                dataPercentage.push( currentData );

            } // End IF Statement

        } // End FOR Loop

        g += '[skillbars]<br/><br/>';

        for ( var t in tabTitles ) {

            g += '[skillbar_unit dataPercentage="' + dataPercentage[t] + '" title="' + tabTitles[t] + '"]' + tabTitles[t] + '[/skillbar_unit]<br/><br/>';

        } // End FOR Loop

        g += '[/skillbars]';

        return g

    }
};
