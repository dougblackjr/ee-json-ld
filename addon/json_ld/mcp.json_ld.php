<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');


require dirname(__FILE__).'/vendor/autoload.php';

require_once PATH_THIRD.'json_ld/helpers/helpers.php';

use EllisLab\ExpressionEngine\Library\CP\Table;
use Spatie\SchemaOrg\Schema;
use Spatie\SchemaOrg\LocalBusiness;

class Json_ld_mcp {
	
	// Initiating variables
	public $return_data;
	public $return_array = array();

	private $settings;
	private $_data = array();
	private $_module = 'json_ld';
	private $module_name = 'json_ld';

	private $channels = array();
	private $fieldgroups = array();

	public function __construct() {

		// Load Model
		ee()->load->model('json_ld_model', 'jsonld');
		ee()->load->helper('url');
		//build theme url path
		$this->theme_url = URL_THIRD_THEMES."json_ld/";
		// Nav
		$nav_items = array(
			lang('json_ld_nav_home')       => '/',
			lang('json_ld_create_new')    => 'new_template',
			lang('json_ld_nav_documentation') => 'documentation'
		);
		
		$this->nav = Json_ld_helpers::getNav($nav_items);

		// Title Bar
		ee()->view->header = array(
			'title' => lang('json_ld_module_name')
		);

	}

	public function index() {
		/*
		INDEX: Gets list of JSON-LD templates
		 */
		
		// Delete if something is there
		// if ( ! empty($_POST))
		// {
		// 	$this->delete();
		// }

		// Get base info
		$base_url = ee('CP/URL')->make('addons/settings/json_ld');
		$site_id = ee()->config->item('site_id');

		// Start the table
		$table = ee('CP/Table', array('autosort' => TRUE, 'autosearch' => FALSE, 'limit' => 20));
		$table->setColumns(
			array(
				'Template Name',
				'manage' => array(
					'type'	=> Table::COL_TOOLBAR
				),
				array(
					'type'	=> Table::COL_CHECKBOX
				)
			)
		);
		$table->setNoResultsText(sprintf(lang('json_ld_no_found'), lang('json_ld_module_name')));

		$data = array();

		// Get the assigned channels
		$entries = ee()->jsonld->templates();

		// If there is an assigned channel
		if(!empty($entries)) {

			// For each entry, build a row
			foreach($entries as $entry) {
				$checkbox = array(
					'name' => 'selection[]',
					'value' => $entry['id'],
					'data'	=> array(
						'confirm' => 'Template: <b>' . htmlentities($entry['template_name'], ENT_QUOTES, 'UTF-8') . '</b>'
					)
				);

				$edit_url = ee('CP/URL')->make('addons/settings/json_ld/edit_template&id=' . $entry['id']);

				$data[] = array(
					'channel' => array(
						'content' => $entry['template_name']
					),
					array(
						'toolbar_items' => array(
							'edit' => array(
								'href' => $edit_url,
								'title' => lang('edit')
							)
						)
					),
					$checkbox
				);
			}

		}

		$table->setData($data);
		$vars['table'] = $table->viewData($base_url);

		$vars['base_url'] = $vars['table']['base_url'];

		// Set up pagination if greater than 20 channels
		$vars['pagination'] = ee('CP/Pagination', $vars['table']['total_rows'])
			->perPage($vars['table']['limit'])
			->currentPage($vars['table']['page'])
			->render($base_url);

		ee()->javascript->set_global('lang.remove_confirm', lang('page') . ': <b>### ' . lang('pages') . '</b>');
		ee()->cp->add_js_script(array(
			'file' => array('cp/confirm_remove'),
		));

		// Return views
		return array(
			'heading' => lang('json_ld_manager'),
			'body' => ee('View')->make('json_ld:index')->render($vars)
		);

		return ee('View')->make('json_ld:index')->render($vars);

	}

