<!-- Modal de Asistencia -->
<div class="modal fade" id="modalAsistencia" tabindex="-1" aria-labelledby="modalAsistenciaLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-centered">
    <div class="modal-content">

      <div class="modal-header">
        <h5 class="modal-title" id="modalAsistenciaLabel">
          <i class="fas fa-calendar-check me-2"></i> Asistencia de: <span id="nombreParticipanteAsistencia"></span>
        </h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
      </div>

      <div class="modal-body">
        <table class="table table-bordered table-hover">
          <thead class="table-light">
            <tr>
              <th>Fecha</th>
              <th>Sesión</th>
              <th>Asistencia</th>
            </tr>
          </thead>
          <tbody id="tablaSesionesAsistencia">
            <!-- Se llena con JS -->
          </tbody>
        </table>
      </div>

      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
        <button type="button" class="btn btn-primary" id="guardarAsistenciaBtn">Guardar Asistencia</button>
      </div>

    </div>
  </div>
</div>
