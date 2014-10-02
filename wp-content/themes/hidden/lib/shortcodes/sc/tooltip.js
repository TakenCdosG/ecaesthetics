scnShortcodeMeta={
	attributes:[
		{
			label:"Tooltip",
			id:"text",
			help: 'This text will be shown inside your tooltip.',
			isRequired:true
		},
		{
			label:"Content",
			id:"content",
			help: 'The content on which tooltip will be applied.',
			isRequired:true
		},
		{
			label:"Placement",
			id:"placement",
			help:"Values: &lt;top&gt;, right, bottom, left.",
			controlType:"select-control",
			selectValues:['', 'right', 'bottom', 'left'],
			defaultValue: '',
			defaultText: 'top (Default)'
		}
		],
		defaultContent:"Hover over me.",
		shortcode:"tooltip"
};
