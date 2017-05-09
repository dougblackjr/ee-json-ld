// SCOPING FUNCTION
(function() {

	// Set Globals
	var type = '';

	// WHEN TYPE CHANGE, BUILD THE FORM
	$( "#jsonld-type" ).change(function() {
		// Show the pre div
		$('.add-fields').show();

		// Blur
		$('#jsonld-type').blur();

		// Get jsonld-type field value
		if ($('#jsonld-type option:selected').val() !== type) {
			// Clear the fields if you're picking again
			$("#json-table tbody").empty();
		}

		type = $('#jsonld-type option:selected').val();
		
		// Make the AJAX call
		$.ajax({
			url:'admin.php?/cp/addons/settings/json_ld/ajaxcall',
			type:'POST',
			action: 'getTypeFields', 
			data: {
				'action': 'getTypeFields',
				'var': type
			},
			success: function(rdata){
				// Populate the select box
				var $dropdown = $("#jsonld-fields");

				$dropdown.empty();

				var $doclink = $('.doc-link');

				$doclink.html('<a href="http://schema.org/'+type.charAt(0).toUpperCase()+type.slice(1)+'" target="_blank">See documentation on '+type+' type.</a>');

				$doclink.show();

				var results = $.map(rdata, function(e, f) {
					$dropdown.append($("<option></option>").attr("value", f).text(e));
				});
				
			},
			error: function(xhr){
				console.log(xhr);
				// alert('Your stuff is messed up.');
			}
		});

	});

	// ADD FIELD BUTTONS
	$("#add-field-button").on('click', function(event) {
		
		// Show Get button
		$('.get-jsonld').show();

		// Blur
		$('#jsonld-fields').blur();

		var $el = $("#json-table");
		
		var $selected = $("#jsonld-fields option:selected").text();

		// Test if it's nested
		$.ajax({
			url:'admin.php?/cp/addons/settings/json_ld/ajaxcall',
			type:'POST',
			action: 'getTypeFields', 
			data: {
				'action': 'getTypeFields',
				'var': $selected
			},
			success: function(rdata){
				// Populate the select box
				if (rdata !== "\"no methods\"") {
					
					$("#json-table tbody").append('<tr><td><p class="title form-field-title">'+$selected+'</p></td><td class="json-ld-form-td"><input class="is-medium json-ld-form-input" type="text" name="'+$selected+'" ondrop="drop(event)" ondragover="allowDrop(event)" /></td><td><a class="btn add-token">Add Token</a>  <a class="btn nest-type">Nest</a>  <a class="btn" id="remove-row" onclick="this.parentNode.parentNode.parentNode.removeChild(this.parentNode.parentNode); return false;">Remove</a></td></tr>');

				} else {

					$("#json-table tbody").append('<tr><td><p class="title form-field-title">'+$selected+'</p></td><td class="json-ld-form-td"><input class="is-medium json-ld-form-input" type="text" name="'+$selected+'" ondrop="drop(event)" ondragover="allowDrop(event)" /></td><td><a class="btn add-token">Add Token</a>  <a class="btn" id="remove-row" onclick="this.parentNode.parentNode.parentNode.removeChild(this.parentNode.parentNode); return false;">Remove</a></td></tr>');

				}
				
			},
			error: function(xhr){
				console.log(xhr);
				// alert('Your stuff is messed up.');
			}
		});

	});

	// Get token count and create it and add it to box
	$(document).on('click', '.add-token', function(event) {
		
		$(this).closest('tr').find('.json-ld-form-input').val(function () {
			return this.value + '##token'+$token+'##';
		});

		$('#token-farm').append('<a class="token-drag fa fa-plus-circle" draggable="true" ondragstart="drag(event)">##token'+$token+'##</a>');

		$token++;

	});

	// Nest type in type
	$(document).on('click', '.nest-type', function(event) {
		
		// Get name of nested type
		var nestedType = $(this).closest('tr').find('.form-field-title').text();

		var el = this;

		$.ajax({
			url:'admin.php?/cp/addons/settings/json_ld/ajaxcall',
			type:'POST',
			action: 'getTypeFields', 
			data: {
				'action': 'getTypeFields',
				'var': nestedType
			},
			success: function(rdata){
				
				// Destroy input element
				$(el).closest('tr').find('.json-ld-form-input').remove();

				// Append the select and input field
				$(el).closest('tr').find('.json-ld-form-td').append('<div class="jsonld-nested-select-separator"><p><select class="jsonld-nested-select"></select></p><p><input name ="" class="jsonld-nested-input" type="text" ondrop="drop(event)" ondragover="allowDrop(event)" /><i id="filtersubmit" class="fa fa-plus-circle" title="Add token"></i></p></div>');

				// Append options to select
				var results = $.map(rdata, function(e, f) {
					$(el).closest('tr').find('.jsonld-nested-select').append($("<option></option>").attr("value", f).text(e));
				});
				
			},
			error: function(xhr){

				console.log(xhr);

			}

		});

	});

	$(document).on('change', '.jsonld-nested-select', function(event) {
		
		var selected = $('option:selected', this).text();

		var parentType = $(this).closest('tr').find('.form-field-title').text();

		$(this).closest('.jsonld-nested-select-separator').find('.jsonld-nested-input').attr('name', parentType + '-' + selected);

	});

	// Run Template getter
	$(document).on('keyup keypress blur change', '#json-ld-form-form, input', function(event) {

		var formData = $('#json-ld-form-form').serializeArray();
		
		// Make ajax call with serialized data
		$.ajax({
			url:'admin.php?/cp/addons/settings/json_ld/ajaxcall',
			type:'POST',
			action: 'getJSONLD', 
			data: {
				'action': 'getJSONLD',
				'var': formData
			},
			success: function(rdata){
				
				// If success, then send to form div below
    			// Make it pretty
    			var pretty = JSON.stringify(rdata, undefined, 4);
				
    			var notPretty = JSON.stringify(rdata, undefined, 0);

				$('#json-ld-template-final').val(notPretty);

				$('#json-ld-show-template').text(pretty);
				

			},
			error: function(xhr){

				console.log(xhr);

			}

		});

	});

	$(document).on('click', '#filtersubmit', function(event) {
		
		$(this).closest('p').find('input').val(function () {
			return this.value + '##token'+$token+'##';
		});

		$token++;

	});

	// VALIDATE FORM ON SUBMIT

	// MODAL AND GOOGLE VALIDATION
	$(document).on('click', '#google-validate-button', function() {
		$('#modal-ter').addClass('is-active');
		
		// Make ajax call with json data
		formData = $('#json-ld-template-final').val();
		
		$.ajax({
			url:'admin.php?/cp/addons/settings/json_ld/ajaxcall',
			type:'POST',
			action: 'googleValidate', 
			data: {
				'action': 'googleValidate',
				'var': formData
			},
			success: function(rdata){
				
				// If success, then send to modal
				console.log('success');
				console.log(rdata);

			},
			error: function(xhr){

				console.log('error');
				console.log(xhr);

			}
		});
	});

	$(document).on('click', '#close-modal', function() {
		$('#modal-ter').removeClass('is-active');
	});

})();