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
	$(".team .brand img.car").on("click", function() {
		$("#updateCarImage img.car").attr("src", $(this).attr("src"));
		$('#modalTeamImage').modal('toggle');
	});
	
	$("#car-image-upload").on("change", function(e) {
		const file = e.target.files[0];
		showImagePreview("#updateCarImage img.new", file);
	});
	
	//Modal update driver image
	$(".team .drivers .driver-card").on("click", function() {
		$("#updateDriverImage img.driver").attr("src", $(this).find(".driver-image-layer img").attr("src"));
		$('#modalDriverImage').modal('toggle');
	});
	
	$("#driver-image-upload").on("change", function(e) {
		const file = e.target.files[0];
		showImagePreview("#updateDriverImage img.new", file);
	});
	
	//Modal add driver
	paginate(8, $("#modalAddDriver .pagination"), $("#modalAddDriver .drivers-list"));
	
	$(".team .drivers .admin-features i.add-driver").on("click", function() {
		$("#modalAddDriver .modal-header span.team-name").text($(this).parent().parent().parent().find(".brand h4").text());
		csRestoreDefaultValues();
		$("#modalAddDriver").modal('toggle');
	});
			
	$("#modalAddDriver .search-button").on("click", function(e) {
		e.preventDefault();
		
		const lastname = $("#addDriverFilters input[name='lastname']").val();
		const country = $("#addDriverFilters #countries-select").attr("value");
		
		$("#modalAddDriver .pagination li").remove();
		$("#modalAddDriver .drivers-list button").filter(function() {
			if(passAddDriverFilter($(this), lastname, country)) {
				$(this).toggle(true);
				$(this).attr("data-filter", "ok");
			} else {
				$(this).toggle(false);
				$(this).attr("data-filter", null);
			}
		});
		paginate(8, $("#modalAddDriver .pagination"), $("#modalAddDriver .drivers-list"));
	});
			
	$("#modalAddDriver .cancel-button").on("click", function(e) { 
		e.preventDefault();
		
		$("#modalAddDriver .pagination li").remove();
		$("#modalAddDriver .drivers-list button").toggle(true);
		$("#modalAddDriver .drivers-list button").attr("data-filter", "ok");
		paginate(8, $("#modalAddDriver .pagination"), $("#modalAddDriver .drivers-list"));
	});
			
	//Modal add team
	paginate(9, $("#modalAddTeam .pagination"), $("#modalAddTeam .teams-list"));
	
	$(".teams-and-drivers .admin-features i.add-team").on("click", function() {
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
	
	$("#modalAddTeam .teams-list button").on("click", function() {
		const teamId = $(this).attr("data-id");
		const teamName = $(this).attr("data-name");
		const color1 = $(this).attr("data-color1");
		const color2 = $(this).attr("data-color2");
		$("#modalAddTeam .add-button").attr("data-teamId", teamId);
		$("#modalAddTeam .add-button").attr("data-teamName", teamName);
		$("#modalAddTeam .add-button").attr("data-color1", color1);
		$("#modalAddTeam .add-button").attr("data-color2", color2);
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
			executeAjax(`season/${currentSeason}/${currentCategory}/add/team/${teamId}?principalColor=${color1}&secondaryColor=${color2}`, "POST", $(this), "ajaxTeamAdded", "ajaxTeamNotAdded");
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
	const lastnameCheck = $(element).find(".flip-card .last-name").text().toLowerCase().includes(lastname.toLowerCase());
	const countryCheck = $(element).find(".flip-card .flag").attr("data-value").toLowerCase().includes(country.toLowerCase());
	
	return lastnameCheck && countryCheck;
}

function passAddTeamFilter(element, name, country) {
	const nameCheck = $(element).find(".team-card-container .name").text().toLowerCase().includes(name.toLowerCase());
	const countryCheck = $(element).find(".team-card-container .flag").attr("data-value").toLowerCase().includes(country.toLowerCase());
	
	return nameCheck && countryCheck;
}

function ajaxTeamAdded() {
	showResponseAlert("success", "Team added", false, null, 'top-end');
	setTimeout(function() {
		location.reload();
    }, 3000);
}

function ajaxTeamNotAdded() {
	showResponseAlert("error", "Something goes wrong...", false, 1500, "center");
}