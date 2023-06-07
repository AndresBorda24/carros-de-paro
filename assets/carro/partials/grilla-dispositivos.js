import axios from "axios";
import jQuery from "jquery";
import DataTable from 'datatables.net-dt';
import 'datatables.net-responsive-dt';
import { errorAlert } from "../../partials/alerts";
import { showLoader, hideLoader } from "../../partials/loader";

export default () => ({
    table: undefined,
    api: process.env.API,
    ctrlId: undefined,
    selector: "#grilla-dispositivos",
    data: [],
    events: {
        ['@new-dispositivo-created.document']: "newDispositivo",
        ['@dispositivo-deleted.document']: "removeDispositivo",
        ['@dispositivo-updated.document']: "updateDispositivo"
    },

    init() {
        this.setWatchers();
        this.getTable();
    },

    /**
    * Cuando un dispositivo se crea, se anexa a la grilla y al array de datos
    */
    newDispositivo({ detail: dispositivo }) {
        this.data.push( dispositivo );

        this.table.row.add(
            dispositivo
        ).draw();
    },

    /**
     * Elimina un dispositivo de `data` y actualiza la tabla
    */
    removeDispositivo({ detail: dispositivoId }) {
        const index = this.data.findIndex(m => m.id == dispositivoId);

        if (index !== -1) {
            this.data.splice(index, 1);
            this.updateTableRows( this.data );
        }
    },

    /**
     * Actualiza un dispositivo y actualiza la tabla
    */
    updateDispositivo({ detail: dispositivo }) {
        const index = this.data.findIndex(m => m.id == dispositivo.id);

        if (index !== -1) {
            this.data[ index ] = dispositivo;
            this.updateTableRows( this.data );
        }
    },

    /** Crea la tabla */
    getTable() {
        this.table = new DataTable(this.selector, {
            responsive: true,
            paging: false,
            columnDefs: [
                { data: 'desc', targets: 0 },
                { data: 'marca', targets: 1 },
                { data: 'presentacion', targets: 2 },
                { data: 'invima', targets: 3 },
                { data: 'lote', targets: 4 },
                { data: 'vencimiento', targets: 5 },
                { data: 'cantidad', targets: 6 },
                { data: 'vida_util', targets:  7 },
                { data: 'riesgo', targets:  8 },
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
     * ndica que se debe modificar un dispositivo
    */
    dispatchEdit( dispositivoId ) {/**/
        const med = this.data.find( m => m.id == dispositivoId );

        if (Boolean(med)) {
            this.$dispatch("edit-dispositivo", med);
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
});
