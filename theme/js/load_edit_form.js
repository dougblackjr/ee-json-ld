$(document).ready(function($) {
	
	// First, let's populate the PRE and get the template data and scope these
	// Get template id
	var tempid = $('#json-ld-template-info').val();
	var templateInfo;

	// Make ajax call with template id
	$.ajax({
		async: false,
		url:'admin.php?/cp/addons/settings/json_ld/ajaxcall',
		type:'POST',
		action: 'populateForm', 
		data: {
			'action': 'populateForm',
			'var': tempid
		},
		success: function(rdata){
				
			// If success, then send to form div below
			templateInfo = rdata;

			var template = JSON.parse(templateInfo.template_text);

    		// Make it pretty
    		var pretty = unescape(JSON.stringify(template, undefined, 4));
				
    		var notPretty = JSON.stringify(template, undefined, 0);

			$('#json-ld-template-final').val(notPretty);

			$('#json-ld-show-template').text(pretty);

		},
		error: function(xhr){

			console.log(xhr);

		}

	});

	// Let's build the form back
	// Get variables from form
	var template = templateInfo.template_text;
	var templateName = templateInfo.template_name;

	// Parse JSON
	var templateParsed = JSON.parse(template);
	
	// Get type from content in JSON ld
	var jsonldType = templateParsed['@type'];

	// Change type field
	$("#jsonld-type option[value="+jsonldType.charAt(0).toLowerCase()+jsonldType.slice(1)+"]").attr("selected", "selected");

	$.ajax({
		async: false,
		url:'admin.php?/cp/addons/settings/json_ld/ajaxcall',
		type:'POST',
		action: 'getTypeFields', 
		data: {
			'action': 'getTypeFields',
			'var': jsonldType.charAt(0).toLowerCase()+jsonldType.slice(1)
		},
		success: function(rdata){
			// Populate the select box
			var $dropdown = $("#jsonld-fields");

			$dropdown.empty();

			var results = $.map(rdata, function(e, f) {
				$dropdown.append($("<option></option>").attr("value", f).text(e));
			});

			$('.add-fields').show();
			$('.get-jsonld').show();
				
		},
		error: function(xhr){
			console.log(xhr);
			// alert('Your stuff is messed up.');
		}
	});

	var $doclink = $('.doc-link');

	$doclink.html('<a href="http://schema.org/'+jsonldType.charAt(0).toUpperCase()+jsonldType.slice(1)+'" target="_blank">See documentation on '+jsonldType+' type.</a>');

	$doclink.show();
	// Sort all fields by nesting
	// Delete type and schema from
	delete templateParsed['@type'];
	delete templateParsed['@context'];
	
	// Blank element
	$el = $('#json-table tbody');
	// For each field in JSON
	$.each(templateParsed, function ($key, $value) {
		if($.type($value) == "object") {

			$el.append('<tr><td><p class="title form-field-title">'+$key+'</p></td><td class="json-ld-form-td key-'+$key+'"></td><td><a class="btn add-token">Add Token</a>  <a class="btn nest-type">Nest</a>  <a class="btn" id="remove-row" onclick="this.parentNode.parentNode.parentNode.removeChild(this.parentNode.parentNode); return false;">Remove</a></td></tr>');
			
			$.each($value, function ($nk, $nv) {

				$.ajax({
					async: false,
					url:'admin.php?/cp/addons/settings/json_ld/ajaxcall',
					type:'POST',
					action: 'getTypeFields', 
					data: {
						'action': 'getTypeFields',
						'var': $key
					},
					success: function(rdata){
				
						// Append the select and input field
						$($el).find('.key-'+$key).append('<div class="jsonld-nested-select-separator"><p><select class="jsonld-nested-select select-'+$key+'-'+$nk+'"></select></p><p><input name="'+$key+'-'+$nk+'" class="jsonld-nested-input input-'+$key+'-'+$nk+'" type="text"><i id="filtersubmit" class="fa fa-plus-circle" title="Add token"></i></p></div>');

						// Append options to select
						$.map(rdata, function(e, f) {
							$($el).find('.select-'+$key+'-'+$nk).append($("<option></option>").attr("value", e).text(e));
						});

						$($el).find('.select-'+$key+'-'+$nk+' option[value='+$nk+']').attr('selected', 'selected');
						$($el).find('.input-'+$key+'-'+$nk).val($nv);

					},
					error: function(xhr){

						console.log(xhr);

					}

				});

			});

		} else {
			
			$el.append('<tr><td><p class="title form-field-title">'+$key+'</p></td><td class="json-ld-form-td"><input class="is-medium json-ld-form-input" type="text" name="'+$key+'" value="'+$value+'"/></td><td><a class="btn add-token">Add Token</a>  <a class="btn" id="remove-row" onclick="this.parentNode.parentNode.parentNode.removeChild(this.parentNode.parentNode); return false;">Remove</a></td></tr>');

		}

	});

	// Put the form on the page
	// Be happy
});