import Alpine from "alpinejs";

import show from "./components/show";
import formulario from "./components/formulario";
import selectResults from "./components/select-results";

import "../css/general.css";

window.Alpine = Alpine;

document.addEventListener("alpine:init", function() {
    Alpine.data("show", show);
    Alpine.data("formulario", formulario);
    Alpine.data("selectResults", selectResults);
});

document.addEventListener("DOMContentLoaded", function() {
    Alpine.start();
});
