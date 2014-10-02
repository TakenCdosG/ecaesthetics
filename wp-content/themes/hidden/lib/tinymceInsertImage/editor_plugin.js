(function() {
	// Load plugin specific language pack
	tinymce.PluginManager.requireLangPack('afl_insert_image');

	tinymce.create('tinymce.plugins.afl_insert_image', {
		init : function(ed, url) {
                        var post_id = window.location.search.slice(1).split('&')[0].split('=')[1];
			// Register the command so that it can be invoked by using tinyMCE.activeEditor.execCommand('mceExample');
			ed.addCommand('mceafl_insert_image', function() {
				ed.windowManager.open({
					file : 'media-upload.php?post_id='+post_id+'&type=image&TB_iframe=0&width=640&height=606',
					width : 640 + ed.getLang('afl_insert_image.delta_width', 0),
					height : 606 + ed.getLang('afl_insert_image.delta_height', 0),
					inline : 1
				}, {
					plugin_url : url
				});
			});
			ed.addButton('afl_insert_image', {
				title : 'Insert image',
				cmd : 'mceafl_insert_image',
				image : url + '/icon.png'
			});

			// Add a node change handler, selects the button in the UI when a image is selected
			ed.onNodeChange.add(function(ed, cm, n) {
				cm.setActive('afl_insert_image', n.nodeName == 'IMG');
			});
		},

		/**
		 * Creates control instances based in the incomming name. This method is normally not
		 * needed since the addButton method of the tinymce.Editor class is a more easy way of adding buttons
		 * but you sometimes need to create more complex controls like listboxes, split buttons etc then this
		 * method can be used to create those.
		 *
		 * @param {String} n Name of the control to create.
		 * @param {tinymce.ControlManager} cm Control manager to use inorder to create new control.
		 * @return {tinymce.ui.Control} New control instance or null if no control was created.
		 */
		createControl : function(n, cm) {
			return null;
		},

		/**
		 * Returns information about the plugin as a name/value array.
		 * The current keys are longname, author, authorurl, infourl and version.
		 *
		 * @return {Object} Name/value array containing information about the plugin.
		 */
		getInfo : function() {
			return {
			};
		}
	});

	// Register plugin
	tinymce.PluginManager.add('afl_insert_image', tinymce.plugins.afl_insert_image);
})();