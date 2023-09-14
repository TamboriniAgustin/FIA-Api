$( document ).ready(function() {
	$('[data-toggle="tooltip"]').tooltip();

	//Splide
	new Splide('.splide', {
		arrows: false,
		pagination: true,
		perPage: 1,
		drag: false
	}).mount();
	
	$($(".splide__pagination__page")[0]).text("Teams & Drivers");
	$($(".splide__pagination__page")[1]).text("Race & Results");
	$($(".splide__pagination__page")[2]).text("Standings");
	
	//Modal update car image
	$(".team .brand img.car.admin-features").on("click", function() {
		$("#updateCarImage img.car").attr("src", $(this).attr("src"));
		$("#modalTeamImage").attr("data-currentTeam", $(this).attr("data-teamId"));
		$('#modalTeamImage').modal('toggle');
	});
	
	$("#car-image-upload").on("change", function(e) {
		const file = e.target.files[0];
		showImagePreview("#updateCarImage img.new", file);
	});
	
	$("#modalTeamImage .save-changes").on("click", function() {
		const teamId = $("#modalTeamImage").attr("data-currentTeam");
		const file = document.getElementById("car-image-upload").files[0];
		
		if(file != undefined) {
			 const formData = new FormData();
  			formData.append('file', file);
  			
			executeAjax(`season/${currentSeason}/${currentCategory}/team/${teamId}/image`, "PUT", $(this), "ajaxTeamImageUpdated", "ajaxInternalServerError", formData);
		} else {
			showResponseAlert('error', 'No image uploaded', false, 1500, "center");		
		}
	});
	
	//Modal update driver image
	$(".team .drivers .driver-card").on("click", function() {
		$("#updateDriverImage img.driver").attr("src", $(this).find(".driver-image-layer img").attr("src"));
		$("#modalDriverImage").attr("data-currentTeam", $(this).parent().parent().parent().parent().parent().parent().attr("data-id"));
		$("#modalDriverImage").attr("data-currentDriver", $(this).parent().parent().parent().parent().attr("data-id"));
		$('#modalDriverImage').modal('toggle');
	});
	
	$("#driver-image-upload").on("change", function(e) {
		const file = e.target.files[0];
		showImagePreview("#updateDriverImage img.new", file);
	});
	
	$("#modalDriverImage .save-changes").on("click", function() {
		const teamId = $("#modalDriverImage").attr("data-currentTeam");
		const driverId = $("#modalDriverImage").attr("data-currentDriver");
		const file = document.getElementById("driver-image-upload").files[0];
		
		if(file != undefined) {
			const formData = new FormData();
  			formData.append('file', file);
  			
			executeAjax(`season/${currentSeason}/${currentCategory}/${teamId}/driver/${driverId}/image`, "PUT", $(this), "ajaxDriverImageUpdated", "ajaxInternalServerError", formData);
		} else {
			showResponseAlert('error', 'No image uploaded', false, 1500, "center");	
		}
	});
	
	//Modal add driver
	$(".team .drivers .admin-features i.add-driver").on("click", function() {
		const teamSelected = $(this).parent().parent().parent();
		
		if(!$("#modalAddDriver .drivers-list button").length) {
			$("#modalAddDriver").attr("data-currentTeam", $(teamSelected).attr("data-id"));
			executeAjax(`season/other/drivers`, "GET", $(this), "ajaxDriversListeds", "ajaxInternalServerError");
		} else {
			//Hide the actual team drivers
			const actualTeamDrivers = $(teamSelected).find(".drivers .driver").filter(function() {
	    		return !$(this).hasClass('replaced');
			});
			
			actualTeamDrivers.each(function() {
				const driverId = $(this).attr("data-id");
				const firstName = $(this).find(".flip-card .overlay-name .first-name").text();
				const lastName = $(this).find(".flip-card .overlay-name .last-name").text();
				hideCurrentTeamDriver(driverId, firstName, lastName);
			});
			
			$("#modalAddDriver .pagination li").remove();
			paginate(8, $("#modalAddDriver .pagination"), $("#modalAddDriver .drivers-list"));
			
			csRestoreDefaultValues();
			$("#modalAddDriver .modal-header span.team-name").text($(this).parent().parent().parent().find(".brand h4").text());
			$("#modalAddDriver .add-button").attr("data-teamId", $(teamSelected).attr("data-id"));
			$("#modalAddDriver").modal('toggle');			
		}
	});
	
	$("#modalAddDriver").on('hidden.bs.modal', function() {
		$("#modalAddDriver .selected-driver select[name='driverReplaced'] option:not(:first-child)").remove();
		$(`#modalAddDriver .drivers-list button`).parent().toggle(true);
		$(`#modalAddDriver .drivers-list button`).attr("data-filter", "ok");
		$(`#modalAddDriver .drivers-list button`).attr("data-hided", null);
	});
			
	$("#modalAddDriver .search-button").on("click", function(e) {
		e.preventDefault();
		
		const lastname = $("#addDriverFilters input[name='lastname']").val();
		const country = $("#addDriverFilters #countries-select").attr("value");
		
		$("#modalAddDriver .drivers-list button[data-hided!=true]").filter(function() {
			if(passAddDriverFilter($(this), lastname, country)) {
				$(this).parent().toggle(true);
				$(this).attr("data-filter", "ok");
			} else {
				$(this).parent().toggle(false);
				$(this).attr("data-filter", null);
			}
		});
		
		$("#modalAddDriver .pagination li").remove();
		paginate(8, $("#modalAddDriver .pagination"), $("#modalAddDriver .drivers-list"));
	});
			
	$("#modalAddDriver .cancel-button").on("click", function(e) { 
		e.preventDefault();
		
		$("#modalAddDriver .pagination li").remove();
		$("#modalAddDriver .drivers-list button").parent().toggle(true);
		$("#modalAddDriver .drivers-list button").attr("data-filter", "ok");
		paginate(8, $("#modalAddDriver .pagination"), $("#modalAddDriver .drivers-list"));
	});
	
	$("#modalAddDriver .add-button").on("click", function() {
		const step = $(this).attr("data-step");
		const driverId = $(this).attr('data-driverId');
		const teamId = $(this).attr('data-teamId');
		
		if(step == 1) {
			if(driverId) {
				$("#modalAddDriver .filters").hide();
				$("#modalAddDriver .drivers-list").hide();
				$("#modalAddDriver .pagination").hide();
				$("#modalAddDriver .close-button").hide();
				
				$(this).attr("data-step", 2);
				
				$("#modalAddDriver .modal-title span.driver-name").text($(this).attr('data-driverName'));
				$("#modalAddDriver .goback-button").show();
				
				const driverCard = $(`#modalAddDriver .drivers-list button[data-id='${driverId}']`).clone();
				$("#modalAddDriver .selected-driver .selected-driver-card").append(driverCard);
				$("#modalAddDriver .selected-driver").css("display", "flex");
			} else {
				showResponseAlert('error', 'No driver selected', false, 1500, "center");
			}
			
			return;
		}
		
		if(step == 2) {
			const number = $("#modalAddDriver .selected-driver input[name='number']").val();
			const seat = $("#modalAddDriver .selected-driver input[name='seat']").val();
			const driverReplaced = $("#modalAddDriver .selected-driver select[name='driverReplaced']").val();
			executeAjax(`season/${currentSeason}/${currentCategory}/add/driver/${driverId}/${teamId}?number=${number}&seat=${seat}&driverReplaced=${driverReplaced}`, "POST", $(this), "ajaxDriverAdded", "ajaxInternalServerError");
		}
	});
	
	$("#modalAddDriver .goback-button").on("click", function() {
		$(this).hide();
		$("#modalAddDriver .selected-driver").hide();
		$("#modalAddDriver .selected-driver .selected-driver-card button").remove();
		
		$("#modalAddDriver .add-button").attr("data-step", 1);
		
		$("#modalAddDriver .modal-title span.driver-name").text("driver");
		$("#modalAddDriver .filters").show();
		$("#modalAddDriver .drivers-list").show();
		$("#modalAddDriver .pagination").show();
		$("#modalAddDriver .close-button").show();
	});
			
	//Modal add team
	$(".teams-and-drivers .admin-features i.add-team").on("click", function() {
		if(!$("#modalAddTeam .teams-list button").length) {
			const seasonTeams = $(".teams-and-drivers div.team").map(function() {
				return $(this).data('id');
			}).get();
			
			const jsonData = {
				teams: seasonTeams
			}
			const base64JsonData = btoa(JSON.stringify(jsonData));
			executeAjax(`season/other/teams?data=${base64JsonData}`, "GET", $(this), "ajaxTeamsListeds", "ajaxInternalServerError");
		}
		
		csRestoreDefaultValues();
		$("#modalAddTeam").modal('toggle');
 	});
			
	$("#modalAddTeam .search-button").on("click", function(e) {
		e.preventDefault();
		
		const name = $("#addTeamFilters input[name='name']").val();
		const country = $("#addTeamFilters #countries-select").attr("value");
		
		$("#modalAddTeam .pagination li").remove();
		$("#modalAddTeam .teams-list button").filter(function() {
			if(passAddTeamFilter($(this), name, country)) {
				$(this).parent().toggle(true);
				$(this).attr("data-filter", "ok");
			} else {
				$(this).parent().toggle(false);
				$(this).attr("data-filter", null);
			}
		});
		paginate(9, $("#modalAddTeam .pagination"), $("#modalAddTeam .teams-list"));
	});
			
	$("#modalAddTeam .cancel-button").on("click", function(e) { 
		e.preventDefault();
		
		$("#modalAddTeam .pagination li").remove();
		$("#modalAddTeam .teams-list button").toggle(true);
		$("#modalAddTeam .teams-list button").attr("data-filter", "ok");
		paginate(9, $("#modalAddTeam .pagination"), $("#modalAddTeam .teams-list"));
	});
	
	$("#modalAddTeam .add-button").on("click", function() {
		const step = $(this).attr("data-step");
		const teamId = $(this).attr('data-teamId');
		
		if(step == 1) {
			if(teamId) {
				$("#modalAddTeam .filters").hide();
				$("#modalAddTeam .teams-list").hide();
				$("#modalAddTeam .pagination").hide();
				$("#modalAddTeam .close-button").hide();
				
				$(this).attr("data-step", 2);
				
				$("#modalAddTeam .modal-title span").text($(this).attr('data-teamName'));
				$("#modalAddTeam .team-colors input[name='color1']").val($(this).attr("data-color1"));
				$("#modalAddTeam .team-colors input[name='color2']").val($(this).attr("data-color2"));
				$("#modalAddTeam .goback-button").show();
				$("#modalAddTeam .team-colors").show();
			} else {
				showResponseAlert('error', 'No team selected', false, 1500, "center");
			}
			
			return;
		}
		
		if(step == 2) {
			const color1 = $("#modalAddTeam .team-colors input[name='color1']").val().replace("#", "%23");
			const color2 = $("#modalAddTeam .team-colors input[name='color2']").val().replace("#", "%23");
			executeAjax(`season/${currentSeason}/${currentCategory}/add/team/${teamId}?principalColor=${color1}&secondaryColor=${color2}`, "POST", $(this), "ajaxTeamAdded", "ajaxInternalServerError");
		}
	});
	
	$("#modalAddTeam .goback-button").on("click", function() {
		$(this).hide();
		$("#modalAddTeam .team-colors").hide();
		
		$("#modalAddTeam .add-button").attr("data-step", 1);
		
		$("#modalAddTeam .modal-title span").text("team");
		$("#modalAddTeam .filters").show();
		$("#modalAddTeam .teams-list").show();
		$("#modalAddTeam .pagination").show();
		$("#modalAddTeam .close-button").show();
	});

	//Show race results
	$(".season-gps table td.actions #show-gp-results").on("click", function() {
		const raceContainer = $(this).parent().parent().parent();

		if($(raceContainer).hasClass("active")) {
			$(raceContainer).removeClass("active");
			$(raceContainer).next().hide();
		} else {
			$(raceContainer).addClass("active");
			$(raceContainer).next().find(".weekend-results-options button.admin-features").hide();
			$(raceContainer).next().find(".weekend-results-options button:not(.admin-features)").show();
			$(raceContainer).next().find(".weekend-results table").hide();
			$(raceContainer).next().find(".weekend-results table.qualifying-table").show();
			$(raceContainer).next().find(".weekend-results-options button").removeClass("active");
			$(raceContainer).next().find(".weekend-results-options button.show-qualifying").addClass("active");
			$(raceContainer).next().show();
		}
	});

	$(".season-gps table .weekend-results-options .show-qualifying").on("click", function() {
		$(".season-gps table .weekend-results-options button").removeClass("active");
		$(this).addClass("active");

		const resultsContainer = $(this).parent().next();
		$(resultsContainer).find("table").hide();
		$(resultsContainer).find(".qualifying-table").show();
	});

	$(".season-gps table .weekend-results-options .show-sprint-race").on("click", function() {
		$(".season-gps table .weekend-results-options button").removeClass("active");
		$(this).addClass("active");

		const resultsContainer = $(this).parent().next();
		$(resultsContainer).find("table").hide();
		$(resultsContainer).find(".sprint-race-table").show();
	});

	$(".season-gps table .weekend-results-options .show-race").on("click", function() {
		$(".season-gps table .weekend-results-options button").removeClass("active");
		$(this).addClass("active");

		const resultsContainer = $(this).parent().next();
		$(resultsContainer).find("table").hide();
		$(resultsContainer).find(".race-table").show();
	});

	$(".season-gps table .weekend-results-options .show-driver-standings").on("click", function() {
		$(".season-gps table .weekend-results-options button").removeClass("active");
		$(this).addClass("active");

		const resultsContainer = $(this).parent().next();
		$(resultsContainer).find("table").hide();
		$(resultsContainer).find(".drivers-standings-table").show();
	});

	$(".season-gps table .weekend-results-options .show-constructor-standings").on("click", function() {
		$(".season-gps table .weekend-results-options button").removeClass("active");
		$(this).addClass("active");

		const resultsContainer = $(this).parent().next();
		$(resultsContainer).find("table").hide();
		$(resultsContainer).find(".constructors-standings-table").show();
	});

	//Edit race results
	$(".season-gps table td.actions #config-gp-race").on("click", function() {
		const raceContainer = $(this).parent().parent().parent();

		if($(raceContainer).hasClass("active")) {
			$(raceContainer).removeClass("active");
			$(raceContainer).next().hide();
		} else {
			$(raceContainer).addClass("active");
			$(raceContainer).next().find(".weekend-results-options button:not(.admin-features)").hide();
			$(raceContainer).next().find(".weekend-results-options button.admin-features").show();
			$(raceContainer).next().find(".weekend-results table").hide();
			$(raceContainer).next().find(".weekend-results table.custom-qualifying-table").show();
			$(raceContainer).next().find(".weekend-results-options button").removeClass("active");
			$(raceContainer).next().find(".weekend-results-options button.edit-qualifying").addClass("active");
			$(raceContainer).next().show();
		}
	});

	$(".season-gps table .weekend-results table.custom-table td .delete-car").on("click", function() {
		dropDriverFromResult($(this));
		$('.tooltip-inner').remove();
		$(".tooltip-arrow").remove();
	});

	$(".season-gps table .weekend-results table.custom-table th .new-car").on("click", function() {
		var cars = $(".drivers .driver-card .overlay .number").map(function() {
			return $(this).text();
		}).get();
		cars = [...new Set(cars)];
		cars = cars.sort(function(a, b) {
			return a - b;
		});		

		addNewCarToResultStep1($(this), cars);
	});

	$(".season-gps table .weekend-results table.custom-table tbody").sortable({
        items: "tr.draggable-row",
        axis: "y",
        cursor: "move",
        handle: "th"
    });
    $(".season-gps table .weekend-results table.custom-table tbody").disableSelection();

	$(".season-gps table .weekend-results-options .edit-qualifying").on("click", function() {
		$(".season-gps table .weekend-results-options button.admin-features").removeClass("active");
		$(this).addClass("active");

		const resultsContainer = $(this).parent().next();
		$(resultsContainer).find("table").hide();
		$(resultsContainer).find(".custom-qualifying-table").show();
	});
	$(".season-gps table .weekend-results-options .edit-sprint-race").on("click", function() {
		$(".season-gps table .weekend-results-options button.admin-features").removeClass("active");
		$(this).addClass("active");

		const resultsContainer = $(this).parent().next();
		$(resultsContainer).find("table").hide();
		$(resultsContainer).find(".custom-sprint-race").show();
	});
	$(".season-gps table .weekend-results-options .edit-race").on("click", function() {
		$(".season-gps table .weekend-results-options button.admin-features").removeClass("active");
		$(this).addClass("active");

		const resultsContainer = $(this).parent().next();
		$(resultsContainer).find("table").hide();
		$(resultsContainer).find(".custom-race").show();
	});

	//Add new gp
	$(".add-grand-prix").on("click", function() {
		if($(".season-gps table .new-gp").is(":visible")) {
			$(".season-gps table .new-gp").hide();
			$(this).removeClass("fa-solid fa-circle-minus").addClass("fa fa-plus-circle");
		} else {
			$(".season-gps table .new-gp").show();
			$(this).removeClass("fa fa-plus-circle").addClass("fa-solid fa-circle-minus");
		}
	});

	//Edit gp
	$(".season-gps table td.actions #config-gp-data").on("click", function() {
		if($(".season-gps table .edit-round").is(":visible")) {
			$(".season-gps table .edit-round").hide();
		} else {
			const raceContainer = $(this).parent().parent().parent();
			const currentRoundNumber = $(raceContainer).find("th").text(); 
			const currentRoundDate = $(raceContainer).find("td:first-of-type").text();
			const currentRoundGp = $(raceContainer).find("td.gp-info .gp-name").attr("data-id");
			const currentRoundCircuit = $(raceContainer).find("td.gp-info .circuit").attr("data-id");
			$(".season-gps table .edit-round input[name='roundNumber']").val(currentRoundNumber);
			$(".season-gps table .edit-round input[name='roundDate']").val(currentRoundDate);
			$(".season-gps table .edit-round input[name='roundNumber']").val(currentRoundNumber);
			$(".season-gps table .edit-round select[name='roundRace']").val(currentRoundGp);
			$(".season-gps table .edit-round select[name='roundCircuit']").val(currentRoundCircuit);
			$(".season-gps table .edit-round").show();
		}
	});

	//Delete gp
	$(".season-gps table td.actions #delete-gp").on("click", function() { 
		$(this).parent().parent().parent().remove();
		$('.tooltip-inner').remove();
		$(".tooltip-arrow").remove();
	});

	//Inputs formats and validations
	$("input[name='roundDate']").on("input", function() {
		// Eliminar cualquier caracter que no sea un número o un punto (.)
		var formattedValue = $(this).val().replace(/[^0-9.]/g, '');

		if(formattedValue.length == 4 || formattedValue.length == 7) {
			formattedValue += ".";
		}
		
		// Actualizar el valor del campo de entrada
		$(this).val(formattedValue);
	});
});
			
