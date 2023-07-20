package api.fia.mappers;

import java.sql.ResultSet;
import java.sql.SQLException;

import org.springframework.jdbc.core.RowMapper;

import api.fia.models.Constructor;

public class SeasonConstructorsMapper implements RowMapper<Constructor> {
	@Override
	public Constructor mapRow(ResultSet rs, int rowNum) throws SQLException {
		Constructor constructor = new Constructor();
		
		constructor.setId(rs.getInt("season_constructor"));
		constructor.setName(rs.getString("constructor_name"));
		constructor.setPrincipalColor(rs.getString("season_constructor_principal_color"));
		constructor.setSecondaryColor(rs.getString("season_constructor_secondary_color"));
		
		return constructor;
	}
}