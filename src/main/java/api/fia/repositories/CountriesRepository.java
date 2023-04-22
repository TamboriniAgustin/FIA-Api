package api.fia.repositories;

import java.util.List;

import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.jdbc.core.JdbcTemplate;
import org.springframework.stereotype.Repository;

import api.fia.mappers.CountryMapper;
import api.fia.models.Country;

@Repository
public class CountriesRepository {
	@Autowired
    private JdbcTemplate jdbcTemplate;
	
	private static final String SELECT_COUNTRIES = "SELECT country_id, country_code, country_name, continent_code, continent_name "
			+ "FROM countries JOIN continents ON continent_code = country_continent_code ORDER BY country_name";
	
	public List<Country> getCountries() {
		return jdbcTemplate.query(SELECT_COUNTRIES, new CountryMapper());
	}
}
