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
	
	@Override
	public int hashCode() {
		final int prime = 31;
		int result = 1;
		result = prime * result + ((code == null) ? 0 : code.hashCode());
		result = prime * result + ((continent == null) ? 0 : continent.hashCode());
		result = prime * result + id;
		result = prime * result + ((name == null) ? 0 : name.hashCode());
		return result;
	}
	
	@Override
	public boolean equals(Object obj) {
		if (this == obj)
			return true;
		if (obj == null)
			return false;
		if (getClass() != obj.getClass())
			return false;
		Country other = (Country) obj;
		if (code == null) {
			if (other.code != null)
				return false;
		} else if (!code.equals(other.code))
			return false;
		if (continent == null) {
			if (other.continent != null)
				return false;
		} else if (!continent.equals(other.continent))
			return false;
		if (id != other.id)
			return false;
		if (name == null) {
			if (other.name != null)
				return false;
		} else if (!name.equals(other.name))
			return false;
		return true;
	}
	
	@Override
	public String toString() {
		return "Country [id=" + id + ", code=" + code + ", name=" + name + ", continent=" + continent + "]";
	}
}
