import jQuery from "jquery";
import DataTable from 'datatables.net-dt';
import 'datatables.net-fixedcolumns-dt';
import { errorAlert } from "@/partials/alerts";
import { findDispositivos } from "@/carro/requests";
import { showLoader, hideLoader } from "@/partials/loader";

// Spanish
import ES from "../../partials/ES"

/**
 * Si, lo se, el nombre del archivo esta mal.
*/
export default () => ({
    table: undefined,
    api: process.env.API,
    ctrlId: undefined,
    selector: "#grilla-dispositivos",
    data: [],
    events: {
        ['@new-dispositivo-created.document']: "newDispositivo",
        ['@dispositivo-deleted.document']: "removeDispositivo",
        ['@dispositivo-updated.document']: "updateDispositivo",
        ['@carro-apertura-update.document']: "getData",
    },

    init() {
        this.setWatchers();
        this.getTable();
    },

    /**
    * Cuando un dispositivo se crea, se anexa a la grilla y al array de datos
    */
    newDispositivo({ detail: dispositivo }) {
        this.table.row.add(
            dispositivo
        ).draw();

        this.table
            .row( "#" + dispositivo.id )
            .node()
            .classList.add("bg-success-subtle");
    },

    /**
     * Elimina un dispositivo de la grilla
    */
    removeDispositivo({ detail: rowIndex }) {
        this.table
            .row( rowIndex )
            .remove()
            .draw();
    },

    /**
     * Actualiza un dispositivo de la grilla
    */
    updateDispositivo({ detail: data }) {
        this.table
            .row( data.rowIndex )
            .data( data.dispositivo )
            .draw();

        this.table
            .row( data.rowIndex )
            .node()
            .classList.add("bg-warning-subtle");
    },

    /**
     * Deshace todos los cambios `NO` guardados.
    */
    revertChanges() {
        this.updateTableRows( this.data );
    },

    /** Crea la tabla */
    getTable() {
        const CAN_EDIT = jQuery(this.selector).data("canEdit");

        this.table = new DataTable(this.selector, {
            searching: false,
            language: ES,
            fixedColumns: {
                left: 0,
                right: 2
            },
            scrollY: '50vh',
            scrollX: true,
            scrollCollapse: true,
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
                    render: data => data.split('-').reverse().join("-"),
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
                { data: 'vida_util', targets:  6 },
                { data: 'riesgo', targets: 7 },
                { data: 'cantidad', targets:  8 },
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


    /**
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
        showLoader();
        const { data, error } = await findDispositivos( this.getCarroId() );
        hideLoader();

        if (error !== null) return errorAlert("Error al obtener los dispositivos");

        this.data = data;
        // Actualizamos la tabla
        this.updateTableRows( this.data );
        this.$store["DIS_DATA"] = this.data;
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
            // await this.fixResponsive();
        });


        /**
         * Para que funcione el `Responsive` de la tabla.
        */
        this.$watch("grillaShow", async () => {
            await this.$nextTick();
            if (this.grillaShow === 2) {
                this.table.columns.adjust().draw();
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
        console.log("Datos en `data`: ", JSON.parse(
            JSON.stringify(this.data)
        ));
        console.log("Datos en datatable: ", JSON.parse(
            JSON.stringify(this.getTableData())
        ));
    },
});
