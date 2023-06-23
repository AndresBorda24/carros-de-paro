import Alpine from "alpinejs";

import * as Carro from "./carro/index";
import * as Historico from "./histo/index";
import * as Medicamentos from "./medicamentos/index";
import * as Dispositivos from "./dispositivos/index";

import historicoSelect from "./historico/selects"
import historicoChanges from "./historico/comparacion"

import printTable from "./partials/print-table";
import resaltarVencimiento from "./partials/resaltar-vencimiento";

import "../css/carro.css";

window.Alpine = Alpine;

document.addEventListener("alpine:init", function() {
    Alpine.data("carro", Carro.carro);
    Alpine.data("carrosList", Carro.carrosList);
    Alpine.data("createCarro", Carro.createCarro);
    Alpine.data("modifyCarro", Carro.modifyCarro);
    Alpine.data("deleteCarro", Carro.deleteCarro);
    Alpine.data("carroModify", Carro.carroModify);

    Alpine.data("createMedicamento", Medicamentos.manage);
    Alpine.data("deleteMedicamento", Medicamentos.remove);
    Alpine.data("grillaMedicamentos", Medicamentos.grilla);

    Alpine.data("createDispositivo", Dispositivos.manage);
    Alpine.data("deleteDispositivo", Dispositivos.remove);
    Alpine.data("grillaDispositivos", Dispositivos.grilla);

    Alpine.data("historicoSelect", historicoSelect);
    Alpine.data("historicoChanges", historicoChanges);

    Alpine.data("histoShow", Historico.show);
    Alpine.data("histoSelect", Historico.select);
    Alpine.data("histoComparacion", Historico.comparacion);

    Alpine.data("resaltarVencimiento", resaltarVencimiento);
    Alpine.data("printTable", printTable);
});

document.addEventListener("DOMContentLoaded", function() {
    Alpine.start();

    window.closeDetail = () => {
        document
            .querySelector("details[open]")
            .removeAttribute('open');
    }
});
