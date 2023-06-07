import axios from "axios";
import jQuery from "jquery";
import DataTable from 'datatables.net-dt';
import 'datatables.net-responsive-dt';
import { errorAlert } from "../../partials/alerts";
import { showLoader, hideLoader } from "../../partials/loader";

export default () => ({
    table: undefined,
    ctrlId: undefined,
    api: process.env.API,
    selector: "#grilla-medicamentos",
    data: [],
    events: {
        ['@new-medicamento-created.document']: "newMedicamento",
        ['@medicamento-deleted.document']: "removeMedicamento",
        ['@medicamento-updated.document']: "updateMedicamento"
    },

    init() {
        this.setWatchers();
        this.getTable();
    },

    /**
    * Cuando un medicamento se crea, se anexa a la grilla y al array de datos
    */
    newMedicamento({ detail: medicamento }) {
        this.data.push( medicamento );

        this.table.row.add(
            medicamento
        ).draw();
    },

    /**
     * Elimina un medicamento de `data` y actualiza la tabla
    */
    removeMedicamento({ detail: medicamentoId }) {
        const index = this.data.findIndex(m => m.id == medicamentoId);

        if (index !== -1) {
            this.data.splice(index, 1);
            this.updateTableRows( this.data );
        }
    },

    /**
     * Actualiza un medicamento y actualiza la tabla
    */
    updateMedicamento({ detail: medicamento }) {
        const index = this.data.findIndex(m => m.id == medicamento.id);

        if (index !== -1) {
            this.data[ index ] = medicamento;
            this.updateTableRows( this.data );
        }
    },

    /** Crea la tabla */
    getTable() {
        this.table = new DataTable(this.selector, {
            responsive: true,
            paging: false,
            columnDefs: [
                { data: 'p_activo_concentracion', targets: 0 },
                { data: 'forma_farma', targets: 1 },
                { data: 'medida', targets: 2 },
                { data: 'presentacion', targets:  3 },
                { data: 'invima', targets: 4 },
                { data: 'lote', targets: 5 },
                { data: 'vencimiento', targets: 6 },
                { data: 'cantidad', targets: 7 },
                {
                    targets: -1,
                    data: 'id',
                    render: (data) => `
                        <button
                        @click="dispatchEdit(${data})"
                        class="btn btn-primary btn-sm px-1 py-0">
                            <span>&#9881;</span>
                        </button>
                    `,
                    searchable: false,
                    orderable: false
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
    dispatchEdit( medicamentoId ) {/**/
        const med = this.data.find( m => m.id == medicamentoId );

        if (Boolean(med)) {
            this.$dispatch("edit-medicamento", med);
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
        this.$watch("grillaShow", (val) => {
            if (val == 1) {
                this.$nextTick(() => {
                    this.table
                        .columns.adjust()
                        .responsive.recalc();
                });
            }
        });
    },
});
