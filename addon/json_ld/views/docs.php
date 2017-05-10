<div class="box">
	<h1><?php echo ee()->lang->line('json_ld_documentation'); ?></h1>

	<div class="col-group">
		<div class="setting-txt col w-16 txt-wrap">
			<div class="box txt-wrap">
				<p><img src='<?php echo $imagePath; ?>' /></p>

				<h1 style="text-align: center;" id="jsonldpluginforexpressionengine">JSON-LD Plugin for ExpressionEngine</h1>
				<h3 style="text-align: center;">SEO-friendly schema generator for EE3</h3>
				<p>Create JSON-LD templates for your content, and insert them into your front-facing templates.</p>
				<div class="box has-tabs">
				<h1>Documentation</h1>
					<div class="tab-wrap">
						<ul class="tabs">
							<li><a href="" rel="t-0">Getting Started</a></li>
							<li><a href="" rel="t-1">Index View</a></li>
							<li><a class="act" href="" rel="t-2">Create JSON-LD Template</a></li>
							<li><a href="" rel="t-3">Output in EE Template</a></li>
							<li><a href="" rel="t-4">JSON-LD Documentation</a></li>
						</ul>
						<!-- INSTALL -->
						<div class="tab t-0 md-wrap">
							<h2 id="installinggettingstarted">Installing / Getting started</h2>

							<p>To install: </p>
							<ol>
								<li>Copy the json_ld folder within the ee_plugin folder to your <code>user/addons</code> folder.</li>
								<li>Copy the json_ld folder within the ee_plugin_theme folder to your <code>public/themes/user</code> folder.</li>
								<li>At your site admin panel, click <code>Developer</code>, then <code>Add-on Manager</code>.</li>
								<li>Under the <code>Third Party Add-Ons</code> heading, click the JSON-LD install button.</li>
							</ol>

							<p>You will then have access to create templates via the <code>Developer => Add-on Manager</code> menu at your site admin panel.</p>

							<p>Please note: This creates one table in your database.</p>
						</div>
						<!-- INDEX VIEW -->
						<div class="tab t-1 md-wrap">
							<h2>Your Index View</h2>
							<p>When you first enter the JSON-LD plugin, you will see a list of your templates and a side menu. You have the options to:</p>
							<div class="md-wrap">
								<ul>
									<li><strong>Create New Template</strong>: Start a new JSON-LD template from scratch</li>
									<li><strong>Manage Templates</strong>: Edit or delete your JSON-LD templates</li>
									<li><strong>Documentation</strong>: View this file for further instructions.</li>
									<li><strong>Home</strong>: Return to this home view at any time.</li>
								</ul>
							</div>
						</div>
						<!-- JSON-LD TEMPLATING -->
						<div class="tab t-2 tab-open md-wrap">
							<h2>Create a JSON-LD template</h2>

							<p>First, from your Index view, click "Create New Template". This will bring you to the simple process this plugin follows.</p>

							<ol>
								<li><strong>CHOOSE YOUR JSON-LD TYPE</strong><p>Choose the type of JSON-LD template that you would like to create, based on the content that you will demarcating with the template. When you select your type, the associated fields will appear, as well as a link to the schema.org documentation for that particular type.</p></li>
								<li><strong>WORK YOUR FIELDS</strong><p>Choose a field you would like to add to your JSON-LD template from the Add Fields dropdown, then click the Add button. This will add that field to the form with a few important options:</p>
								<div class="md-wrap">
									<ul>
										<li><em>ADD TOKEN: </em>Since you will probably want to use dynamically created information in your JSON-LD template, you will be adding lots of these. Click the ADD TOKEN button next to a field to add a template token to the field. You can add whatever other text or as many other tokens to that field you would like.</li>
										<li><em>TOKEN FARM: </em>You will also notice the farm of your used tokens appear on the left. You can drag and drop these into the text fields you would like to use them in. A token can be used any amount of times.</li>
										<li><em>TEMPLATE FARM: </em>You can also nest templates into one another, for use of adding specific types. For example: An author can be a text field for a single name, a Person type, or an Organization. Let's say you want to create a Person type, and use it as your author. You create a template for Person type. That template will appear in the sidebar as you create your template. Drag and drop the template to the field you would like it to complete. The template will parse with tokens that you've placed and assign in your EE template, just as normal template.</li>
										<li><em>NEST: </em>Some JSON-LD fields contain entire other types. If you see the `NEST` button, you have the option of using a simple text input, or a nested field. Click the NEST button to access that sub-type's fields. You can add as many nested fields as you like by clicking the NEST button. You can add tokens to nested fields by clicking the plus sign in the appropriate box.</li>
									</ul>
								</div>
								</li>
								<li><strong>NAME YOUR TEMPLATE</strong><p>Give your JSON-LD template a unique name. You will need this name when you parse it in your EE template.</p></li>
								<li><strong>SAVE YOUR TEMPLATE</strong><p>When you're all ready to go, click the <code>ADD TEMPLATE</code> button on the bottom of the page to save your template.</p></li>
							</ol>

							<p>You can follow these same steps while editing your template. The form will parse your tokens so you can add new ones without overlap.</p>
						</div>
						<!-- OUTPUT -->
						<div class="tab t-3 md-wrap">
							<h2>Add your JSON-LD template to your EE template</h2>

							<p>After you've created your JSON-LD template, it's time to invisibily show it to the world.</p>

							<p>You can have as many JSON-LD templates on your page as you would like.</p>

							<p>The JSON-LD template parser works with two tags: `set` and <code>output</code>.</p>

							<div class="md-wrap">
								<h5><strong>SET</strong></h5>
								<p>This command is used to parse your tokens, and should appear before the output command for the template the tokens belong to.</p>
								<blockquote>
									<p>{exp:json_ld:set token="1" template="Test1"}</p>
									<p>The title is {title}.</p>
									<p>{/exp:json_ld:set}</p>
								</blockquote>

								<ol>
									<li>Open the set tag with <code>{exp:json_ld:set}</code>.</li>
									<li>Set the token with the <code>token</code> parameter.</li>
									<li>Set the template name with the <code>template</code> parameter.</li>
									<li>Set your token data within the tag pair. This can be static text or other EE field information.</li>
									<li>Close the tag with <code>{exp:json_ld:set}</code>.</li>
								</ol>

								<p>This will set the tokens for use in the output command for the assigned template.</p>
							</div>

							<div class="md-wrap">
								<h5><strong>OUTPUT</strong></h5>
								<p>This command is used in your EE template.</p>
								<blockquote>
									<p>{exp:json_ld:output template="Test1" test="1"}</p>
									<p>{exp:json_ld:output template="Test1|Test2|Test3" test="1"}</p>
								</blockquote>
								<ol>
									<li>After you have set your tokens, use the <code>{exp:json_ld:output}</code> tag to enter the template.</li>
									<li>Set the template name with the <code>template</code> parameter. You can use multiple templates by separating them with <code>|</code>.</li>
									<li>JSON-LD as is will be invisible on your page, only to be picked up by crawlers. If you want to see your JSON-LD template in action, set the <code>test</code> parameter to <code>1</code> as displayed in the example above (Just make sure to take that out before you publish).</li>
								</ol>
							</div>
						</div>
						<!-- JSON-LD SPECIFIC DOCS -->
						<div class="tab t-4 md-wrap">
							<h2>JSON-LD Documentation</h2>
							<p>For more information on JSON-LD, see the following links:</p>
							<p><a href="http://json-ld.org" target="_blank">json-ld.org</a></p>
							<p><a href="http://jsonld.com" target="_blank">http://jsonld.com</a></p>
							<p><a href="https://developers.google.com/schemas/formats/json-ld" target="_blank">Google Schema - JSON-LD</a></p>
							<p><a href="https://search.google.com/structured-data/testing-tool/u/0/" target="_blank">Google Schema Markup Validator (We'll integrate this soon)</a></p>
							<p><a href="https://www.w3.org/TR/json-ld/" target="_blank">W3 Standards</a></p>
						</div>
					</div>
				</div>

			</div>

		</div>

	</div>

</div>