	public function new_template()
	{

		// Load helpers, libraries, and theme stuff
		ee()->load->library('table');
		ee()->cp->add_to_head('<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css">');
		ee()->cp->add_to_head('<link rel="stylesheet" href="'.$this->theme_url.'css/app.css" type="text/css" media="screen">');
		ee()->cp->add_to_foot('<script type="text/javascript">var $token = 1;</script>');
		ee()->cp->add_to_foot('<script src="'.$this->theme_url.'js/app.js" type="text/javascript" charset="utf-8"></script>');
		ee()->cp->add_to_foot('<script src="'.$this->theme_url.'js/draganddrop.js" type="text/javascript" charset="utf-8"></script>');

		$this->_data['action_url'] = ee('CP/URL')->make('addons/settings/json_ld/savetemplate');

		$this->_data['templates'] = ee()->jsonld->templates();

		// Get types
		$this->_data['types'] = ee()->jsonld->types();

		return ee('View')->make('json_ld:new')->render($this->_data);

	}

	public function edit_template()
	{

		// This is the edit template
		// Get post ID to edit
		$edit_id = ee()->input->get_post('id');

		// Get template data for edit_id
		$template_data = ee()->jsonld->template(NULL, $edit_id);

		$this->_data['template_id'] = $template_data['id'];
		$this->_data['template_name'] = $template_data['template_name'];
		$this->_data['template_data'] = $template_data['template_text'];
		$this->_data['action_url'] = ee('CP/URL')->make('addons/settings/json_ld/resavetemplate');
		$this->_data['types'] = ee()->jsonld->types();
		$this->_data['templates'] = ee()->jsonld->templates();
		
		// Load helpers, libraries, and theme stuff
		ee()->load->library('table');
		ee()->cp->add_to_head('<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css">');
		ee()->cp->add_to_head('<link rel="stylesheet" href="'.$this->theme_url.'css/app.css" type="text/css" media="screen">');

		ee()->cp->add_to_foot('<script type="text/javascript">var $token = 1;</script>');
		ee()->cp->add_to_foot('<script src="'.$this->theme_url.'js/app.js" type="text/javascript" charset="utf-8"></script>');
		// Load edit form js
		ee()->cp->add_to_foot('<script src="'.$this->theme_url.'js/load_edit_form.js" type="text/javascript" charset="utf-8"></script>');
		ee()->cp->add_to_foot('<script src="'.$this->theme_url.'js/draganddrop.js" type="text/javascript" charset="utf-8"></script>');

		// Send data to view
		return ee('View')->make('json_ld:edit')->render($this->_data);

	}

	public function documentation()
	{

		$this->_data['imagePath'] = $this->theme_url."img/logo.png";

		return ee('View')->make('json_ld:docs')->render($this->_data);

	}

	public function savetemplate()
	{
		// This is the save function
		// Get form data
		$template_name = ee()->input->get_post('template_name');
		$template = ee()->input->get_post('json-ld-template-final');

		// Write it to database
		$data = [
			'template_name' => $template_name,
			'template_text' => $template
		];

		ee()->db->insert('exp_json_ld_templates', $data);

		// return index view
		return $this->index();
	}

	public function resavetemplate()
	{
		// This is the save function
		// Get form data
		$template_id = ee()->input->get_post('json-ld-template-id');
		$template_name = ee()->input->get_post('template_name');
		$template = ee()->input->get_post('json-ld-template-final');

		// Write it to database
		$data = [
			'template_name' => $template_name,
			'template_text' => $template
		];

		ee()->db->update('exp_json_ld_templates', $data, ['id' => $template_id]);

		// return index view
		return $this->index();
	}

