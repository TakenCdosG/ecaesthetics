scnShortcodeMeta = {
    attributes: [{
        label: "Title",
        id: "content",
        help: "The button title.",
        isRequired: true
    }, {
		label:"Icon",
		id:"icon",
		help:"Use 1 of predefined 140 icons",
		controlType:"select-control",
		selectValues:['', 'adjust', 'align-center', 'align-justify', 'align-left', 'align-right', 'arrow-down', 'arrow-left', 'arrow-right', 'arrow-up', 'asterisk', 'backward', 'ban-circle', 'barcode', 'bell', 'bold', 'book', 'bookmark', 'briefcase', 'bullhorn', 'calendar', 'camera', 'certificate', 'check', 'chevron-down', 'chevron-left', 'chevron-right', 'chevron-up', 'circle-arrow-down', 'circle-arrow-left', 'circle-arrow-right', 'circle-arrow-up', 'cog', 'comment', 'download', 'download-alt', 'edit', 'eject', 'envelope', 'exclamation-sign', 'eye-close', 'eye-open', 'facetime-video', 'fast-backward', 'fast-forward', 'file', 'film', 'filter', 'fire', 'flag', 'folder-close', 'folder-open', 'font', 'forward', 'fullscreen', 'gift', 'glass', 'globe', 'hand-down', 'hand-left', 'hand-right', 'hand-up', 'hdd', 'headphones', 'heart', 'home', 'inbox', 'indent-left', 'indent-right', 'info-sign', 'italic', 'leaf', 'list', 'list-alt', 'lock', 'magnet', 'map-marker', 'minus', 'minus-sign', 'move', 'music', 'off', 'ok', 'ok-circle', 'ok-sign', 'pause', 'pencil', 'picture', 'plane', 'play', 'play-circle', 'plus', 'plus-sign', 'print', 'qrcode', 'question-sign', 'random', 'refresh', 'remove', 'remove-circle', 'remove-sign', 'repeat', 'resize-full', 'resize-horizontal', 'resize-small', 'resize-vertical', 'retweet', 'road', 'screenshot', 'search', 'share', 'share-alt', 'shopping-cart', 'signal', 'star', 'star-empty', 'step-backward', 'step-forward', 'stop', 'tag', 'tags', 'tasks', 'text-height', 'text-width', 'th', 'th-large', 'th-list', 'thumbs-down', 'thumbs-up', 'time', 'tint', 'trash', 'upload', 'user', 'volume-down', 'volume-off', 'volume-up', 'warning-sign', 'wrench', 'zoom-in', 'zoom-out'],
		defaultValue: '',
		defaultText: 'none (Default)'
	}, /*{
		label:"Icon Style",
		id:"iconstyle",
		help:"Choose icon color",
		controlType:"select-control",
		selectValues:['black', 'white'],
		defaultValue: 'black',
		defaultText: 'black (Default)'
	},*/ {
        label: "link",
        id: "link",
        help: "Optional link (e.g. http://google.com).",
        validatelink: true
    }, {
		label:"Size",
		id:"size",
		help:"Values: &lt;empty&gt; for normal size, mini (xs), small (sm), large (lg).",
		controlType:"select-control", 
		selectValues:['xs', 'sm', 'default', 'lg'],
		defaultValue: '', 
		defaultText: 'medium (Default)'
    }, {
		label:"Style",
		id:"style",
		help:"Values: &lt;empty&gt;, info, success, warning, danger, inverse, link",
		controlType:"select-control", 
		selectValues:['', 'primary', 'info', 'success', 'warning', 'danger', 'inverse', 'link'],
		defaultValue: '',
		defaultText: 'none (Default)'
	}, {
		label:"Dark Text?",
		id:"text",
		help:'Leave empty for light text color or use "dark" (for light background color buttons).', 
		controlType:"select-control", 
		selectValues:['', 'light', 'grey', 'dark'],
		defaultValue: '',
		defaultText: 'Default'
	},
	{
		label:"CSS Class",
		id:"class",
		help:"Optional CSS class."
	}
	,
	{
		label:"Open in a new window",
		id:"window",
		help:"Optionally open this link in a new window.", 
		controlType:"select-control", 
		selectValues:['', 'yes'],
		defaultValue: '', 
		defaultText: 'no (Default)'
	}],
    defaultContent: "",
    shortcode: "button"
};
