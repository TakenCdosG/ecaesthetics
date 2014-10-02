<?php
if( ! class_exists( 'afl_object' ) )
{
	class afl_object
	{
		var $base_data;
		var $subpages = array();
		var $options;
		var $option_prefix;
		var $option_pages = array();
		var $option_page_data = array();
		var $style;

		public function afl_superobject( $base_data )
		{
			$this->base_data = $base_data;
			$this->option_prefix = 'afl_options_'.$this->base_data['prefix'];

			//set option array
			$this->_create_option_arrays();
		}

		private function _create_option_arrays()
		{
			//saved option values
			$database_option = get_option($this->option_prefix);

			/*
			 *   filter in case user wants to manipulate the default array
			 *	 (eg: stylswitch plugin wants to filter the options and overrule them)
			 */
			$this->options = apply_filters( 'afl_filter_global_options', $database_option );


		}

	}
}

$afl = new afl_object($afl_init);