package api.fia.controllers;

import java.util.LinkedHashMap;
import java.util.List;
import java.util.Map;
import java.util.stream.Collectors;

import javax.servlet.http.HttpSession;

import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.stereotype.Controller;
import org.springframework.ui.Model;
import org.springframework.web.bind.annotation.GetMapping;

import api.fia.models.Category;
import api.fia.models.Constructor;
import api.fia.models.Country;
import api.fia.models.Driver;
import api.fia.models.Season;
import api.fia.repositories.ConstructorsRepository;
import api.fia.repositories.DriversRepository;
import api.fia.services.CategoriesService;
import api.fia.services.CountriesService;
import api.fia.services.SeasonsService;

@Controller
public class MainController {
	@Autowired
	private CategoriesService categoriesService;
	@Autowired
	private ConstructorsRepository constructorsRepository;
	@Autowired
	private CountriesService countriesService;
	@Autowired
	private DriversRepository driversRepository;
	@Autowired
	private SeasonsService seasonsService;
	
	@GetMapping("/")
	public String loadIndex(Model model, HttpSession session) {
		List<Country> countries = countriesService.getListOfCountries();
		
		//Get all the drivers
		Map<Integer, Driver> driversMap = new LinkedHashMap<>();
		driversRepository.getDrivers().forEach(driver -> {
			driversMap.put(driver.getId(), driver);
		});
		
		//Get all the constructors
		Map<Integer, Constructor> constructorsMap = new LinkedHashMap<>();
		constructorsRepository.getConstructors().forEach(constructor -> {
			constructorsMap.put(constructor.getId(), constructor);
		});
		
		//Get the categories
		List<Category> categories = categoriesService.getCategories();
		categories.stream().parallel().forEach(category -> {
			List<Season> seasons = seasonsService.getSeasons(category.getId());
			category.setSeasons(seasons.stream().collect(Collectors.toMap(Season::getYear, season -> season)));
		});
		
		model.addAttribute("countries", countries);
		model.addAttribute("categories", categories);
		session.setAttribute("countries", countries);
		session.setAttribute("categories", categories.stream().collect(Collectors.toMap(Category::getAbbr, category -> category)));
		session.setAttribute("constructors", constructorsMap);
		session.setAttribute("drivers", driversMap);
		
		return "index";
	}
}