import Alpine from "alpinejs";
import "../css/general.css";

window.Alpine = Alpine;

document.addEventListener("alpine:init", function() {
});

document.addEventListener("DOMContentLoaded", function() {
    Alpine.start();
});
