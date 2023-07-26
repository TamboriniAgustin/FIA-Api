/************************************************** Global Variables **************************************************/
const contextPath = "";
//Countries select
var menuShowed = false;
//Countries menu
const initial_countries_shown = 12; //Countries shown per page (pagination)
var activeCountries = initial_countries_shown; //Countries page showed (pagination)
var actualFilteredCountries = null; //List of countries filtered at this moment (filters)
var actualFilteredContinent = null; //Continent filtered at this moment (filters)
var actualFilteredLetter = null; //Letter filtered at this moment (filters)
//AJAX
var loadingAlert = null;
var inAjaxRequest = false;

$(document).ready(function () {
    /************************************************** Tooltips **************************************************/
    $(".countries-select #countries-menu .country-data img").tooltip({placement: "bottom"});
    
    /************************************************** Countries Select **************************************************/
    $(".countries-select").on("click", function() {
        if(menuShowed) {
            $(this).parent().find("#countries-menu").hide();
            menuShowed = false;
        } else {
            $(this).parent().find("#countries-menu").show();
            menuShowed = true;
        }
    });

    $(".country-data").on("click", function() {
        const selectedCountry = $(this).attr("value");
        
        //Set the selected country value
        $(this).parent().parent().parent().parent().parent().find("#countries-select").attr("value", selectedCountry);
        $(this).parent().parent().parent().parent().parent().find("#countries-select").css("background-image", `url(${window.location.origin}/${contextPath}/img/countries/${selectedCountry}.png`);

        //Hide the menu
        $(this).parent().parent().parent().parent().hide();
        menuShowed = false;
    });

    //Load the initial countries when the DOM is ready
    getActiveCountries($(".countries-select").parent().find("#countries-menu"), 0, initial_countries_shown).show();

    //Pagination
    $("#countries-menu .back-arrow").on("click", function () {
        if(!$(this).hasClass("disabled")) {
            //Get information about countries showed and update of the variable with the new countries that gonna be shown
            const actualMaxIndex = activeCountries;
            const actualMinIndex = activeCountries - initial_countries_shown;
            activeCountries -= initial_countries_shown;

            //Hide countries showed and show the new countries
            getActiveCountries($(this).parent().parent(), actualMinIndex, actualMaxIndex, actualFilteredCountries != null).hide();
            getActiveCountries($(this).parent().parent(), activeCountries - initial_countries_shown, activeCountries, actualFilteredCountries != null).show();
            
            //Check if are countries in the prev page and block the button if not
            $(this).parent().find(".next-arrow").removeClass("disabled");
            if(isTheFirstPage()) {
                $(this).addClass("disabled");
            }
        }
    });
    $("#countries-menu .next-arrow").on("click", function () {
        if(!$(this).hasClass("disabled")) {
            //Get information about countries showed and update of the variable with the new countries that gonna be shown
            const actualMaxIndex = activeCountries;
            const actualMinIndex = activeCountries - initial_countries_shown;
            activeCountries += initial_countries_shown;

            //Hide countries showed and show the new countries
            getActiveCountries($(this).parent().parent(), actualMinIndex, actualMaxIndex, actualFilteredCountries != null).hide();
            var countriesToActivate = getActiveCountries($(this).parent().parent(), actualMaxIndex, activeCountries, actualFilteredCountries != null);
            countriesToActivate.show();

            //Check if are countries in the next page and block the button if not
            $(this).parent().find(".back-arrow").removeClass("disabled");
            if(isTheLastPage(countriesToActivate)){
                $(this).addClass("disabled");
            }
        }
    });

    //Filters
    $("#countries-menu .continent-filter .continent").on("click", function () {
        //Hover the current selection
        $(this).parent().find(".continent[active=true]").removeAttr("active");
        $(this).attr("active", true);

        //Hide current countries showed
        const actualMaxIndex = activeCountries;
        const actualMinIndex = activeCountries - initial_countries_shown;
        getActiveCountries($(this).parent().parent().parent(), actualMinIndex, actualMaxIndex, actualFilteredCountries != null).hide();
        
        //Reset the activeCountries to initial value
        activeCountries = initial_countries_shown;
        
        //Obtain the countries of the selected continent
        actualFilteredContinent = $(this).html();
        actualFilteredCountries = $(this).parent().parent().parent().find(`.country-data[continent='${actualFilteredContinent}']`);

        //If exists a filter by letter just choose the countries that starts with that letter
        if(actualFilteredLetter != null) {
            actualFilteredCountries = $(actualFilteredCountries).filter(function() {
                return $(this).attr("name") == actualFilteredLetter;
            })
        }
        
        //Config the filterIndex for every country selected
        configFilterIndex(actualFilteredCountries);

        //Show the selected countries
        const countriesToActivate = getActiveCountries($(this).parent().parent().parent(), 0, initial_countries_shown, true).show();

        //Block the go-back arrow and check if the next arrow is enabled
        $(this).parent().parent().parent().find(".back-arrow").addClass("disabled");
        if(isTheLastPage(countriesToActivate)){
            $(this).parent().parent().parent().find(".next-arrow").addClass("disabled");
        } else {
            $(this).parent().parent().parent().find(".next-arrow").removeClass("disabled");
        }
    });

    $("#countries-menu .letter-filter .letter").on("click", function () {
        //Hover the current selection
        $(this).parent().find(".letter[active=true]").removeAttr("active");
        $(this).attr("active", true);

        //Hide current countries showed
        const actualMaxIndex = activeCountries;
        const actualMinIndex = activeCountries - initial_countries_shown;
        getActiveCountries($(this).parent().parent().parent(), actualMinIndex, actualMaxIndex, actualFilteredCountries != null).hide();

        //Reset the activeCountries to initial value
        activeCountries = initial_countries_shown;

        //Obtain the countries that starts with the selected letter
        actualFilteredLetter = $(this).html();
        actualFilteredCountries = $(this).parent().parent().parent().find(`.country-data[name='${actualFilteredLetter}']`);

        if(actualFilteredContinent != null) {
            actualFilteredCountries = $(actualFilteredCountries).filter(function() {
                return $(this).attr("continent") == actualFilteredContinent;
            })
        }

        //Config the filterIndex for every country selected
        configFilterIndex(actualFilteredCountries);

        //Show the selected countries
        const countriesToActivate = getActiveCountries($(this).parent().parent().parent(), 0, initial_countries_shown, true).show();

        //Block the go-back arrow and check if the next arrow is enabled
        $(this).parent().parent().parent().find(".back-arrow").addClass("disabled");
        if(isTheLastPage(countriesToActivate)){
            $(this).parent().parent().parent().find(".next-arrow").addClass("disabled");
        } else {
            $(this).parent().parent().parent().find(".next-arrow").removeClass("disabled");
        }
    });
});

