import axios from "axios";
import jQuery from "jquery";
import DataTable from 'datatables.net-dt';
import 'datatables.net-responsive-dt';
import { errorAlert } from "../../partials/alerts";
import { showLoader, hideLoader } from "../../partials/loader";

// Spanish
import ES from "../../partials/ES"

export default () => ({
    table: undefined,
    api: process.env.API,
    ctrlId: undefined,
    hasChanged: false,
    selector: "#grilla-dispositivos",
    data: [],
    events: {
        ['@new-dispositivo-created.document']: "newDispositivo",
        ['@dispositivo-deleted.document']: "removeDispositivo",
        ['@dispositivo-updated.document']: "updateDispositivo",
        ['@carro-dispositivos-updated.document']: "getData"
    },

    init() {
        this.setWatchers();
        this.getTable();
    },

    /**
    * Cuando un dispositivo se crea, se anexa a la grilla y al array de datos
    */
    newDispositivo({ detail: dispositivo }) {
        this.hasChanged = true;
        this.table.row.add(
            dispositivo
        ).draw();
    },

    /**
     * Elimina un dispositivo de la grilla
    */
    removeDispositivo({ detail: rowIndex }) {
        this.hasChanged = true;
        this.table
            .row( rowIndex )
            .remove()
            .draw();
    },

    /**
     * Actualiza un dispositivo de la grilla
    */
    updateDispositivo({ detail: data }) {
        this.hasChanged = true;
        this.table
            .row( data.rowIndex )
            .data( data.dispositivo )
            .draw();
    },

    /**
     * Deshace todos los cambios `NO` guardados.
    */
    revertChanges() {
        this.updateTableRows( this.data );
        this.hasChanged = false;
    },

    /** Crea la tabla */
    getTable() {
        const CAN_EDIT = jQuery(this.selector).data("canEdit");

        this.table = new DataTable(this.selector, {
            searching: false,
            responsive: true,
            language: ES,
            paging: false,
            rowId: 'id',
            columnDefs: [
                { data: 'desc', targets: 0 },
                { data: 'marca', targets: 1 },
                { data: 'presentacion', targets: 2, orderable: false },
                { data: 'invima', targets: 3, orderable: false },
                { data: 'lote', targets: 4, orderable: false },
                {
                    data: 'vencimiento',
                    targets: 5,
                    createdCell: (td, data) => {
                        const _ = jQuery(td);
                        _.attr(
                            "x-data",
                            `resaltarVencimiento('${data}')`
                        ).attr(
                            "x-bind",
                            "binds"
                        );
                    }
                },
                { data: 'cantidad', targets: 6 },
                { data: 'vida_util', targets:  7 },
                { data: 'riesgo', targets:  8 },
                {
                    targets: -1,
                    data: 'id',
                    render: (data) => `
                        <button
                        x-cloak
                        x-show="carroStatus"
                        @click="dispatchEdit('#${data}')"
                        class="btn btn-primary btn-sm px-1 py-0">
                            <span>&#9881;</span>
                        </button>
                    `,
                    searchable: false,
                    orderable: false,
                    visible: CAN_EDIT
                }
            ]
        });
    },

    /**
     * Actualiza las filas de la tabla
    */
    updateTableRows( data ) {
        this.table.clear();
        this.table.rows.add( data );
        this.table.draw();
    },

    /** I
     * Indica que se debe modificar un dispositivo
    */
    dispatchEdit( rowIndex ) {
        const disp = this.table.row(rowIndex).data();

        if (Boolean(disp)) {
            this.$dispatch("edit-dispositivo", {
                dispositivo: disp,
                rowIndex: rowIndex
            });
        }
    },

    /**
     * Obtiene los datos de la tabla.
    */
    async getData() {
        try {
            showLoader();
            this.hasChanged = false;

            const { data } = await axios.get(
                `${this.api}/carros/${this.getCarroId()}/get-dispositivos`
            ).finally(hideLoader);

            this.data = data;

            // Actualizamos la tabla
            this.updateTableRows( this.data );
        } catch(e) {
            console.error("Error get med: ", e);
            errorAlert("Error al obtener los dispositivos")
        }
    },

    /**
     * El componente debe rastrear ciertos cambios en el estado. Para eso
     * son los watchers
    */
    setWatchers() {
        /**
         * CARRO Almacena la info del carro. Esta en el componente Carro
        */
        this.$watch("CARRO", async () => {
            if (this.getCarroId() === null) {
                return;
            }

            if (this.ctrlId !== this.getCarroId()) {
                this.ctrlId = this.getCarroId();
                await this.getData();

                console.log("Cambio el ID dispositivo: ", this.getCarroId());
            }
        });


        /**
         * Para que funcione el `Responsive` de la tabla.
        */
        this.$watch("grillaShow", (val) => {
            if (val == 2) {
                this.$nextTick(() => {
                    this.table
                        .columns.adjust()
                        .responsive.recalc();
                });
            }
        });
    },

    /**
     * Obtiene los datos actuales de la tabla
    */
    getTableData() {
        const _ = this.table.rows().data();
        const x = Object.values(_).slice(0, _.length);
        return x;
    },

    /**
     * Muestra la data de la tabla esto es mas para debug jeje
    */
    showData() {
        const _ = this.table.rows().data();
        const x = Object.values(_).slice(0, _.length);

        console.log("Datos en `data`: ", JSON.parse( JSON.stringify(this.data)))
        console.log("Datos en datatable: ", JSON.parse( JSON.stringify(x) ));
    },
});