	public function ajaxcall()
	{
		
		// Get post action
		$action = ee()->input->post('action');

		switch ($action) {
			
			case 'getTypeFields':

				// Get post variable
				$var = ee()->input->post('var');
				
				// Get type fields from model
				$type = ee()->jsonld->type($var);
				
				// Send them over
				ee()->output->send_ajax_response($type);
				break;

			case 'getJSONLD':

				// Get post variable
				$var = ee()->input->post('var');
				
				$values = [];

				// Foreach field, put value in array
				foreach ($var as $value) {
					
					// Set type
					if($value['name'] == 'jsonld-type') {
						
						$type = $value['value'];
						
					}

					if($value['name'] !== 'jsonld-fields' && $value['name'] !== 'jsonld-type') {

						$values[] = [
						
							$value['name'] => $value['value']
						
						];

					}

				}

				// Create class
				$typeClass = 'Spatie\SchemaOrg\\'.trim($type);
				$output = new $typeClass;

				// Find what fields have dashes, those belong to other types
				foreach ($values as $key => $valuebreakdown) {
					
					foreach ($valuebreakdown as $key => $value) {
						// Connect those fields to their appropriate types
						// Is it dashed?
						if (strpos($key, '-') !== false) {

							// ACTION: Explode by - to parent and child
							$exploded = explode("-", $key);
							$parentName = $exploded[0];
							$childName = $exploded[1];
							// DECISION: Parent exist?
							if($output->getProperty($parentName))
							{
								// YES - Parent exists
								// ACTION: Get parent data
								$parentData = $output->getProperty($parentName);
								
								// DECISION: This child exist? (Every parent automatically has a child)
								if(array_key_exists($childName, $parentData))
								{
									// YES - This child exists
									// DECISION: Is child an array?
									if(is_array($parentData[$childName]))
									{
										// YES - Child is an array
										$childData = $parentData[$childName];
										// ACTION: Push new value to array
										array_push($childData, $value);
										// ACTION: Add to parent data
										$parentData[$childName] = $childData;
										// ACTION: Set Property
										$output->setProperty($parentName, $parentData);
									} else {
										// NO - Child is a 1 dimensional
										// ACTION: Create array with child data and new data
										$childData = $parentData[$childName];
										$childArray = [$childData, $value];
										// ACTION: Remove old child, put new child
										$parentData[$childName] = $childArray;
										// ACTION: Set property
										$output->setProperty($parentName, $parentData);

									}
								} else {
									// NO - Child does not exist
									// ACTION: Add new key=>value pair to parent data
									$parentData[$childName] = $value;
									// ACTION: Set Property
									$output->setProperty($parentName, $parentData);
								}
							} else {
								// NO - Parent does not exist
								// ACTION: Set property of parent with child as array
								$output->setProperty($parentName, array($childName => $value));
							}

						} else {
							// REGULAR FIELD:
							// Is it a multiple?
							if ($output->getProperty($key)) {
								// YES: Add it to array
								$tempOutput = $output->getProperty($key);
								
								// It has a value, and we'll test if it's an array and create it
								// IS IT ALREADY AN ARRAY?
								if (is_array($tempOutput)) {
									//YES: Push it
									$tempOutput[] = $value;
									$output->setProperty($key, $tempOutput);
								} else {
									// NO: Create it
									$tempArray = [$tempOutput, $value];
									$output->setProperty($key, $tempArray);
								}

							} else {
								// NO: Just add it
								$output->setProperty($key, $value);

							}

						}

					}

				}

				// FINAL RESPONSE
				ee()->output->send_ajax_response($output->toArray());

				// Break the switch
				break;

			case 'googleValidate':
				// Get variable
				$var = ee()->input->post('var');

				//Use Google Helper
				$output = Json_ld_helpers::googleValidate($var);
				// Send it back as JSON
				ee()->output->send_ajax_response($output);
				break;

			case 'populateForm':
				$var = ee()->input->post('var');

				$template = ee()->jsonld->template(NULL, $var);

				ee()->output->send_ajax_response($template);

				break;

			default:
				die('Access denied for this function!');
		}

		exit();
	}

	private function delete()
	{
	    
		// DELETE template

		foreach ($_POST['selection'] as $id)
		{
			$ids['id'] = $id;
			$template = ee()->jsonld->template(NULL,$id);
			$templateNames[] = $template['template_name'];
		}

        // Delete Pages & give us the number deleted.
        $didItDelete = ee()->db->delete('exp_json_ld_templates', $ids);

		if ($didItDelete !== FALSE)
		{
			ee('CP/Alert')->makeInline('json-ld-form')
				->asSuccess()
				->withTitle('success')
				->addToBody('Templates deleted:')
				->addToBody($templateNames)
				->now();
		}
	}

}
// END CLASS

/* End of file mcp.json_ld.php */