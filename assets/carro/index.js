import Alpine from "alpinejs";
import carro from "./components/carro";
import carrosList from "./components/carros-list";
import createCarro from "./components/create-carro";
import grillaMedicamentos from "./partials/grilla-medicamentos";
import "../css/carro.css";

window.Alpine = Alpine;

document.addEventListener("alpine:init", function() {
    Alpine.data("carro", carro);
    Alpine.data("carrosList", carrosList);
    Alpine.data("createCarro", createCarro);
    Alpine.data("grillaMedicamentos", grillaMedicamentos);
});

document.addEventListener("DOMContentLoaded", function() {
    Alpine.start();
});
