import Alpine from "alpinejs";

import * as Carro from "./carro/index";
import * as Historico from "./histo/index";
import * as Medicamentos from "./medicamentos/index";
import * as Dispositivos from "./dispositivos/index";

import print from "../partials/print";
import resaltarVencimiento from "./partials/resaltar-vencimiento";
import sessionPulse from "./partials/session-pulse";

import "../css/carro.css";

window.Alpine = Alpine;

document.addEventListener("alpine:init", function() {
    /** Global stores para la info de las grillas **/
    Alpine.store("MED_DATA", []);
    Alpine.store("DIS_DATA", []);
    Alpine.store("APERTURA_ID", 0);

    Alpine.data("carro", Carro.carro);
    Alpine.data("carrosList", Carro.carrosList);
    Alpine.data("createCarro", Carro.createCarro);
    Alpine.data("deleteCarro", Carro.deleteCarro);
    Alpine.data("createApertura", Carro.apertura);
    Alpine.data("updateApertura", Carro.updateApertura);

    Alpine.data("createMedicamento", Medicamentos.manage);
    Alpine.data("deleteMedicamento", Medicamentos.remove);
    Alpine.data("grillaMedicamentos", Medicamentos.grilla);

    Alpine.data("createDispositivo", Dispositivos.manage);
    Alpine.data("deleteDispositivo", Dispositivos.remove);
    Alpine.data("grillaDispositivos", Dispositivos.grilla);

    Alpine.data("histoShow", Historico.show);
    Alpine.data("histoSelect", Historico.select);
    Alpine.data("histoComparacion", Historico.comparacion);

    Alpine.data("print", print);
    Alpine.data("resaltarVencimiento", resaltarVencimiento);
});

document.addEventListener("DOMContentLoaded", function() {
    Alpine.start();

    window.closeDetail = () => {
        document
            .querySelector("details[open]")
            .removeAttribute('open');
    }

    window.setInterval(sessionPulse, 1000 * 60 * 15);
});