/** Functions **/
function loadDefaultCarImage(element) {
	element.onerror = null;
	const imageSrc = "../../img/teams/cars/" + $(".category").attr("data-abbr").toLowerCase() + ".default.png";
	$(element).attr("src", imageSrc);
}

function loadDefaultDriverImage(element) {
	element.onerror = null;
	const imageSrc = "../../img/drivers/default.png";
	$(element).attr("src", imageSrc);
}

function showImagePreview(previewElement, file) {
	const fileReader = new FileReader();
	
	fileReader.onload = function(event) {
      $(previewElement).attr("src", event.target.result);
    };
    
    fileReader.readAsDataURL(file);
}

function passAddDriverFilter(element, lastname, country) {
	if(country == "UNK") {
		country = "";
	}
	
	const lastnameCheck = $(element).find(".flip-card .last-name").text().toLowerCase().includes(lastname.toLowerCase());
	const countryCheck = $(element).find(".flip-card .flag").attr("data-value").toLowerCase().includes(country.toLowerCase());
	
	return lastnameCheck && countryCheck;
}

function passAddTeamFilter(element, name, country) {
	if(country == "UNK") {
		country = "";
	}
	
	const nameCheck = $(element).find(".team-card-container .name").text().toLowerCase().includes(name.toLowerCase());
	const countryCheck = $(element).find(".team-card-container .flag").attr("data-value").toLowerCase().includes(country.toLowerCase());
	
	return nameCheck && countryCheck;
}

