package api.fia.mappers;

import java.sql.ResultSet;
import java.sql.SQLException;

import org.springframework.jdbc.core.RowMapper;

import api.fia.models.Driver;

public class SeasonDriversMapper implements RowMapper<Driver> {
	@Override
	public Driver mapRow(ResultSet rs, int rowNum) throws SQLException {
		Driver driver = new Driver();
		
		driver.setId(rs.getInt("driver_id"));
		driver.setFirstName(rs.getString("driver_name"));
		driver.setLastName(rs.getString("driver_lastname"));
		driver.setCountry(rs.getString("driver_country"));
		driver.setTeamSeat(rs.getInt("constructor_seat"));
		driver.setNumber(rs.getInt("driver_number"));
		driver.setDriverReplaced(rs.getInt("driver_replace"));
		
		return driver;
	}
}