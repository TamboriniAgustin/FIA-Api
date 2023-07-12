/************************************************** Global Variables **************************************************/
//Countries select
var menuShowed = false;
//Countries menu
const initial_countries_shown = 12; //Countries shown per page (pagination)
var activeCountries = initial_countries_shown; //Countries page showed (pagination)
var actualFilteredCountries = null; //List of countries filtered at this moment (filters)
var actualFilteredContinent = null; //Continent filtered at this moment (filters)
var actualFilteredLetter = null; //Letter filtered at this moment (filters)

$(document).ready(function () {
    /****************************** Tooltips ******************************/
    $("#countries-menu .country-data img").tooltip({placement: "bottom"});
    
    /****************************** Countries Select ******************************/
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
        $(this).parent().parent().parent().parent().parent().find("#countries-select").css("background-image", `url(../img/countries/${selectedCountry}.png`);

        //Hide the menu
        $(this).parent().parent().parent().parent().hide();
        menuShowed = false;
    });

    /****************************** Countries Menu ******************************/
    //Load the initial countries when the DOM is ready
    getActiveCountries(0, initial_countries_shown).show();

    //Pagination
    $("#countries-menu .back-arrow").on("click", function () {
        if(!$(this).hasClass("disabled")) {
            //Get information about countries showed and update of the variable with the new countries that gonna be shown
            const actualMaxIndex = activeCountries;
            const actualMinIndex = activeCountries - initial_countries_shown;
            activeCountries -= initial_countries_shown;

            //Hide countries showed and show the new countries
            getActiveCountries(actualMinIndex, actualMaxIndex, actualFilteredCountries != null).hide();
            getActiveCountries(activeCountries - initial_countries_shown, activeCountries, actualFilteredCountries != null).show();
            
            //Check if are countries in the prev page and block the button if not
            $("#countries-menu .next-arrow").removeClass("disabled");
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
            getActiveCountries(actualMinIndex, actualMaxIndex, actualFilteredCountries != null).hide();
            var countriesToActivate = getActiveCountries(actualMaxIndex, activeCountries, actualFilteredCountries != null);
            countriesToActivate.show();

            //Check if are countries in the next page and block the button if not
            $("#countries-menu .back-arrow").removeClass("disabled");
            if(isTheLastPage(countriesToActivate)){
                $(this).addClass("disabled");
            }
        }
    });

    //Filters
    $("#countries-menu .continent-filter .continent").on("click", function () {
        //Hover the current selection
        $("#countries-menu .continent[active=true]").removeAttr("active");
        $(this).attr("active", true);

        //Hide current countries showed
        const actualMaxIndex = activeCountries;
        const actualMinIndex = activeCountries - initial_countries_shown;
        getActiveCountries(actualMinIndex, actualMaxIndex, actualFilteredCountries != null).hide();
        
        //Reset the activeCountries to initial value
        activeCountries = initial_countries_shown;
        
        //Obtain the countries of the selected continent
        actualFilteredContinent = $(this).html();
        actualFilteredCountries = $(`#countries-menu .country-data[continent='${actualFilteredContinent}']`);

        //If exists a filter by letter just choose the countries that starts with that letter
        if(actualFilteredLetter != null) {
            actualFilteredCountries = $(actualFilteredCountries).filter(function() {
                return $(this).attr("name") == actualFilteredLetter;
            })
        }
        
        //Config the filterIndex for every country selected
        configFilterIndex(actualFilteredCountries);

        //Show the selected countries
        const countriesToActivate = getActiveCountries(0, initial_countries_shown, true).show();

        //Block the go-back arrow and check if the next arrow is enabled
        $("#countries-menu .back-arrow").addClass("disabled");
        if(isTheLastPage(countriesToActivate)){
            $("#countries-menu .next-arrow").addClass("disabled");
        } else {
            $("#countries-menu .next-arrow").removeClass("disabled");
        }
    });

    $("#countries-menu .letter-filter .letter").on("click", function () {
        //Hover the current selection
        $("#countries-menu .letter[active=true]").removeAttr("active");
        $(this).attr("active", true);

        //Hide current countries showed
        const actualMaxIndex = activeCountries;
        const actualMinIndex = activeCountries - initial_countries_shown;
        getActiveCountries(actualMinIndex, actualMaxIndex, actualFilteredCountries != null).hide();

        //Reset the activeCountries to initial value
        activeCountries = initial_countries_shown;

        //Obtain the countries that starts with the selected letter
        actualFilteredLetter = $(this).html();
        actualFilteredCountries = $(`#countries-menu .country-data[name='${actualFilteredLetter}']`);

        if(actualFilteredContinent != null) {
            actualFilteredCountries = $(actualFilteredCountries).filter(function() {
                return $(this).attr("continent") == actualFilteredContinent;
            })
        }

        //Config the filterIndex for every country selected
        configFilterIndex(actualFilteredCountries);

        //Show the selected countries
        const countriesToActivate = getActiveCountries(0, initial_countries_shown, true).show();

        //Block the go-back arrow and check if the next arrow is enabled
        $("#countries-menu .back-arrow").addClass("disabled");
        if(isTheLastPage(countriesToActivate)){
            $("#countries-menu .next-arrow").addClass("disabled");
        } else {
            $("#countries-menu .next-arrow").removeClass("disabled");
        }
    });
});

/************************************************** Functions **************************************************/
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

function getActiveCountries(minIndex = 0, maxIndex = initial_countries_shown, isFiltered = false) {
    //Filters
    if(isFiltered) {
        return $(actualFilteredCountries).filter(function(){
            return ($(this).attr('filterIndex') > minIndex) && ($(this).attr('filterIndex') <= maxIndex);
        });
    }

    //Default
    return $("#countries-menu .country-data").filter(function(){
        return ($(this).attr('index') > minIndex) && ($(this).attr('index') <= maxIndex);
    });
}