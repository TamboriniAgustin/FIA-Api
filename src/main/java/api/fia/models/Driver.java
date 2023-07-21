package api.fia.models;

import java.util.Date;

import lombok.Getter;
import lombok.Setter;

@Getter
@Setter
public class Driver {
	private int id;
	private String firstName;
	private String lastName;
	private String country;
	private Date birthday;
	private Constructor team;
	private int lastSeason;
	private int teamSeat;
	private int number;
	private int driverReplaced;
}