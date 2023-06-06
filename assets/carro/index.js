import Alpine from "alpinejs";
import carrosList from "./components/carros-list";
import createCarro from "./components/create-carro";
import "../css/general.css";

window.Alpine = Alpine;

document.addEventListener("alpine:init", function() {
    Alpine.data("carrosList", carrosList);
    Alpine.data("createCarro", createCarro);
});

document.addEventListener("DOMContentLoaded", function() {
    Alpine.start();
});
