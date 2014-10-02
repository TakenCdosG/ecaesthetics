scnShortcodeMeta={
	attributes:[
		{
			label:"Title",
			id:"title"
		},
		{
			label:"Quote",
			id:"content",
			isRequired:true
		},
		{
			label:"Small Text",
			id:"small"
		},
		{
			label:"Placement",
			id:"placement",
			help:"Values: &lt;normal&gt; left or right.",
			controlType:"select-control", 
			selectValues:['', 'left', 'right'],
			defaultValue: '', 
			defaultText: 'normal (Default)'
		},
		{
			label:"Width in px or % (e.g. 30%)",
			id:"width",
			help:"Set the width of your Quote Box"
		}
		],
		defaultContent:"Reflection is the better part of a champion.",
		shortcode:"quote"
};