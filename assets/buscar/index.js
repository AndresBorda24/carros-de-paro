import Alpine from "alpinejs";

import changes from "./components/comparacion"
import formulario from "./components/formulario";
import showResults from "./components/show-results";
import "../css/general.css";

window.Alpine = Alpine;

document.addEventListener("alpine:init", function() {
    Alpine.data("changes", changes);
    Alpine.data("formulario", formulario);
    Alpine.data("showResults", showResults);
});

document.addEventListener("DOMContentLoaded", function() {
    Alpine.start();
});
