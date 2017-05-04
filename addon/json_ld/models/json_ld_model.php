<?php

use Spatie\SchemaOrg\Schema;

class Json_ld_model extends CI_Model {

// ------------------------------------------------------------------------	

	var $jsonld_types = array();

	var $channel_info = array();

// ------------------------------------------------------------------------

	function __construct() {
		
		parent::__construct(); 

	}

// ------------------------------------------------------------------------

	// Get list of types from Spatie package
	
	function types() {

		// Get class methods for Schema
		$class_names = get_class_methods('Spatie\SchemaOrg\Schema');
		
		// Sort them
		sort($class_names);
		
		// Return it
		return $class_names;

	}

// ------------------------------------------------------------------------

	// Get type with fields from Spatie package
	
	function type($name) {

		// Get class methods for Schema
		$class_names = get_class_methods('Spatie\SchemaOrg\\'.trim($name));
		
		// Is it null?
		if(!is_null($class_names)) {
			
			// Sort them
			sort($class_names);

			// Remove the non-JSON-LD stuff
			foreach ($class_names as $key => $value) {
				if (strpos($value, '__') !== false || strpos($value, 'toArray') !== false || strpos($value, 'toScript') !== false || strpos($value, 'testIf')) {
					unset($class_names[$key]);
				}
			}
			
			// Return it
			return $class_names;

		}

		return 'no methods';

	}


// ------------------------------------------------------------------------

	function templates() {
		// Get all channels that have JSON-LD types assigned
		$this->db->select('exp_json_ld_templates.id, exp_json_ld_templates.template_name, exp_json_ld_templates.json_ld_type_id, exp_json_ld_templates.template_text')
			->from('exp_json_ld_templates');

		$templates = $this->db->get()->result_array();

		if(!empty($templates)) {
			
			foreach ($templates as $template) {
				
				$results[] = [
					'id' => $template['id'],
					'template_name' => $template['template_name'],
					'json_ld_type_id' => $template['json_ld_type_id'],
					'template_text' => $template['template_text'],
				];
			
			}

		} else {
			
			return FALSE;

		}

		return $results;
	}

// ------------------------------------------------------------------------

	function template($name = NULL, $id = NULL) {
		// Get all channels that have JSON-LD types assigned
		if (!empty($name)) {

			$this->db->select('exp_json_ld_templates.id, exp_json_ld_templates.template_name, exp_json_ld_templates.json_ld_type_id, exp_json_ld_templates.template_text')
				->where('exp_json_ld_templates.template_name',$name)
				->from('exp_json_ld_templates');
		} elseif (!empty($id)) {
			$this->db->select('exp_json_ld_templates.id, exp_json_ld_templates.template_name, exp_json_ld_templates.json_ld_type_id, exp_json_ld_templates.template_text')
				->where('exp_json_ld_templates.id',$id)
				->from('exp_json_ld_templates');
		}

		$templates = $this->db->get()->result_array();

		if(!empty($templates)) {
			
			foreach ($templates as $template) {
				
				$results[] = [
					'id' => $template['id'],
					'template_name' => $template['template_name'],
					'json_ld_type_id' => $template['json_ld_type_id'],
					'template_text' => $template['template_text'],
				];
			
			}

		} else {
			
			return FALSE;

		}

		return $results[0];
	}


}