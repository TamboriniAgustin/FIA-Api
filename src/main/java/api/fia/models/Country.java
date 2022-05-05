package api.fia.models;

import lombok.Getter;
import lombok.Setter;

@Getter
@Setter
public class Country {
	private int id;
	private String code;
	private String name;
	private Continent continent;
}
