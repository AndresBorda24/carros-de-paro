import Alpine from "alpinejs";

import carro from "./components/carro";
import carrosList from "./components/carros-list";
import deleteCarro from "./partials/delete-carro";
import createCarro from "./components/create-carro";

import * as Medicamentos from "./medicamentos/index";
import * as Dispositivos from "./dispositivos/index";

import historicoSelect from "./historico/selects"
import historicoChanges from "./historico/comparacion"

import printTable from "./partials/print-table";
import resaltarVencimiento from "./partials/resaltar-vencimiento";

import modifyCarro from "./components/modify-carro";
import "../css/carro.css";

window.Alpine = Alpine;

document.addEventListener("alpine:init", function() {
    Alpine.data("carro", carro);
    Alpine.data("carrosList", carrosList);
    Alpine.data("createCarro", createCarro);

    Alpine.data("createMedicamento", Medicamentos.manage);
    Alpine.data("deleteMedicamento", Medicamentos.remove);
    Alpine.data("grillaMedicamentos", Medicamentos.grilla);

    Alpine.data("createDispositivo", Dispositivos.manage);
    Alpine.data("deleteDispositivo", Dispositivos.remove);
    Alpine.data("grillaDispositivos", Dispositivos.grilla);
    Alpine.data("guardarCarroDispositivos", Dispositivos.guardarCarro);

    Alpine.data("historicoSelect", historicoSelect);
    Alpine.data("historicoChanges", historicoChanges);

    Alpine.data("deleteCarro", deleteCarro);
    Alpine.data("resaltarVencimiento", resaltarVencimiento);

    Alpine.data("printTable", printTable);
    Alpine.data("modifyCarro", modifyCarro);
});

document.addEventListener("DOMContentLoaded", function() {
    Alpine.start();
});
