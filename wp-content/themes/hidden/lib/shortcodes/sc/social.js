scnShortcodeMeta = {
    attributes: [{
        label: "Title",
        id: "title",
        help: "The link title."
    }, {
        label: "link",
        id: "url",
        isRequired: true,
        help: "The Url for your link.",
        validatelink: true
    }, {
        label:"Network",
        id:"network",
        help:"Values: dribbble, facebook, facebook-square, flickr, github, google-plus, google-plus-square, instagram, linkedin, linkedin-square, pinterest, pinterest-square, tumblr, tumblr-square, twitter, twitter-square, vimeo-square, vk, youtube",
        controlType:"select-control",
        selectValues:['dribbble', 'facebook', 'facebook-square', 'flickr', 'github', 'google-plus', 'google-plus-square', 'instagram', 'linkedin', 'linkedin-square', 'pinterest', 'pinterest-square', 'tumblr', 'tumblr-square', 'twitter', 'twitter-square', 'vimeo-square', 'vk', 'youtube'],
        defaultValue: 'facebook',
        defaultText: 'facebook (Default)'
    }, {
        label:"Size",
        id:"size",
        help:"1, 2, 3, 4",
        controlType:"select-control",
        selectValues:[1, 2, 3, 4],
        defaultValue: 1,
        defaultText: '1 (default)'
    }],
    defaultContent: "",
    shortcode: "social"
};