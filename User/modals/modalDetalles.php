<!-- modalDetalles.php -->
<div class="modal fade" id="detalleModal" tabindex="-1" role="dialog" aria-labelledby="detalleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="detalleModalLabel">Detalles del curso</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>

      <div class="modal-body">

        <!-- Nuevos campos -->
        <hr>
        <p><strong>Lugar:</strong> <span id="modalLugar"></span></p>
        <p><strong>Tipo:</strong> <span id="modalTipo"></span></p>
        <p><strong>Fecha de inicio:</strong> <span id="modalInicio"></span></p>
        <p><strong>Fecha de fin:</strong> <span id="modalFin"></span></p>
        <p><strong>Dirigido a:</strong> <span id="modalDirigido"></span></p>
        <p><strong>Horario:</strong> <span id="modalHorario"></span></p>
      </div>

      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
      </div>
    </div>
  </div>
</div>