function updateNewTeamSelected(element) {
	const teamId = $(element).attr("data-id");
	const teamName = $(element).attr("data-name");
	const color1 = $(element).attr("data-color1");
	const color2 = $(element).attr("data-color2");
	$("#modalAddTeam .add-button").attr("data-teamId", teamId);
	$("#modalAddTeam .add-button").attr("data-teamName", teamName);
	$("#modalAddTeam .add-button").attr("data-color1", color1);
	$("#modalAddTeam .add-button").attr("data-color2", color2);
}

function updateNewDriverSelected(element) {
	const driverId = $(element).attr("data-id");
	const driverName = $(element).attr("data-name");
	$("#modalAddDriver .add-button").attr("data-driverId", driverId);
	$("#modalAddDriver .add-button").attr("data-driverName", driverName);
}

function hideCurrentTeamDriver(id, firstName, lastName) {
	$(`#modalAddDriver .drivers-list button[data-id='${id}']`).parent().toggle(false);
	$(`#modalAddDriver .drivers-list button[data-id='${id}']`).attr("data-filter", null);
	$(`#modalAddDriver .drivers-list button[data-id='${id}']`).attr("data-hided", true);
	
	//Add them to the replaces options
    const formOption = $("<option>");
    $(formOption).attr("value", id).text(firstName+" "+lastName);
    $("#modalAddDriver .selected-driver select[name='driverReplaced']").append(formOption);
}

