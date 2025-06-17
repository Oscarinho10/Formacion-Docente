  <?php
    include('../components/layoutSuper.php')
    ?>


  <!DOCTYPE html>
  <html lang="en">

  <head>
      <meta charset="UTF-8">
      <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <title>Reporte por unidad academica </title>
      <meta charset="UTF-8">
      <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <title>Reportes</title>
      <link rel="stylesheet" href="<?php echo BASE_URL; ?>/assets/css/bootstrap.css" type="text/css">
      <link rel="stylesheet" href="<?php echo BASE_URL; ?>/assets/css/tabla.css" type="text/css">

      <!-- FontAwesome -->
      <link rel="stylesheet" href="<?php echo BASE_URL; ?>/assets/fontawesome/all.min.css" type="text/css">
      <link rel="stylesheet" href="<?php echo BASE_URL; ?>/assets/fontawesome/brands.min.css" type="text/css">
      <link rel="stylesheet" href="<?php echo BASE_URL; ?>/assets/fontawesome/solid.min.css" type="text/css">
  </head>

  <body>
      <div class="container mt-4" style="max-width: 1200px;">
          <h4 class="mb-3">Generar reporte por unidad academica</h4>
          <div class="d-flex justify-content-end">

              <button onclick="window.location.href='<?php echo BASE_URL; ?>/SuperAdmin/initSuper.php'" class="btn btn-dark mr-2">
                  <i class="fas fa-arrow-left"></i> Regresar
              </button>

              <button class="btn btn-general btn-sm" onclick="imprimirTabla()">
                  <i class="fas fa-print"></i> Imprimir reporte
              </button>

          </div>
         
            <div class="p-3 mb-4">

        </div>
              <div class="p-3 mb-4" style="background-color: #215472; border-radius: 5px;">
                  <div class="form-row align-items-center">
                      <div class="col-md-5 mb-2">
                          <label class="mb-0"></label>
                          <div class="input-group">
                              <div class="input-group-prepend">
                                  <span class="input-group-text bg-white"><i class="fas fa-search"></i></span>
                              </div>
                              <input type="text" id="searchInput" class="form-control" placeholder="Buscar por unidad académica">
                          </div>
                      </div>

                      <div class="col-md-3 mb-2 text-white">
                          <label class="mb-0 mr-2">Rango de años</label>
                          <select class="form-control" id="yearRange">
                              <option value="5">5</option>
                              <option value="4">4</option>
                              <option value="3">3</option>
                              <option value="2">2</option>
                              <option value="1">1</option>
                          </select>
                      </div>

                      <div class="col-md-2 mb-2 justify-content-end">
                          <label class="mb-0"></label>
                          <button class="btn btn-success btn-block" onclick="filtrarAnios()">Consultar</button>
                      </div>
                  </div>
              </div>

              <!-- Tabla -->
              <div class="table-responsive">
                  <table class="table table-bordered" id="tablaAnios">
                      <thead class="thead-light">
                          <tr>
                              <th>Año</th>
                              <th>Unidad Académica</th>
                              <th>Actividades Realizadas</th>
                              <th>Total Participantes</th>
                              <th>Total Asistencias</th>
                          </tr>
                      </thead>
                      <tbody id="tbodyAnios">
                          <!-- Contenido dinámico -->
                      </tbody>
                  </table>
              </div>
          </div>
  </body>
  <script src="<?php echo BASE_URL; ?>/assets/js/bootstrap.min.js"></script>
  <script type="text/javascript" src="<?php echo BASE_URL; ?>/SuperAdmin/js/reportsUnityAcademy.js"></script>

  </html>