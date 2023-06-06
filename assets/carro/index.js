import Alpine from "alpinejs";
import carrosList from "./components/carros-list";
import createCarro from "./components/create-carro";
import grillaMedicamentos from "./components/grilla-medicamentos";
import "../css/carro.css";

window.Alpine = Alpine;

document.addEventListener("alpine:init", function() {
    Alpine.data("carrosList", carrosList);
    Alpine.data("createCarro", createCarro);
    Alpine.data("grillaMedicamentos", grillaMedicamentos);
});

document.addEventListener("DOMContentLoaded", function() {
    Alpine.start();
});
