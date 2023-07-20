package api.fia.models;

import java.util.Map;

import lombok.Getter;
import lombok.Setter;

@Getter
@Setter
public class Category {
	private int id;
	private String name;
	private String abbr;
	private String principalColor;
	private String secondaryColor;
	private String textColor;
	private Map<Integer, Season> seasons;
}