function addNewCarToResultStep1(element, carsNumbers) {
	//Add the new row
	const $draggableHandlerIcon = $("<i>");
	$draggableHandlerIcon.addClass("fa-solid fa-bars");

	const $draggableHandler = $("<th>");
	$draggableHandler.attr("scope", "row");
	$draggableHandler.addClass("ui-sortable-handle");
	$draggableHandler.append($draggableHandlerIcon);

	const $carNumberSelect = $("<select>");
	$carNumberSelect.attr("id", "newCarNumber");
	$carNumberSelect.attr("onchange", "addNewCarToResultStep2(this)");
	$carNumberSelect.addClass("form-control");
	$carNumberSelect.append("<option selected disabled>N°</option>");
	carsNumbers.forEach(function(car) {
		const $option = $("<option>");
		$option.attr("value", car);
		$option.text(car);
		$carNumberSelect.append($option);
	});

	const $carNumber = $("<td>");
	$carNumber.attr("colspan", 2);
	$carNumber.append($carNumberSelect);

	const $driversInputSelect = $("<select>");
	$driversInputSelect.attr("id", "newCarDrivers");
	$driversInputSelect.attr("multiple", true);
	$driversInputSelect.attr("disabled", true);
	$driversInputSelect.attr("onchange", "addNewCarToResultStep3(this)");
	$driversInputSelect.addClass("form-control");

	const $driversInputContainer = $("<div>");
	$driversInputContainer.addClass("d-flex flex-column justify-content-start align-items-start driver");
	$driversInputContainer.append($driversInputSelect);

	const $drivers = $("<td>");
	$drivers.attr("colspan", 3);
	$drivers.append($driversInputContainer);

	const $successButton = $("<button>");
	$successButton.attr("type", "button");
	$successButton.attr("disabled", true);
	$successButton.attr("onclick", "confirmNewCarForResult(this)");
	$successButton.addClass("btn btn-success");
	$successButton.text("Save");

	const $cancelButton = $("<button>");
	$cancelButton.attr("type", "button");
	$cancelButton.attr("disabled", true);
	$cancelButton.attr("onclick", "discardNewCarForResult(this)");
	$cancelButton.addClass("btn btn-danger");
	$cancelButton.text("Discard");

	const $actionsButtonsContainer = $("<div>");
	$actionsButtonsContainer.addClass("d-flex flex-column justify-content-center align-items-center actions");
	$actionsButtonsContainer.append($successButton);
	$actionsButtonsContainer.append($cancelButton);

	const $actions = $("<td>");
	$actions.append($actionsButtonsContainer);

	const $row = $("<tr>");
	$row.addClass("draggable-row active-customization");
	$row.append($draggableHandler);
	$row.append($carNumber);
	$row.append($drivers);
	$row.append($actions);

	$(element).parent().parent().before($row);
}

