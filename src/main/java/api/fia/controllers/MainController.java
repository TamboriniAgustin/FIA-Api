package api.fia.controllers;

import java.util.List;

import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.stereotype.Controller;
import org.springframework.ui.Model;
import org.springframework.web.bind.annotation.GetMapping;
import org.springframework.web.bind.annotation.SessionAttributes;

import api.fia.models.Country;
import api.fia.services.CountriesService;

@Controller
@SessionAttributes("countries")
public class MainController {
	@Autowired
	private CountriesService countriesService;
	
	@GetMapping("/")
	public String loadIndex(Model model) {
		List<Country> countries = countriesService.getListOfCountries();
		
		model.addAttribute("countries", countries);
		
		return "index";
	}
}