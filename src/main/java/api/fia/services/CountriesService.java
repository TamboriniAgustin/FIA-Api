package api.fia.services;

import java.util.List;

import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.stereotype.Service;

import api.fia.models.Country;
import api.fia.repositories.CountriesRepository;

@Service
public class CountriesService {
	@Autowired
	private CountriesRepository repository;
	
	public List<Country> getListOfCountries() {
		return repository.getCountries();
	}
}
