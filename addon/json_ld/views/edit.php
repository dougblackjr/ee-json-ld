<div class="box">
	<h1><?php echo ee()->lang->line('json_ld_edit_template'); ?></h1>

	<div class="col-group">
		<div class="setting-txt col w-16 txt-wrap">
			<div class="box txt-wrap">
				<p>Here you can edit your template.</p>
				<ul class="checklist">
					<li>Edit JSON-LD template.</li>
					<li>View output below.</li>
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
								<p class="title" id="json-ld-type-title">Type:</p>
								<select name="jsonld-type" id="jsonld-type">
								<?php
									foreach ($types as $type) {
										echo '<option value="'.$type.'">'.$type.'</option>';
									}
								?>
								</select>
								<input type="hidden" id="json-ld-template-info" value=<?php echo $template_id; ?>>
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
							<div class="template-farm">
								<p class="title">Available Templates</p>
								<div id="template-farm">
									<?php
										if (!empty($templates)) {
											foreach ($templates as $template) {
												echo "<a class='token-drag' draggable='true' ondragstart='dragTemplate(event)' data-id='".$template['id']."'><span class='fa fa-plus-circle'></span>".$template['template_name']."</a>";
											}
										}
									?>
								</div>
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
				echo form_input(['name' => 'template_name','required' => TRUE, 'value' => $template_name]);
			?>
		</div>
	</fieldset>

	<fieldset class="col-group">
		<input type="hidden" id="json-ld-template-id" name="json-ld-template-id" value=<?php echo $template_id; ?>>
		<input type="hidden" id="json-ld-template-final" name="json-ld-template-final">
		<pre id="json-ld-show-template"></pre>
	</fieldset>
	<div class="col-group">
		<div class="col w-4">
			<?php echo form_submit(array('name' => 'submit', 'value' => ee()->lang->line('json_ld_form_submit'), 'class' => 'btn action')); ?>
			<!-- <a class="btn action" id="google-validate-button">Validate</a> -->
		</div>
	</div>
	<!-- END JSON FORM -->
</div>