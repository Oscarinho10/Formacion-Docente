<!-- Modal Registrar Entrega -->
<div class="modal fade" id="modalEntrega" tabindex="-1" aria-labelledby="modalEntregaLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">

      <div class="modal-header">
        <h5 class="modal-title" id="modalEntregaLabel">Entrega de actividad de <span id="nombreParticipanteEntrega"></span></h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
      </div>

      <div class="modal-body">
        <p>¿Confirmas que el participante entregó la actividad final?</p>

        <!-- ✅ Checkbox para confirmar entrega -->
        <div class="form-check mb-3">
          <input class="form-check-input" type="checkbox" id="entregadoCheckbox">
          <label class="form-check-label" for="entregadoCheckbox">Entregó la actividad</label>
        </div>

        <textarea class="form-control" id="observacionesEntrega" placeholder="Observaciones (opcional)" rows="3"></textarea>
      </div>

      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
        <button type="button" class="btn btn-primary" id="guardarEntregaBtn">Guardar Entrega</button>
      </div>

    </div>
  </div>
</div>
