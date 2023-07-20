package api.fia.utils;

import java.util.Map;

import javax.servlet.http.HttpSession;

import api.fia.models.Category;

@SuppressWarnings("unchecked")
public class SessionUtils {
	public static Category getCategory(HttpSession session, String categoryAbbr) {
		Category category = ((Map<String, Category>) session.getAttribute("categories")).get(categoryAbbr);
		if(category == null) {
			throw new RuntimeException("La categoría ingresada no existe");
		}
		return category;
	}
}