import axios from "axios";
import jQuery from "jquery";
import DataTable from 'datatables.net-dt';
import 'datatables.net-fixedcolumns-dt';
import { errorAlert } from "../../partials/alerts";
import { showLoader, hideLoader } from "../../partials/loader";

// Spanish para la grilla
import ES from "../../partials/ES"

export default () => ({
    table: undefined,
    ctrlId: undefined, // Id del carro seleccionado actual
    api: process.env.API,
    selector: "#grilla-medicamentos",
    data: [],
    events: {
        ['@new-medicamento-created.document']: "newMedicamento",
        ['@medicamento-deleted.document']: "removeMedicamento",
        ['@medicamento-updated.document']: "updateMedicamento",
        ["@carro-apertura-update.document"]: "getData"
    },

    init() {
        this.setWatchers();
        this.getTable();
    },

    /**
    * Cuando un medicamento se crea, se anexa a la grilla
    */
    newMedicamento({ detail: medicamento }) {
        this.table.row.add(
            medicamento
        ).draw();

        this.table
            .row( "#" + medicamento.id )
            .node()
            .classList.add("bg-success-subtle");
    },

    /**
     * Elimina un medicamento y actualiza la tabla
    */
    removeMedicamento({ detail: rowIndex }) {
        this.table
            .row( rowIndex )
            .remove()
            .draw();
    },

    /**
     * Actualiza la tabla
    */
    updateMedicamento({ detail: data }) {
        this.table
            .row( data.rowIndex )
            .data( data.medicamento )
            .draw();

        this.table
            .row( data.rowIndex )
            .node()
            .classList.add("bg-warning-subtle");
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
                { data: 'p_activo_concentracion', targets: 0 },
                { data: 'forma_farma', targets: 1, orderable: false },
                { data: 'medida', targets: 2, orderable: false },
                { data: 'presentacion', targets:  3, orderable: false },
                { data: 'invima', targets: 4, orderable: false },
                { data: 'lote', targets: 5, orderable: false },
                {
                    data: 'vencimiento',
                    targets: 6,
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
                { data: 'cantidad', targets: 7 },
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
     * ndica que se debe modificar un medicamento
    */
    dispatchEdit( rowIndex ) {
        const med = this.table.row(rowIndex).data();

        if (Boolean(med)) {
            this.$dispatch("edit-medicamento", {
                medicamento: med,
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
                `${this.api}/carros/${this.getCarroId()}/get-medicamentos`
            ).finally(hideLoader);

            this.data = data;

            // Actualizamos la tabla
            this.updateTableRows( this.data );
            this.$store["MED_DATA"] = this.data;
        } catch(e) {
            console.error("Error get med: ", e);
            errorAlert("Error al obtener los medicamentos")
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
        this.$watch("grillaShow", async () => {
            await this.$nextTick();
            if (this.grillaShow === 1) {
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
     * Muestra la data de la tabla
    */
    showData() {
        console.log("Datos en `data`: ", JSON.parse(
            JSON.stringify(this.data))
        );
        console.log("Datos en datatable: ", JSON.parse(
            JSON.stringify(this.getTableData())
        ));
    },
});
