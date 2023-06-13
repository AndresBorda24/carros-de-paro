export default () => ({
    print() {
        const prtContent = document.querySelector(this.selector + "_wrapper");
        const WinPrint   = window.open(
            '',
            '',
            'left=0,top=0,width=800,height=900,toolbar=0,scrollbars=0,status=0'
        );

        // Agregamos los css para que se vea bien
        WinPrint.document.write(`
            <link
            rel="stylesheet"
            type="text/css"
            href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
        `);
        WinPrint.document.write(`
            <link
            rel="stylesheet"
            type="text/css"
            href="https://cdn.datatables.net/1.13.4/css/jquery.dataTables.min.css">
        `);

        WinPrint.document.write(prtContent.innerHTML);
        WinPrint.document.close();
        WinPrint.setTimeout(function(){
          WinPrint.focus();
          WinPrint.print();
          WinPrint.close();
        }, 1000);
    }
});
