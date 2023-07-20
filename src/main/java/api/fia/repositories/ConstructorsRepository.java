package api.fia.repositories;

import java.util.List;

import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.jdbc.core.JdbcTemplate;
import org.springframework.stereotype.Repository;

import api.fia.mappers.ConstructorMapper;
import api.fia.models.Constructor;

@Repository
public class ConstructorsRepository {
	@Autowired
	private JdbcTemplate jdbcTemplate;
	
	private static final String SELECT_CONSTRUCTORS = "SELECT constructor_id, constructor_name, country_code AS constructor_country, "
			+ "	COALESCE(constructor_principal_color, '#131212') AS constructor_principal_color, "
			+ "	COALESCE(constructor_secondary_color, '#ffffff') AS constructor_secondary_color  "
			+ "FROM constructors "
			+ "JOIN countries ON country_id = constructor_country "
			+ "ORDER BY constructor_name";
	
	public List<Constructor> getConstructors() {
		return jdbcTemplate.query(SELECT_CONSTRUCTORS, new ConstructorMapper());
	}
}