//Countries menu
function isTheFirstPage() {
    return (activeCountries-initial_countries_shown) < initial_countries_shown;
}

function isTheLastPage(countriesToActivate) {
    return countriesToActivate.length < initial_countries_shown;
}

function configFilterIndex(countries) {
    $.each(countries, function (index, country) { 
        $(country).attr("filterIndex", index+1);
    });
}

function getActiveCountries(menuElement, minIndex = 0, maxIndex = initial_countries_shown, isFiltered = false) {
    //Filters
    if(isFiltered) {
        return $(actualFilteredCountries).filter(function(){
            return ($(this).attr('filterIndex') > minIndex) && ($(this).attr('filterIndex') <= maxIndex);
        });
    }

    //Default
    return $(menuElement).find(".country-data").filter(function(){
        return ($(this).attr('index') > minIndex) && ($(this).attr('index') <= maxIndex);
    });
}

function csRestoreDefaultValues() {
	menuShowed = false;
	activeCountries = initial_countries_shown;
	actualFilteredCountries = null;
	actualFilteredContinent = null;
	actualFilteredLetter = null;
}

/************************************************** Elements pagination **************************************************/
function paginate(pageSize, paginationDiv, elementsDiv) {
	const elements = $(elementsDiv).find("[data-filter='ok']");
	const pages = Math.ceil(elements.length / pageSize);

	//Add pages
	const previousPage = newFunctionPage("&laquo;");
	$(previousPage).bind('click', {newPage: i}, function() {
		const activePage = $(this).parent().find(".active");
		if(activePage.text() > 1) {
			$(activePage).prev().children().click();
		}
    });
	$(paginationDiv).append(previousPage);
	
	for(var i=1; i<=pages; i++) {
		const page = newPage(i);
		$(page).bind('click', {newPage: i}, function(event) {
            //Classes updates
            $(this).parent().find(".active").removeClass("active");
            $(this).addClass("active");
			
			//Hide elements
			$(elements).parent().hide();
			const currentPage = event.data['newPage'];
			const startIndex = (currentPage - 1) * pageSize;
			const endIndex = startIndex + pageSize;
            $(elements).parent().slice(startIndex, endIndex).show();
            
            //Update prev and next buttons
        	$(this).parent().find("li:first-of-type").removeClass("disabled");
        	$(this).parent().find("li:last-of-type").removeClass("disabled");
            if(currentPage == 1) {
            	$(this).prev().addClass("disabled");
            } else if(currentPage == pages) {
            	$(this).next().addClass("disabled");
            }
        });
		$(paginationDiv).append(page);
	}
	
	const nextPage = newFunctionPage("&raquo;");
	$(nextPage).bind('click', {newPage: i}, function() {
		const activePage = $(this).parent().find(".active");
		if(activePage.text() != pages) {
			$(activePage).next().children().click();
		}
    });
	$(paginationDiv).append(nextPage);
	
	$(paginationDiv).find("li:nth-child(2) button").click();
}

