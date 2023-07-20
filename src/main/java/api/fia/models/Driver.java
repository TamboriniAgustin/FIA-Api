package api.fia.models;

import lombok.Getter;
import lombok.Setter;

@Getter
@Setter
public class Driver {
	private int id;
	private String firstName;
	private String lastName;
	private String country;
	private int teamSeat;
	private int number;
	private int driverReplaced;
}