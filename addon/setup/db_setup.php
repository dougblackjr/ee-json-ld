<?php if ( !defined('BASEPATH')) exit('No direct script access allowed');

  ee()->load->dbforge();

  // Create channel_fields pivot tables (2)
  ee()->dbforge->drop_table('json_ld_templates');

  $fields = array(
    'template_name' => array(
      'type' => 'TEXT',
    ),
    'json_ld_type_id' => array(
      'type' => 'INT',
      'constraint' => 5,
      'unsigned' => TRUE
    ),
    'template_text' => array(
      'type' => 'TEXT',
    )
  );

  ee()->dbforge->add_field('id');
  ee()->dbforge->add_field($fields);
  ee()->dbforge->create_table('json_ld_templates');

  unset($fields);