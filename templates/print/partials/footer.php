<tfoot>
  <tr>
    <td class="text-center">
      <span class="small">
        Cl&iacute;nica Asotrauma
      </span>
      <span class="mx-2">|</span>
      <span class="small">
          NIT: 800209891-7
      </span>
      <span class="mx-2">|</span>
      <span class="small">
        Cra. 4D No. 32 - 34 , Ibagu&eacute;, Tolima
      </span>
    </td>
  </tr>
  <tr>
    <td class="lh-1 p-0 small text-center text-muted">
      <span class="small">
        <?= isset($_data["isCurrent"])
          ? date("Y-m-d H:i")
          : date("Y-m-d H:i", strtotime($_data["fecha"])) ?>
      </span>
    </td>
  </tr>
</tfoot>