function addNewCarToResultStep2(element) { 
	const selectedCar = element.value;
	const carDrivers = $(".teams-and-drivers .team .drivers .driver:not(.replaced)").filter(function() {
		return $(this).find(".overlay .number").text() == selectedCar;
	});

	$(element).parent().next().find("#newCarDrivers").empty();
	carDrivers.each(function() {
		const driverId = $(this).attr("data-id");
		const driverName = $(this).find(".overlay-name .last-name").text() + ", " + $(this).find(".overlay-name .first-name").text();
		
		const $option = $("<option>");
		$option.attr("value", driverId);
		$option.text(driverName);
		$(element).parent().next().find("#newCarDrivers").append($option);
	});
	$(element).parent().next().find("#newCarDrivers").attr("disabled", false);
}

function addNewCarToResultStep3(element) {
	const selectedDrivers = $(element).val();
	if(selectedDrivers.length > 0) {
		$(element).parent().parent().next().find("button").attr("disabled", false);
	} else {
		$(element).parent().parent().next().find("button").attr("disabled", true);
	}
}

function confirmNewCarForResult(element) {
	//Get the car data
	const carData = $(element).parent().parent().prev().prev().find("#newCarNumber").val();
	const drivers = $(element).parent().parent().prev().find("#newCarDrivers").val();

	//Add the new row
	const $draggableHandlerIcon = $("<i>");
	$draggableHandlerIcon.addClass("fa-solid fa-bars");

	const $draggableHandler = $("<th>");
	$draggableHandler.attr("scope", "row");
	$draggableHandler.addClass("ui-sortable-handle");
	$draggableHandler.append($draggableHandlerIcon);

	const $carNumber = $("<td>");
	$carNumber.text(carData);

	const $driversContainer = $("<div>");
	$driversContainer.addClass("d-flex flex-column justify-content-start align-items-start driver");
	drivers.forEach(function(driverId) {
		const driver = $(`.teams-and-drivers .team .driver[data-id='${driverId}']:not(.replaced)`);
		
		const $driverPicture = $(driver).find(".driver-image-layer img").clone().addClass("picture");
		const $removeDriverAction = $("<i>");
		$removeDriverAction.addClass("fa-solid fa-delete-left delete-car");
		$removeDriverAction.attr("aria-hidden", "true");
		$removeDriverAction.attr("data-toggle", "tooltip");
		$removeDriverAction.attr("data-bs-original-title", "Drop driver");
		$removeDriverAction.attr("aria-label", "Drop driver");
		$removeDriverAction.attr("onclick", "dropDriverFromResult(this)");
		$removeDriverAction.tooltip();
		const $driverName = $("<p>");
		$driverName.addClass("driver-name");
		$driverName.text($(driver).find(".overlay-name .first-name").text() + " " + $(driver).find(".overlay-name .last-name").text());
		$driverName.append($removeDriverAction);
		const $driverDiv = $("<div>");
		$driverDiv.addClass("d-flex justify-content-start align-items-start driver");
		$driverDiv.append($driverPicture);
		$driverDiv.append($driverName);

		$driversContainer.append($driverDiv);
	});
	const $drivers = $("<td>");
	$drivers.append($driversContainer);

	const $teamElement = $(`.teams-and-drivers .team .driver[data-id='${drivers[0]}']:not(.replaced)`).parent().parent();
	const $teamLogo = $teamElement.find(".brand .logo").clone();
	const $teamName = $teamElement.find(".brand h4").text();
	const $teamContainer = $("<div>");
	$teamContainer.addClass("d-flex justify-content-start align-items-start constructor");
	$teamContainer.append($teamLogo);
	$teamContainer.append($teamName);
	const $team = $("<td>");
	$team.append($teamContainer);

	const $row = $("<tr>");
	$row.addClass("draggable-row active-customization");
	$row.append($draggableHandler);
	$row.append($carNumber);
	$row.append($drivers);
	$row.append($team);

	//Map the fields for specific rules
	const raceRules = {
		tableType: $(element).parent().parent().parent().parent().parent().attr("data-type"),
		qnumber: $(element).parent().parent().parent().parent().parent().attr("data-qnumbers")
	}
	mapRaceRulesFields($row, raceRules);

	$(element).parent().parent().parent().before($row);
	$(element).parent().parent().parent().remove();
}

