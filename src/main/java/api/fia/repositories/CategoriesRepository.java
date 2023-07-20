package api.fia.repositories;

import java.util.List;

import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.jdbc.core.JdbcTemplate;
import org.springframework.stereotype.Repository;

import api.fia.mappers.CategoryMapper;
import api.fia.models.Category;

@Repository
public class CategoriesRepository {
	@Autowired
	private JdbcTemplate jdbcTemplate;

	private static final String SELECT_CATEGORIES = "SELECT category_id, category_name, category_abbr, category_color_text, category_color_background, "
			+ "category_color_hover FROM categories ";
	
	public List<Category> getCountries() {
		return jdbcTemplate.query(SELECT_CATEGORIES, new CategoryMapper());
	}
}