function newFunctionPage(html) {
	const page = $("<button>");
	$(page).addClass("page-link");
	$(page).html("<span aria-hidden='true'>"+html+"</span>");
	
	const pageContainer = $("<li>");
	$(pageContainer).addClass("page-item");
	$(pageContainer).append(page);
	
	return pageContainer;
}
			
function newPage(pageNumber) {
	const page = $("<button>");
	$(page).addClass("page-link");
	$(page).text(pageNumber);
	
	const pageContainer = $("<li>");
	$(pageContainer).addClass("page-item");
	$(pageContainer).append(page);
	
	return pageContainer;
}

/************************************************** Sweet Alert Messages **************************************************/
function showResponseAlert(type, title, hasConfirmButton, timer, position) {
	Swal.fire({
		icon: type,
		title: title,
		showConfirmButton: hasConfirmButton,
		timer: timer,
		position: position
	});
}

function showLoadingAlert() {
	loadingAlert = Swal.mixin({
		title: 'Loading...',
		didOpen: () => {
			Swal.showLoading()
			const b = Swal.getHtmlContainer().querySelector('b')
			timerInterval = setInterval(() => {
				b.textContent = Swal.getTimerLeft()
			}, 100)
		},
		willClose: () => {
			clearInterval(timerInterval)
		}
	});
	
	loadingAlert.fire();
}
function closeLoadingAlert() {
	loadingAlert.close();
	loadingAlert = null;
}

