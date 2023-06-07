import jQuery from "jquery";
import DataTable from 'datatables.net-dt';
import 'datatables.net-responsive-dt';

export default () => ({
    selector: "#grilla-medicamentos",
    table: undefined,
    data: [],
    events: {
        ['@new-medicamento-created.document']: "newMedicamento"
    },

    init() {
        this.$watch("CARRO", () => {
            console.log("Cambio el ID: ", this.getCarroId());
        });

        this.$watch("grillaShow", (val) => {
            if (val == 1) {
                this.$nextTick(() => {
                    this.table
                        .columns.adjust()
                        .responsive.recalc();
                });
            }
        });

        this.getTable();
    },

    newMedicamento({ detail: medicamento }) {
        this.data.push( medicamento );

        this.table.row.add(
            medicamento
        ).draw();
    },

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
            ]
        });
    }
});
