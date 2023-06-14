export default () => ({
    print(tipo = "") {
        const prtContent = document
            .querySelector(this.selector)
            .cloneNode(true);

        prtContent.className = "";
        prtContent.classList.add("table");
        prtContent.classList.add("table-stripped");
        prtContent.classList.add("table-bordered");
        prtContent.classList.add("table-sm");
        prtContent.classList.add("text-sm");
        prtContent.classList.add("mt-2");


        const WinPrint   = window.open(
            '',
            '',
            'left=0,top=0,width=800,height=900,toolbar=0,scrollbars=0,status=0'
        );

        // Agregamos los css para que se vea bien
        WinPrint.document.write(`
            <style>
                tr > th:last-child,
                tr > td:last-child {
                    display: none;
                }
            </style>
        ` + document.querySelector("head > link:last-of-type").outerHTML + `
            <link
            rel="stylesheet"
            type="text/css"
            href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
            <header class="bg-blue-dark">
              <div class="container p-2 text-light d-flex align-items-center justify-content-between">
                <span class="fw-bold ">Cl&iacute;nica Asotrauma</span>
                <span class="small badge text-bg-light">${ tipo }</span>
                <span class="small">${ this.getCarroNombre() }</span>
              </div>
            </header>
        ` + prtContent.outerHTML + `
          <div class="text-center p-1 bg-blue-main text-sm">
            <span class="small text-light">
                NIT: 800209891-7
            </span>
            <span class="mx-2 text-light">|</span>
            <span class="small text-light">
                Cra. 4D No. 32 - 34 , Ibagu&eacute;, Tolima
            </span>
          </div>
        `);

        WinPrint.document.close();
        WinPrint.setTimeout(function(){
          WinPrint.focus();
          WinPrint.print();
          WinPrint.close();
        }, 1000);
    }
});
