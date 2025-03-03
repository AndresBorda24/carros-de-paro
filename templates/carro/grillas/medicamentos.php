<div
        x-data="grillaMedicamentos"
        x-bind="events"
        class="small w-100 p-2 border rounded bg-body overflow-x-hidden">
    <div class="d-flex flex-wrap gap-2 justify-content-between mb-2">
        <?php if ($this->can("medicamentos.create")): ?>
            <button
                    x-cloak
                    x-show="carroStatus"
                    @click="$dispatch('create-medicamento', getCarroId())"
                    class="btn btn-success btn-sm text-sm flex items-center gap-1"
            >
              <span class="flex items-center">
                <?= $this->fetch("./icons/plus.php") ?>
              </span>
                <span>Adjuntar Medicamento</span>
            </button>

        <?php endif ?>

        <div class="d-flex gap-1 flex-grow-1 justify-content-end">
            <?php if ($this->can("grillas.ver-datos")): ?>
                <button
                        @click="showData"
                        class="btn btn-warning btn-sm text-sm">
                    Mostrar datos
                </button>
            <?php endif ?>
        </div>
    </div>

    <table
            id="grilla-medicamentos"
            style="width:100%"
            data-can-edit="<?= (int)$this->can("medicamentos.edit") ?>"
            class="display compact small nowrap">
        <thead>
        <tr>
            <th
                    class="med_p_activo_concentracion"
                    style="word-break: normal; white-space: pre-line"
                    data-priority="0">Principio Activo / Concentraci&oacute;n
            </th>
            <th
                    class="med_forma_farma"
                    style="word-break: normal; white-space: pre-line"
                    data-priority="4">Forma Farmaceutica
            </th>
            <th
                    class="med_medida"
                    style="word-break: normal; white-space: pre-line"
                    data-priority="5">Unidad Medida
            </th>
            <th
                    class="med_presentacion"
                    style="word-break: normal; white-space: pre-line"
                    data-priority="4">Presentaci&oacute;n Comercial
            </th>
            <?php if ($this->isRoute("carros.estantes")): ?>
                <th
                        class="med_nombre_comercial"
                        style="word-break: normal; white-space: pre-line"
                        data-priority="5">Nombre Comercial
                </th>
            <?php endif ?>
            <th class="med_invima" data-priority="3">Invima</th>
            <th class="med_lote" data-priority="3">Lote</th>
            <th
                    class="med_vencimiento"
                    style="word-break: normal; white-space: pre-line"
                    data-priority="2">Fecha Vencimiento
            </th>
            <?php if ($this->isRoute("carros.index")): ?>
                <th class="med_cantidad" data-priority="1">Cant.</th>
            <?php endif ?>
            <th data-priority="0"></th>
        </tr>
        </thead>
    </table>
</div>