function mapRaceRulesFields(row, rules) {
	if(rules.tableType == "QUALY") {
		for (let i=0; i<rules.qnumber; i++) {
			const $qTime = $("<td>");
			
			const $input = $("<input>");
			$input.addClass("form-control");
			$input.attr("type", "text");
			
			$qTime.append($input);
			$(row).append($qTime);
		}
	} else if(rules.tableType == "RACE") {
		const $startingGrid = $("<td>");
		const $startingGridInput = $("<input>");
		$startingGridInput.addClass("form-control");
		$startingGridInput.attr("type", "number");
		$startingGrid.append($startingGridInput);

		const $fastestLap = $("<td>");
		const $fastestLapInput = $("<input>");
		$fastestLapInput.addClass("form-control");
		$fastestLapInput.attr("type", "text");
		$fastestLap.append($fastestLapInput);

		$(row).append($startingGrid);
		$(row).append($fastestLap);
	}
}

function discardNewCarForResult(element) {
	$(element).parent().parent().parent().remove();
}

function dropDriverFromResult(element) {
	const $driversContainer = $(element).parent().parent().parent();
	if($driversContainer.children().length > 1) {
		const $driverContainer = $(element).parent().parent();
		$driverContainer.remove();
	} else {
		const $row = $driversContainer.parent().parent();
		$row.remove();
	}
}

