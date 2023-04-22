package api.fia.mappers;

import java.sql.ResultSet;
import java.sql.SQLException;

import org.springframework.jdbc.core.RowMapper;

import api.fia.models.Continent;
import api.fia.models.Country;

public class CountryMapper implements RowMapper<Country> {
	@Override
	public Country mapRow(ResultSet rs, int rowNum) throws SQLException {
		Continent continent = new Continent();
		continent.setCode(rs.getString("continent_code"));
		continent.setName(rs.getString("continent_name"));
		
		Country model = new Country();
		model.setId(rs.getInt("country_id"));
		model.setCode(rs.getString("country_code"));
		model.setName(rs.getString("country_name"));
		model.setContinent(continent);
		
		return model;
	}
}