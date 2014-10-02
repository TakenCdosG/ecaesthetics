scnShortcodeMeta={
	attributes:[
		{
			label:"Title",
			id:"title",
			help: 'Enter the title that should be displayed above the widget'
		},
		{
			label:"How many entries",
			id:"amount",
			help:"How many entries do you want to display?", 
			controlType:"select-control", 
			selectValues:['1', '2', '3', '4', '5', '6', '7', '8','9', '10', '11', '12', '13', '14', '15', '16', '17', '18', '19', '20', '30', '40', '50', '100'],
			defaultValue: '3', 
			defaultText: '3'
		},
		{
			label:"Posts from which categories do you want to show?",
			id:"cat",
			help: 'Enter a comma separated string with category ids here. Leave empty if you want to display posts from all categories. Example: 1,5,12'
		}
		],
		disablePreview: true,
		defaultContent:"Recent Entries",
		shortcode:"posts_strip"
};