function ajaxTeamsListeds(data) {
	Object.keys(data).forEach(key => {
		const value = data[key];
		Object.keys(value).forEach(cId => {
			const constructor = value[cId];
			
			const button = $("<button>").append(generateTeamCardFromJs(constructor.id, constructor.name, constructor.principalColor, constructor.country));
			$(button)
				.attr("data-filter", "ok")
				.attr("data-id", constructor.id)
				.attr("data-name", constructor.name)
				.attr("data-color1", constructor.principalColor)
				.attr("data-color2", constructor.secondaryColor)
				.attr("onclick", "updateNewTeamSelected(this)");
			const parentButton = $("<div>").append(button);
			
			$("#modalAddTeam .teams-list").append(parentButton);
		});
	});
	paginate(9, $("#modalAddTeam .pagination"), $("#modalAddTeam .teams-list"));
}

function ajaxDriversListeds(data) {
	const currentTeam = $("#modalAddDriver").attr("data-currentTeam");
	const teamDrivers = $(`.teams-and-drivers .team[data-id='${currentTeam}'] div.driver`).filter(function() {
		return !$(this).hasClass('replaced');
	}).map(function() {
		return $(this).data('id');
	}).get();
	
	//List all the drivers that aren't part of the team
	Object.keys(data).forEach(key => {
		const value = data[key];
		Object.keys(value).forEach(dId => {
			const driver = value[dId];
			
			var teamId = driver.lastTeam;
			var teamColor = "#ffffff";
			if(driver.team != null) {
				teamId = driver.team.id;
				teamColor = driver.team.principalColor;
			}
			
			const button = $("<button>").append(generateDriverCardFromJs(driver.id, driver.firstName, driver.lastName, driver.country, teamId, teamColor, driver.lastSeason, currentCategory, driver.number));
			$(button)
				.attr("data-filter", "ok")
				.attr("data-id", driver.id)
				.attr("data-name", driver.firstName+' '+driver.lastName)
				.attr("onclick", "updateNewDriverSelected(this)");
			const parentDiv = $("<div>").append(button);
			
			$("#modalAddDriver .drivers-list").append(parentDiv);
			
			//Hide the drivers from the current team
			if(teamDrivers.includes(driver.id)) {
				hideCurrentTeamDriver(driver.id, driver.firstName, driver.lastName);
			}
		});
	});
	
	$("#modalAddDriver .pagination li").remove();
	paginate(8, $("#modalAddDriver .pagination"), $("#modalAddDriver .drivers-list"));
	
	$("#modalAddDriver .modal-header span.team-name").text($(this).parent().parent().parent().find(".brand h4").text());
	$("#modalAddDriver .add-button").attr("data-teamId", $(currentTeam).attr("data-id"));
	$("#modalAddDriver").modal('toggle');	
}

