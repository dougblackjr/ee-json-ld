<div class="box">
	<h1><?php echo ee()->lang->line('json_ld_create_new'); ?></h1>

	<div class="col-group">
		<div class="setting-txt col w-16 txt-wrap">
			<div class="box txt-wrap">
				<p>Here you can create your template using JSON-LD types. Wherever you would like to call a variable, click the 'insert token' button. You will set those tokens in your EE templates.</p>
				<ul class="checklist">
					<li>Create JSON-LD template.</li>
					<li>View output below.</li>
					<li>Name JSON-LD template.</li>
					<li>Save JSON-LD template.</li>
					<li>Put JSON-LD template in EE template</li>
				</ul>
			</div>
		</div>
	</div>

	<!-- JSON FORM -->
	<div class="json-ld-form-container">
		<div class="col-group">
			<div class="col w-16 aside hero is-fullheight">
				<div class="uploader has-text-centered">
					<span class="app-name">JSON-LD Template Creator</span>
				</div>
			</div>
		</div>
		<div class="col-group">
			<form name="json-ld-form-form" id="json-ld-form-form" data-jsonld-form action="" method="get" accept-charset="utf-8">
			<aside class="col w-4 aside hero is-fullheight">
				<div class="main">
					<div class="col-group">
						<div class="col w-16">
							<div class="choose-type">
								<p class="title">Choose Type</p>
								<select name="jsonld-type" id="jsonld-type">
								<?php
									foreach ($types as $type) {
										echo '<option value="'.$type.'">'.$type.'</option>';
									}
								?>						

								</select>
								<p class="doc-link"></p>
							</div>
						</div>
					</div>
					<div class="col-group">
						<div class="col w-16">
							<div class="add-fields">
								<p class="title">Add Fields</p>
								<select name="jsonld-fields" id="jsonld-fields">
								</select>
								<p><a class="btn" id="add-field-button">Add</a></p>
							</div>
						</div>
					</div>
					<div class="col-group">
						<div class="col w-16">
							<div class="token-farm">
								<p class="title">Available Tokens </p>
								<div id="token-farm"></div>
							</div>
						</div>
					</div>
				</div>
			</aside>
			<div class="content col w-12">
					<table id="json-table">
						<thead>
							<tr class="first">
								<th>Field Name</th>
								<th>Data</th>
								<th>Actions</th>
							</tr>
						</thead>
						<tbody>
						</tbody>
					</table>
				</form>
			</div>
		</div>

	</div>
	<?php echo form_open($action_url, array('class'=>'settings')); ?>

	<fieldset class="col-group">
		<div class="setting-txt col w-8">
			<h3><?php echo ee()->lang->line('json_ld_form_template_name'); ?></h3>
			<em><?php echo ee()->lang->line('json_ld_form_template_subtext'); ?></em>
		</div>
		<div class="setting-field col w-8 last">
			<?php 
				echo form_input(['name' => 'template_name','required' => TRUE]); ?>
		</div>
	</fieldset>

	<fieldset class="col-group">
		<input type="hidden" id="json-ld-template-final" name="json-ld-template-final">
		<pre id="json-ld-show-template">Your template will appear here.</pre>
	</fieldset>
	<div class="col-group">
		<div class="col w-4">
			<?php echo form_submit(array('name' => 'submit', 'value' => ee()->lang->line('json_ld_form_submit'), 'class' => 'btn action')); ?>
			<!-- <a class="btn action" id="google-validate-button">Validate</a> -->
		</div>
	</div>
	<!-- START MODAL -->
	<!-- TO BE ADDED IN VERSION 1.1 -->
	<!-- <div class="modal" id="modal-ter">
		<div class="modal-background"></div>
		<div class="modal-card">
			<header class="modal-card-head">
				<p class="modal-card-title">Google Schema Validator</p>
			</header>
			<section class="modal-card-body">
				<pre id="schema-out" name="schema-out"></pre>
			</section>
			<footer class="modal-card-foot">
				<a class="btn action" id="close-modal">Close</a>
	    	</footer>
	  	</div>
	</div> -->
	<!-- END JSON FORM -->
</div>