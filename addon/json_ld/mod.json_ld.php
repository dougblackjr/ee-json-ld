<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

// Load helpers
require_once PATH_THIRD.'json_ld/helpers/helpers.php';

class Json_ld
{

	public $return_data = '';
	private $_session_data= array();

    public function __construct()
	{

		ee()->load->model('json_ld_model', 'jsonld');

	}

	public function set()
	{
		// This gets the tokens that are set in the template
		// Get EE template data
		$template = ee()->TMPL->fetch_param('template');
		$token = ee()->TMPL->fetch_param('token');
		$token_data = $this->strip_html(ee()->TMPL->tagdata);

		// Sets this in session
		$data[] = [$template, $token, $token_data];

		if (isset(ee()->session->cache['jsonld'])) {
			ee()->session->cache['jsonld'] = array_merge(ee()->session->cache['jsonld'], $data);
		} else {
			ee()->session->cache['jsonld'] = $data;
		}

	}

	public function output()
	{

		$this->_session_data = ee()->session->cache['jsonld'];

		$test = ee()->TMPL->fetch_param('test', FALSE) ? TRUE : FALSE;

		// Get EE tag params
		$template_name = ee()->TMPL->fetch_param('template') ? ee()->TMPL->fetch_param('template') : FALSE;

		$templates = explode('|', $template_name);

		$return_data = NULL;

		foreach ($templates as $each_template) {

			if($each_template) {

				// Parse template
				$template_data = $this->process_template(ee()->jsonld->template($each_template), $each_template);

				// Add script tags
				if ($test) {
					$code = $template_data;
				} else {
					$code = '<script type="application/ld+json">'.$template_data.'</script>';
				}
				
				// Return it
				$return_data .= $code;

			} else {

				$return_data .= null;

			}

		}

		return $return_data;

	}

	private function process_template($template, $current)
	{

		$this->_session_data = ee()->session->cache['jsonld'];

		$template_data = $template['template_text'];
		
		// Parse internal templates
		// If an internal template exists
		if ( strpos($template_data, '"##template') !== FALSE ) {
			// Find where they are
			preg_match_all('/"##template\d+##"/', $template_data, $matches);
    		
    		// For each, process it
    		foreach ($matches as $match) {
    			
    			// Get template ID
				preg_match_all('/\d+/', $match[0], $templateID);

    			// Process the template
    			$internalTemplate = ee()->jsonld->template(NULL, $templateID[0][0]);
    			
    			if(!empty($internalTemplate))
    			{
					
					$templateToInsert = $this->process_template($internalTemplate, $internalTemplate['template_name']);

					// Insert it into this template
    				$template_data = str_replace('"##template'.$templateID[0][0].'##"', trim($templateToInsert), $template_data);

    			}

    		}
		
		}

		// Parse tokens in template
		foreach ($this->_session_data as $setvar) {

			//Get token id
			$template = $setvar[0];
			// If token is in template
			if($template == $current) {
				// String replace ie. ##token1## -> GERBILS
				$token_name = $setvar[1];
				$token_data = $setvar[2];

				$template_data = str_replace('##token'.$token_name.'##', trim($token_data), $template_data);
			}
		}

		return $template_data;
	}

	private function strip_html($data)
	{

		// Add Space between tags
		$text =str_replace( ">", "> ", $data );

		// REMOVE HTML
		$text = strip_tags($text);

		// REMOVE LINE BREAKS
		$text =preg_replace( "/\r|\n|\"|\\\|\\/|\t|\\'/", "", $text );

		return $text;
	}

}


/* End of file mod.json_ld.php */