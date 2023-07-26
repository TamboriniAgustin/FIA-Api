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