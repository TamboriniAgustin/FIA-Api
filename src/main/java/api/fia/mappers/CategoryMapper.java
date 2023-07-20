package api.fia.mappers;

import java.sql.ResultSet;
import java.sql.SQLException;

import org.springframework.jdbc.core.RowMapper;

import api.fia.models.Category;

public class CategoryMapper implements RowMapper<Category> {
	@Override
	public Category mapRow(ResultSet rs, int rowNum) throws SQLException {
		Category category = new Category();
		
		category.setId(rs.getInt("category_id"));
		category.setName(rs.getString("category_name"));
		category.setAbbr(rs.getString("category_abbr"));
		category.setPrincipalColor(rs.getString("category_color_background"));
		category.setSecondaryColor(rs.getString("category_color_hover"));
		category.setTextColor(rs.getString("category_color_text"));
		
		return category;
	}
}