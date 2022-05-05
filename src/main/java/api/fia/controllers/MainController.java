package api.fia.controllers;

import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.stereotype.Controller;
import org.springframework.ui.Model;
import org.springframework.web.bind.annotation.GetMapping;
import org.springframework.web.bind.annotation.SessionAttributes;

import api.fia.services.CountriesService;

@Controller
@SessionAttributes("countries")
public class MainController {
	@Autowired
	private CountriesService countriesService;
	
	@GetMapping("/")
	public String loadIndex(Model model) {

		return "index";
	}
}