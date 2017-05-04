<?php if ( !defined('BASEPATH')) exit('No direct script access allowed');

class Json_ld_upd {

	var $version = '1.0.0';

	function install()
	{

		// Include db_setup for install
		include_once 'setup/db_setup.php';

		// APP INFO
		$data = array(
		 'module_name' => 'Json_ld' ,
		 'module_version' => $this->version,
		 'has_cp_backend' => 'y'
		);

		ee()->db->insert('modules', $data);
		ee()->load->library('layout');

		return true;

	}

	function update($current = '')
	{
		if (version_compare($current, '2.0', '='))
		{
				return FALSE;
		}

		if (version_compare($current, '2.0', '<'))
		{
				// Do your update code here
		}

		return TRUE;
	}

	function uninstall() {
		ee()->load->dbforge();

		ee()->dbforge->drop_table('json_ld_templates');

		ee()->db->where('module_name', 'Json_ld');
		ee()->db->delete('modules');

		ee()->db->where('class', 'Json_ld');
		ee()->db->delete('actions');

		ee()->load->library('layout');
		// ee()->layout->delete_layout_tabs($this->tabs(), 'json_ld');

		return true;
	}
}

/* End of file upd.json_ld.php */