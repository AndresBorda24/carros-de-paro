import Alpine from "alpinejs";
import carro from "./components/carro";
import carrosList from "./components/carros-list";
import createCarro from "./components/create-carro";

import createMedicamento from "./components/create-medicamento";
import grillaMedicamentos from "./partials/grilla-medicamentos";
import deleteMedicamento from "./partials/delete-medicamento";

import createDispositivo from "./components/create-dispositivo";
import grillaDispositivos from "./partials/grilla-dispositivos";
import deleteDispositivo from "./partials/delete-dispositivo";

import "../css/carro.css";

window.Alpine = Alpine;

document.addEventListener("alpine:init", function() {
    Alpine.data("carro", carro);
    Alpine.data("carrosList", carrosList);
    Alpine.data("createCarro", createCarro);

    Alpine.data("createMedicamento", createMedicamento);
    Alpine.data("deleteMedicamento", deleteMedicamento);
    Alpine.data("grillaMedicamentos", grillaMedicamentos);

    Alpine.data("createDispositivo", createDispositivo);
    Alpine.data("deleteDispositivo", deleteDispositivo);
    Alpine.data("grillaDispositivos", grillaDispositivos);
});

document.addEventListener("DOMContentLoaded", function() {
    Alpine.start();
});
