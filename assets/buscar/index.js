import Alpine from "alpinejs";

import formulario from "./components/formulario";
import showResults from "./components/show-results";
import historicoChanges from "../carro/historico/comparacion";

import "../css/general.css";

window.Alpine = Alpine;

document.addEventListener("alpine:init", function() {
    Alpine.data("formulario", formulario);
    Alpine.data("showResults", showResults);
    Alpine.data("historicoChanges", historicoChanges);
});

document.addEventListener("DOMContentLoaded", function() {
    Alpine.start();
});
