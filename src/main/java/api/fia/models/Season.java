package api.fia.models;

import java.util.Map;

import lombok.Getter;
import lombok.Setter;

@Getter
@Setter
public class Season {
	private int year;
	private Map<Integer, Constructor> constructors;
}