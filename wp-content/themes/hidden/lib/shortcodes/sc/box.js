scnShortcodeMeta={
	attributes:[
		{
			label:"Title",
			id:"title",
			help: 'The title of your info box.',
			isRequired:true
		},
		{
			label:"Content",
			id:"content",
			help: 'The content of your info box. Use a &lt;br /&gt; to start a new line.',
			isRequired:true
		},
		{
			label:"Type",
			id:"type",
			help:"Values: &lt;empty&gt;, info, alert, tick, download, note.", 
			controlType:"select-control", 
			selectValues:['', 'info', 'error', 'success'],
			defaultValue: '',
			defaultText: 'warning (Default)'
		},
		{
			label:"Size",
			id:"size",
			help:"Values: &lt;empty&gt;, one line, block.",
			controlType:"select-control",
			selectValues:['', 'block'],
			defaultValue: '',
			defaultText: 'one line (Default)'
		},
		{
			label:"Can be closed?",
			id:"close",
			help:"Values: yes, no.",
			controlType:"select-control",
			selectValues:['no', 'yes'],
			defaultValue: 'no',
			defaultText: 'no (Default)'
		}
		],
		defaultContent:"Don't box me in.",
		shortcode:"box"
};
