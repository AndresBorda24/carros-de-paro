import Alpine from "alpinejs";
import carro from "./components/carro";
import carrosList from "./components/carros-list";
import deleteCarro from "./partials/delete-carro";
import createCarro from "./components/create-carro";

import * as Medicamento from "./medicamentos/index";

import createDispositivo from "./components/create-dispositivo";
import grillaDispositivos from "./partials/grilla-dispositivos";
import deleteDispositivo from "./partials/delete-dispositivo";
import guardarCarroDispositivos from "./partials/guardar-carro-dispositivos";

import historico from "./components/historico";
import resaltarVencimiento from "./partials/resaltar-vencimiento";

import "../css/carro.css";

window.Alpine = Alpine;

document.addEventListener("alpine:init", function() {
    Alpine.data("carro", carro);
    Alpine.data("carrosList", carrosList);
    Alpine.data("createCarro", createCarro);

    Alpine.data("createMedicamento", Medicamento.manage);
    Alpine.data("deleteMedicamento", Medicamento.remove);
    Alpine.data("grillaMedicamentos", Medicamento.grilla);
    Alpine.data("guardarCarroMedicamentos", Medicamento.guardarCarro);

    Alpine.data("createDispositivo", createDispositivo);
    Alpine.data("deleteDispositivo", deleteDispositivo);
    Alpine.data("grillaDispositivos", grillaDispositivos);
    Alpine.data("guardarCarroDispositivos", guardarCarroDispositivos);

    Alpine.data("historico", historico);
    Alpine.data("deleteCarro", deleteCarro);
    Alpine.data("resaltarVencimiento", resaltarVencimiento);
});

document.addEventListener("DOMContentLoaded", function() {
    Alpine.start();
});
