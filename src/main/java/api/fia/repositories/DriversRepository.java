package api.fia.repositories;

import java.util.List;

import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.jdbc.core.JdbcTemplate;
import org.springframework.stereotype.Repository;

import api.fia.mappers.DriverMapper;
import api.fia.models.Driver;

@Repository
public class DriversRepository {
	@Autowired
	private JdbcTemplate jdbcTemplate;
	
	private static final String SELECT_DRIVERS = "SELECT d.driver_id, d.driver_name, d.driver_lastname, c.country_code AS driver_country, "
			+ "d.driver_birthday, MAX(tm.transfer_season) AS driver_last_season FROM drivers d "
			+ "	JOIN countries c ON c.country_id = d.driver_country "
			+ "	LEFT JOIN transfer_market tm ON tm.driver_id = d.driver_id "
			+ "GROUP BY d.driver_id "
			+ "ORDER BY d.driver_lastname, d.driver_name";
	
	public List<Driver> getDrivers() {
		return jdbcTemplate.query(SELECT_DRIVERS, new DriverMapper());
	}
}