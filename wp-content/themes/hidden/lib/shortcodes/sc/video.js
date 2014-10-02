scnShortcodeMeta={
	attributes:[
		{
			label:"ID",
			id:"id",
			help:"ID of your video (e.g. 0Bmhjf0rKe8)",
			isRequired:true
		},
		{
			label:"Type",
			id:"type",
			help:"Values: &lt;YouTube&gt; or Vimeo.",
			controlType:"select-control", 
			selectValues:['', 'vimeo'],
			defaultValue: '', 
			defaultText: 'youtube (Default)'
		},
		{
			label:"Width in px or % (e.g. 30%)",
			id:"width",
			help:"Set the width of your Video"
		},
		{
			label:"Height in px or % (e.g. 30%)",
			id:"height",
			help:"Set the height of your Video"
		}
		],
		defaultContent:"",
		shortcode:"video"
};