package api.fia.services;

import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.stereotype.Service;

import api.fia.repositories.CountriesRepository;

@Service
public class CountriesService {
	@Autowired
	private CountriesRepository repository;
}
