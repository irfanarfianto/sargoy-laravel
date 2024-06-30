import "./bootstrap";
import "remixicon/fonts/remixicon.css";
import flatpickr from "flatpickr";

import Alpine from "alpinejs";

window.Alpine = Alpine;

Alpine.start();
flatpickr(".birthdate");

window.Echo.channel("system-announcements").listen(
    "SystemAnnouncement",
    (e) => {
        alert("Announcement: " + e.announcement);
    }
);

window.Echo.channel("system-alerts").listen("SystemAlert", (e) => {
    alert("Alert: " + e.alert);
});
