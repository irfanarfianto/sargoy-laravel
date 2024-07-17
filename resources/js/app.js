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

document.addEventListener("DOMContentLoaded", function () {
    document
        .querySelectorAll('button[type="submit"]')
        .forEach(function (button) {
            button.addEventListener("click", function () {
                const originalText =
                    button.querySelector(".btn-text").textContent;
                const loadingText = button.dataset.loadingText || "Loading...";

                button.classList.add("loading");
                button.querySelector(".loading-spinner").style.display =
                    "inline-block";
                button.querySelector(".btn-text").textContent = loadingText;

                // Simulate a network request or form submission
                setTimeout(function () {
                    button.classList.remove("loading");
                    button.querySelector(".loading-spinner").style.display =
                        "none";
                    button.querySelector(".btn-text").textContent =
                        originalText;
                    alert("Action completed!");
                }, 2000); 
            });
        });
});
