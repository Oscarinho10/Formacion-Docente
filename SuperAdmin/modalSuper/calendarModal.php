<!-- calendarModal.php -->
<div class="modal fade" id="calendarModal" tabindex="-1" role="dialog">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content shadow">
      <div class="modal-header bg-primary text-white">
        <h5 class="modal-title">Registrar asistencia</h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Cerrar"></button>
      </div>
      <div class="modal-body text-center">
        <p id="nombreParticipante" class="fw-bold text-primary mb-3"></p>
        <input type="text" id="fechaAsistencia" class="form-control mb-3" placeholder="Haz clic para elegir fechas" readonly />
        <div id="listaFechasSeleccionadas" class="text-start small text-dark fw-bold"></div>
      </div>
      <div class="modal-footer">
        <button class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
        <button class="btn btn-success" id="guardarAsistencia">Guardar</button>
      </div>
    </div>
  </div>
</div>
