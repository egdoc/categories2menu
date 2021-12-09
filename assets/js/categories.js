document.addEventListener('DOMContentLoaded', function() {
	"use_strict";

	const checkall_input = document.getElementById('cat2menu_checkall');
	const checkboxes = document.querySelectorAll('input[type="checkbox"]');
	const cat2menu_form = document.getElementById("cat2menu_form");

	checkall_input.addEventListener('change', function(element) {
		for (let i=0; i < checkboxes.length; i++) {
			checkboxes[i].checked = checkall_input.checked;
		}
	});

	cat2menu_form.addEventListener("submit", function(event) {
		if (document.querySelectorAll(':checked').length == 0) {
			alert("You must select at least one category!");
			event.preventDefault();
		}
	});

});