/************************************************** Driver cards **************************************************/
function generateDriverCardFromJs(id, firstname, lastname, country, teamId, teamColor, currentSeason, seasonCategory, number) {
	const helmetImageLayer = $('<div>').addClass('helmet-image-layer');
	const driverImageLayer = $('<div>').addClass('driver-image-layer');
	const overlay = $('<div>').addClass('overlay');
	const overlayName = $('<div>').addClass('overlay-name');
	
	if(number > 0) {
		const overlayNumber = $("<div>").addClass("number").text(number);
		$(overlay).append(overlayNumber);
	}
	const overlayAbbr = $("<div>").addClass("abbr").text(lastname.slice(0, 3).toUpperCase());
	const overlayCountry = $('<img>').attr('src', `${window.location.origin}/${contextPath}/img/countries/${country}.png`).addClass("flag").attr("data-value", country);
	$(overlay).append(overlayAbbr).append(overlayCountry);
	
	if(teamId > 0) {
		const helmetImageLayerImg = $('<img>').attr('src', `${window.location.origin}/${contextPath}/img/teams/backgrounds/${teamId}.png`);
		$(helmetImageLayer).append(helmetImageLayerImg);
		const driverImageLayerImg = $('<img>').attr('src', `${window.location.origin}/${contextPath}/img/drivers/${currentSeason}/${seasonCategory}/${teamId}/${id}.png`).attr("onerror", "loadDefaultDriverImage(this)");
		$(driverImageLayer).append(driverImageLayerImg);
		const overlayTeam = $('<img>').attr('src', `${window.location.origin}/${contextPath}/img/teams/${teamId}.png`).addClass("team");
		$(overlay).append(overlayTeam);
	} else {
		const driverImageLayerImg = $('<img>').attr('src', `${window.location.origin}/${contextPath}/img/drivers/default.png`);
		$(driverImageLayer).append(driverImageLayerImg);
	}
	
	const overlayNameFirstname = $('<div>').addClass('first-name').text(firstname);
	const overlayNameLastname = $('<div>').addClass('last-name').text(lastname);
	$(overlayName).append(overlayNameFirstname).append(overlayNameLastname);
	
	const driverCardBg = $('<div>').addClass('driver-card card-background')
		.append(helmetImageLayer)
		.append(driverImageLayer)
		.append(overlay)
		.append(overlayName);
	
	const driverCardInner = $('<div>').addClass('flip-card-inner').append(driverCardBg);
	
	const driverCardHTML = $('<div>').addClass('flip-card').css('--team-color', teamColor)
		.append(driverCardInner);
	
	return driverCardHTML;
}

/************************************************** Team cards **************************************************/
function generateTeamCardFromJs(id, name, color, country) {
	const bgImageLayerImg = $('<img>').attr('src', `${window.location.origin}/${contextPath}/img/teams/backgrounds/${id}.png`);
	const bgImageLayer = $('<div>').addClass('background-image-layer').append(bgImageLayerImg);
	
	const teamImageLayerImg = $('<img>').attr('src', `${window.location.origin}/${contextPath}/img/teams/${id}.png`);
	const teamImageLayer = $('<div>').addClass('team-image-layer').append(teamImageLayerImg);
	
	const overlayImg = $('<img>').attr('src', `${window.location.origin}/${contextPath}/img/countries/${country}.png`).addClass("flag").attr("data-value", country);
	const overlay = $('<div>').addClass('overlay').append(overlayImg);
	
	const overlayNameName = $('<div>').addClass('name').text(name);
	const overlayName = $('<div>').addClass('overlay-name').append(overlayNameName);
	
	const teamCardBg = $('<div>').addClass('team-card team-card-background')
		.append(bgImageLayer)
		.append(teamImageLayer)
		.append(overlay)
		.append(overlayName);
	
	const teamCardInner = $('<div>').addClass('team-card-inner').append(teamCardBg);
	
	const teamCardHTML = $('<div>').addClass('team-card-container').css('--team-color', color)
	  .append(teamCardInner);
	
	return teamCardHTML;
}

/************************************************** AJAX **************************************************/
function executeAjax(path, type, obj, okFunction, errorFunction, dataContent) {
	if(!inAjaxRequest) {
		inAjaxRequest = true;
		showLoadingAlert();
		
		if(dataContent == undefined) {
			dataContent = {};
		}
		
        $.ajax({
            url: window.location.origin+"/"+contextPath+"/"+path,
            type: type,
            dataType: 'json',
            data: dataContent,
            processData: false,
            contentType: false,
            timeout: 60000,
            success: function(data) {
                inAjaxRequest = false;
                closeLoadingAlert();
                window[okFunction].call(obj, data);
            },
            error: function(data, b, c) {
                inAjaxRequest = false;
                closeLoadingAlert();
                window[errorFunction].call(obj, data);
            }
        });
    }
}

function ajaxInternalServerError() {
	showResponseAlert("error", "Something goes wrong...", false, 1500, "center");
}