function ajaxDriverAdded() {
	showResponseAlert("success", "Driver added", false, null, 'top-end');
	setTimeout(function() {
		location.reload();
    }, 3000);
}

function ajaxDriverImageUpdated() {
	const teamId = $("#modalDriverImage").attr("data-currentTeam");
	const driverId = $("#modalDriverImage").attr("data-currentDriver");
	const imageSrc = $("#updateDriverImage label[for='driver-image-upload'] img").attr("src");
	
	$(`.teams-and-drivers .team[data-id=${teamId}] .driver[data-id=${driverId}] .driver-image-layer img`).attr("src", imageSrc);
	showResponseAlert("success", "Driver image updated", false, 3000, 'center');
	$("#modalDriverImage").modal("hide");
}

function ajaxTeamAdded() {
	showResponseAlert("success", "Team added", false, null, 'top-end');

	setTimeout(function() {
		location.reload();
    }, 3000);
}

function ajaxTeamImageUpdated() {
	const teamId = $("#modalTeamImage").attr("data-currentTeam");
	const imageSrc = $("#updateCarImage label[for='car-image-upload'] img").attr("src");
	
	$(`.teams-and-drivers .team[data-id=${teamId}] .brand .car`).attr("src", imageSrc);
	showResponseAlert("success", "Team image updated", false, 3000, 'center');
	$("#modalTeamImage").modal("hide");
}