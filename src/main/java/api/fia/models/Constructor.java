package api.fia.models;

import java.util.Map;

import lombok.Getter;
import lombok.Setter;

@Getter
@Setter
public class Constructor {
	private int id;
	private String name;
	private String country;
	private String principalColor;
	private String secondaryColor;
	private Map<Integer, Driver> drivers;
}