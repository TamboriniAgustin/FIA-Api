package api.fia.mappers;

import java.sql.ResultSet;
import java.sql.SQLException;

import org.springframework.jdbc.core.RowMapper;

import api.fia.models.Constructor;

public class ConstructorMapper implements RowMapper<Constructor> {
	@Override
	public Constructor mapRow(ResultSet rs, int rowNum) throws SQLException {
		Constructor constructor = new Constructor();
		
		constructor.setId(rs.getInt("constructor_id"));
		constructor.setName(rs.getString("constructor_name"));
		constructor.setCountry(rs.getString("constructor_country"));
		constructor.setPrincipalColor(rs.getString("constructor_principal_color"));
		constructor.setSecondaryColor(rs.getString("constructor_secondary_color"));
		
		return constructor;
	}
}