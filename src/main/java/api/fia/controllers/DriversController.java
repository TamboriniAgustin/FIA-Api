package api.fia.controllers;

import org.springframework.stereotype.Controller;
import org.springframework.ui.Model;
import org.springframework.web.bind.annotation.GetMapping;
import org.springframework.web.bind.annotation.RequestMapping;

@Controller
@RequestMapping("/drivers")
public class DriversController {
	@GetMapping("/driver")
	public String getDriverInfo(Model model) {
		return "driver-info";
	}
}
