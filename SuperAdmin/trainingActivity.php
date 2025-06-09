<?php include('../components/layout.php'); ?>

<style>
/* Estilo de switch personalizado */
.switch {
  position: relative;
  display: inline-block;
  width: 45px;
  height: 24px;
}
.switch input {
  opacity: 0;
  width: 0;
  height: 0;
}
.slider {
  position: absolute;
  cursor: pointer;
  top: 0; left: 0;
  right: 0; bottom: 0;
  background-color: white;
  border: 2px solid #0B1956;
  border-radius: 34px;
  transition: .4s;
}
.slider:before {
  position: absolute;
  content: "";
  height: 16px;
  width: 16px;
  left: 4px;
  bottom: 3px;
  background-color: #0B1956;
  border-radius: 50%;
  transition: .4s;
}
input:checked + .slider {
  background-color: #0B1956;
}
input:checked + .slider:before {
  transform: translateX(20px);
  background-color: white;
}
</style>

<div style="width: 95%; max-width: 900px; margin: 30px auto; border: 1px solid #ccc; padding: 20px; border-radius: 10px; font-family: Arial, sans-serif; box-sizing: border-box;">
  <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 15px;">
    <h3 style="margin: 0;">Lista de Actividades</h3>
    <a href="addTrainingActivity.php" class="btn btn-success">Agregar Actividad</a>
  </div>

  <table class="table table-bordered">
    <thead class="table-light">
      <tr>
        <th>Nombre de la Actividad</th>
        <th>Total de Horas</th>
        <th>Estado</th>
        <th>Acciones</th>
      </tr>
    </thead>
    <tbody>
      <tr>
        <td>Curso de Liderazgo</td>
        <td>20</td>
        <td style="text-align: center;">
          <label class="switch">
            <input type="checkbox" checked>
            <span class="slider"></span>
          </label>
        </td>
        <td>
          <button class="btn btn-info btn-sm" data-bs-toggle="modal" data-bs-target="#modalVerMas1">Ver más</button>
          <a href="editarActividad.php?id=1" class="btn btn-primary btn-sm">Editar</a>
        </td>
      </tr>
      <tr>
        <td>Seminario de Innovación</td>
        <td>12</td>
        <td style="text-align: center;">
          <label class="switch">
            <input type="checkbox">
            <span class="slider"></span>
          </label>
        </td>
        <td>
          <button class="btn btn-info btn-sm" data-bs-toggle="modal" data-bs-target="#modalVerMas2">Ver más</button>
          <a href="editarActividad.php?id=2" class="btn btn-primary btn-sm">Editar</a>
        </td>
      </tr>
    </tbody>
  </table>
</div>
