package api.fia.mappers;

import java.sql.ResultSet;
import java.sql.SQLException;

import org.springframework.jdbc.core.RowMapper;

import api.fia.models.Season;

public class SeasonMapper implements RowMapper<Season> {
	@Override
	public Season mapRow(ResultSet rs, int rowNum) throws SQLException {
		Season season = new Season();
		
		season.setYear(rs.getInt("season_year"));
		
		return season;
	}
}