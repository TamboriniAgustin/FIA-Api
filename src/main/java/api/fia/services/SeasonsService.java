package api.fia.services;

import java.util.Comparator;
import java.util.HashMap;
import java.util.LinkedHashMap;
import java.util.List;
import java.util.Map;

import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.stereotype.Service;

import api.fia.models.Constructor;
import api.fia.models.Driver;
import api.fia.models.Season;
import api.fia.repositories.SeasonsRepository;

@Service
public class SeasonsService {
	@Autowired
	private SeasonsRepository repository;
	
	public List<Season> getSeasons(int categoryId) {
		return repository.getSeasons(categoryId);
	}
	
	public Map<Integer, Constructor> getSeasonConstructors(int season, int categoryId, Map<Integer, Constructor> otherConstructors) {
		Map<Integer, Constructor> constructorsMap = new LinkedHashMap<>();
		
		List<Constructor> constructors = repository.getSeasonConstructors(season, categoryId);
		constructors.forEach(constructor -> {
			Map<Integer, Driver> driversMap = new LinkedHashMap<>();
			List<Driver> drivers = repository.getConstructorDriversPerSeason(season, constructor.getId());
			drivers.forEach(driver -> {
				driversMap.put(driver.getId(), driver);
			});
			constructor.setDrivers(driversMap);
			constructorsMap.put(constructor.getId(), constructor);
			otherConstructors.remove(constructor.getId());
		});
		
		return constructorsMap;
	}
	
	public Constructor addTeamStep1(int season, int categoryId, int team, String principalColor, String secondaryColor, Constructor constructorObject) {
		repository.addTeam(season, categoryId, team, principalColor, secondaryColor);
		
		Constructor constructor = new Constructor();
		constructor.setId(team);
		constructor.setName(constructorObject.getName());
		constructor.setPrincipalColor(principalColor);
		constructor.setSecondaryColor(secondaryColor);
		constructor.setDrivers(new HashMap<>());
		
		return constructor;
	}
	
	public Map<Integer, Constructor> addTeamStep2(Map<Integer, Constructor> constructorsMap) {
		return constructorsMap.values().stream()
                .sorted(Comparator.comparing(Constructor::getName))
                .collect(LinkedHashMap::new, (map, constructor) -> map.put(constructor.getId(), constructor), Map::putAll);
	}
}