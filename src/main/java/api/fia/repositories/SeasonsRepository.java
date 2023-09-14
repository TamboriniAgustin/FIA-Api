package api.fia.repositories;

import java.util.List;

import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.jdbc.core.JdbcTemplate;
import org.springframework.stereotype.Repository;

import api.fia.mappers.SeasonConstructorsMapper;
import api.fia.mappers.SeasonDriversMapper;
import api.fia.mappers.SeasonMapper;
import api.fia.models.Constructor;
import api.fia.models.Driver;
import api.fia.models.Season;

@Repository
public class SeasonsRepository {
	@Autowired
	private JdbcTemplate jdbcTemplate;
	
	private static final String ADD_DRIVER = "INSERT INTO transfer_market(transfer_season, driver_id, driver_number, constructor_id, "
			+ "constructor_seat) VALUES (?, ?, ?, ?, ?)";
	private static final String ADD_TEAM = "INSERT INTO season_constructors(season_year, season_category, season_constructor, "
			+ "season_constructor_principal_color, season_constructor_secondary_color) VALUES (?, ?, ?, ?, ?)";
	private static final String SELECT_SEASONS = "SELECT DISTINCT season_year FROM season_constructors WHERE season_category = ?";
	private static final String SELECT_CONSTRUCTORS = "SELECT season_year, season_category, season_constructor, constructor_name, "
			+ "season_constructor_principal_color, season_constructor_secondary_color FROM season_constructors JOIN "
			+ "constructors ON season_constructor = constructor_id WHERE season_year = ? AND season_category = ? ORDER BY "
			+ "constructor_name ASC";
	private static final String SELECT_DRIVERS_FROM_CONSTRUCTOR = "SELECT tm.transfer_id, tm.transfer_season, tm.driver_id, tm.driver_number, "
			+ "tm.driver_replace, tm.constructor_id, tm.constructor_seat, d.driver_name, d.driver_lastname, d.driver_birthday, "
			+ "cn.country_code AS driver_country FROM transfer_market tm "
			+ "JOIN drivers d ON tm.driver_id = d.driver_id "
			+ "JOIN countries cn ON d.driver_country = cn.country_id "
			+ "WHERE tm.transfer_season = ? AND tm.constructor_id = ? "
			+ "ORDER BY tm.constructor_seat ASC";
	private static final String UPDATE_DRIVER_REPLACED_STATUS = "UPDATE transfer_market SET driver_replace = ? WHERE transfer_season = ? "
			+ " AND driver_id = ?";
	
	public List<Season> getSeasons(int categoryId) {
		return  jdbcTemplate.query(SELECT_SEASONS, new SeasonMapper(), categoryId);
	}
	
	public List<Constructor> getSeasonConstructors(int season, int categoryId) {
		return jdbcTemplate.query(SELECT_CONSTRUCTORS, new SeasonConstructorsMapper(), season, categoryId);
	}
	
	public List<Driver> getConstructorDriversPerSeason(int season, int constructorId) {
		return jdbcTemplate.query(SELECT_DRIVERS_FROM_CONSTRUCTOR, new SeasonDriversMapper(), season, constructorId);
	}
	
	public void addTeam(int season, int categoryId, int team, String principalColor, String secondaryColor) {
		jdbcTemplate.update(ADD_TEAM, season, categoryId, team, principalColor, secondaryColor);
	}
	
	public void addDriver(int season, int driver, int number, int driverReplaced, int team, int seat) {
		jdbcTemplate.update(ADD_DRIVER, season, driver, number, team, seat);
		if(driverReplaced > 0) {
			jdbcTemplate.update(UPDATE_DRIVER_REPLACED_STATUS, 1, season, driverReplaced);
		}
	}
}