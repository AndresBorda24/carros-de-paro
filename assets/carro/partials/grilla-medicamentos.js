import jQuery from "jquery";
import DataTable from 'datatables.net-dt';
import 'datatables.net-responsive-dt';

export default () => ({
    selector: "#grilla-medicamentos",
    table: undefined,
    data: [],

    init() {
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

    getTable() {
        this.table = new DataTable(this.selector, {
            responsive: true,
            paging: false
        });
    }
});
