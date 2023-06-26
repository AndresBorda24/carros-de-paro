import axios from "axios";
import jQuery from "jquery";
import DataTable from 'datatables.net-dt';
import 'datatables.net-fixedcolumns-dt';
import { errorAlert } from "../../partials/alerts";
import { showLoader, hideLoader } from "../../partials/loader";

// Spanish
import ES from "../../partials/ES"

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
        ["@carro-apertura-cancelada.document"] : "revertChanges",
        ['@carro-apertura-update.document']: "getData",
        ["@carro-apertura-save.document"]: "sendSaveData",
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
            // responsive: true,
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
                {
                    data: 'vencimiento',
                    targets: 1,
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
                { data: 'marca', targets: 2 },
                { data: 'presentacion', targets: 3, orderable: false },
                { data: 'invima', targets: 4, orderable: false },
                { data: 'lote', targets: 5, orderable: false },
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
     * Envia la informacion de la grilla para que se realice la peticion y
     * se guarden los datos en la base de datos.
    */
    sendSaveData() {
        this.$dispatch("save-dispositivos-data", this.getTableData());
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
        try {
            showLoader();

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
        // this.$watch("carroStatus", async () => {
        //     await this.fixResponsive();
        // });
    },

    /**
     * Ajusta el ancho de las columnas. Si. Es necesario.
    */
    // async fixResponsive() {
    //     await this.$nextTick();
    //     setTimeout(() => {
    //         this.table
    //             .columns.adjust()
    //             .responsive.recalc()
    //     }, 50);
    // },

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
