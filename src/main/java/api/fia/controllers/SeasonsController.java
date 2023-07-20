package api.fia.controllers;

import java.util.Map;

import javax.servlet.http.HttpSession;

import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.stereotype.Controller;
import org.springframework.ui.Model;
import org.springframework.web.bind.annotation.GetMapping;
import org.springframework.web.bind.annotation.PathVariable;
import org.springframework.web.bind.annotation.PostMapping;
import org.springframework.web.bind.annotation.RequestMapping;
import org.springframework.web.bind.annotation.RequestParam;
import org.springframework.web.bind.annotation.ResponseBody;

import api.fia.models.Category;
import api.fia.models.Constructor;
import api.fia.models.Season;
import api.fia.services.SeasonsService;
import api.fia.utils.SessionUtils;

@Controller
@RequestMapping("/season")
@SuppressWarnings("unchecked")
public class SeasonsController {
	@Autowired
	private SeasonsService seasonsService;
	
	@GetMapping("/{season}/{category}")
	public String getSeasonDetails(Model model, HttpSession session, @PathVariable int season, @PathVariable String category) {
		//Get the category object
		Category selectedCategory = SessionUtils.getCategory(session, category);
		if(selectedCategory.getSeasons() == null) {
			throw new RuntimeException("La categoría no cuenta con temporadas cargadas");
		}
		
		//Get the season object
		Season selectedSeason = selectedCategory.getSeasons().get(season);
		if(selectedSeason == null) {
			throw new RuntimeException("La temporada ingresada no fue registrada");
		}
		
		//Get the teams of the season
		Map<Integer, Constructor> otherConstructors = (Map<Integer, Constructor>) session.getAttribute("constructors");
		if(selectedSeason.getConstructors() == null) {
			Map<Integer, Constructor> constructors = seasonsService.getSeasonConstructors(season, selectedCategory.getId(), otherConstructors);
			selectedSeason.setConstructors(constructors);
		}
		
		//Add the screen attributes
		model.addAttribute("category", selectedCategory);
		model.addAttribute("countries", session.getAttribute("countries"));
		model.addAttribute("season", selectedSeason);
		model.addAttribute("constructors", otherConstructors);
		((Map<String, Category>) session.getAttribute("categories")).put(selectedCategory.getAbbr(), selectedCategory);
		
		return "season-details";
	}
	
	@PostMapping("/{season}/{category}/add/team/{teamId}")
	public @ResponseBody String addTeam(Model model, HttpSession session, @PathVariable int season, @PathVariable String category,
			@PathVariable int teamId, @RequestParam("principalColor") String principalColor,
			@RequestParam("secondaryColor") String secondaryColor) {
		//Get the category object
		Category selectedCategory = SessionUtils.getCategory(session, category);
		if(selectedCategory.getSeasons() == null) {
			throw new RuntimeException("La categoría no cuenta con temporadas cargadas");
		}
		
		//Add the team
		Map<Integer, Constructor> constructors = (Map<Integer, Constructor>) session.getAttribute("constructors");
		Constructor constructor = seasonsService.addTeamStep1(season, selectedCategory.getId(), teamId, principalColor, secondaryColor, constructors.get(teamId));
		constructors.remove(constructor.getId());
		
		//Update the session objects
		Season selectedSeason = selectedCategory.getSeasons().get(season);
		if(selectedSeason == null) {
			throw new RuntimeException("La temporada ingresada no fue registrada");
		}
		selectedSeason.getConstructors().put(teamId, constructor);
		Map<Integer, Constructor> orderedConstructors = seasonsService.addTeamStep2(selectedSeason.getConstructors());
		selectedSeason.setConstructors(orderedConstructors);
		
		((Map<String, Category>) session.getAttribute("categories")).put(selectedCategory.getAbbr(), selectedCategory);
		return "{}";
	}
}