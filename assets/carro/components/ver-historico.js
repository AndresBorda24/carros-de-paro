import axios from "axios";
import { errorAlert } from "../../partials/alerts";
import { showLoader, hideLoader } from "../../partials/loader";

export default () => ({
    // Fechas de los selects
    d: {},
    api: process.env.API,
    data: {},

    init() {
        this.setFechas();
    },

    /**
     * Establece unas fechas por defecto para los selects.
    */
    setFechas() {
        const _ = 1000 * 60 * 60 * 24 * 7; // Una semana

        const now  = new Date()
;        const week = new Date( now.getTime() -  _ );

        this.d.start = week.toJSON().substring(0, 10);
        this.d.end   = now.toJSON().substring(0, 10);
    },

    /**
     * Obtiene el mensaje del registro
     *
    */
    getRowText( data ) {
        const actions =  {
            INSERT: "Agreg&oacute;",
            UPDATE: "Modific&oacute;",
            DELETE: "Elimin&oacute;",
        };

        return `
        <span class="fw-semibold mx-2">${ data.usuario_id }</span> &#10140;
        ${ actions[ data.action ] } un ${ data.model }:
        <span class="">${ data.model_nombre }</span>
        `;
    },

    /**
     * Realiza la consulta
    */
    async getData() {
        try {
            showLoader();

            const fechas   = `?start=${this.d.start}&end=${this.d.end}`;
            const { data } = await axios.get(
                `${this.api}/registro/${this.getCarroId()}/get-registro${fechas}`
            ).finally(hideLoader);

            this.data = data;
        } catch(e) {
            errorAlert("No se ha logrado cargar la info.");
            console.error("historico: ", e);
        }
    }

});
