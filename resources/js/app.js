import "./bootstrap";
import "remixicon/fonts/remixicon.css";
import flatpickr from "flatpickr";

import Alpine from "alpinejs";

window.Alpine = Alpine;

Alpine.start();
flatpickr(".birthdate");
