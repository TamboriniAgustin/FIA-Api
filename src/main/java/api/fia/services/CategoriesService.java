package api.fia.services;

import java.util.List;

import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.stereotype.Service;

import api.fia.models.Category;
import api.fia.repositories.CategoriesRepository;

@Service
public class CategoriesService {
	@Autowired
	private CategoriesRepository categoriesRepository;
	
	public List<Category> getCategories() {
		return categoriesRepository.getCountries();
	}
}
