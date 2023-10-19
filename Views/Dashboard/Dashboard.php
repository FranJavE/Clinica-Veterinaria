<?php header_admin($data); ?>

       <main class="app-content">
      <div class="app-title">
        <div>
          <h1><i class="fa fa-dashboard"></i> Dashboard</h1>
          <p>Bienvenido a la clinica veterinaria 'El Gato'</p>
        </div>
        <ul class="app-breadcrumb breadcrumb">
          <li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>
          <li class="breadcrumb-item"><a href="#">Dashboard</a></li>
        </ul>
      </div>
      <div class="row">
        <div class="col-md-6 col-lg-3">
          <div class="widget-small primary coloured-icon"><i class="icon fa fa-user"></i>
            <div class="info">
              <h4>Usuarios</h4>
              <p><b>5</b></p>
            </div>
          </div>
        </div>
        <div class="col-md-6 col-lg-3">
          <div class="widget-small info coloured-icon"><i class="icon fas fa-male"></i>
            <div class="info">
              <h4>Clientes</h4>
              <p><b>85</b></p>
            </div>
          </div>
        </div>
       <div class="col-md-6 col-lg-3">
          <div class="widget-small danger coloured-icon"><i class="icon fas fa-dog"></i> 
            <div class="info">
              <h4>Mascotas</h4>
              <p><b>100</b></p>
            </div>
          </div>
        </div>
        <div class="col-md-6 col-lg-3">
          <div class="widget-small warning coloured-icon"><i class="icon fas fa-book"></i>
            <div class="info">
              <h4>Citas</h4>
              <p><b>15</b></p>
            </div>
          </div>
        </div>
        <div class="col-md-6 col-lg-3">
          <div class="widget-small danger coloured-icon"><i class="icon fas fa-house-damage"></i>
            <div class="info">
              <h4>Guarderia</h4>
              <p><b>5</b></p>
            </div>
          </div>
        </div>
          <div class="col-md-6 col-lg-3">
          <div class="widget-small warning coloured-icon"><i class="icon fa fa-shopping-cart"></i>
            <div class="info">
              <h4>Productos</h4>
              <p><b>200</b></p>
            </div>
          </div>
        </div>
              <div class="col-md-6 col-lg-3">
          <div class="widget-small primary coloured-icon"><i class="icon fas fa-syringe"></i>
            <div class="info">
              <h4>Vacunas</h4>
              <p><b>70</b></p>
            </div>
          </div>
        </div>
        <div class="col-md-6 col-lg-3">
          <div class="widget-small info coloured-icon"><i class="icon fas fa-user-md"></i>
            <div class="info">
              <h4>Medicos</h4>
              <p><b>85</b></p>
            </div>
          </div>
        </div>
      </div>
      <div class="row">
        <div class="col-md-6">
          <div class="tile">
            <h3 class="tile-title">Consultas recientes</h3>
             <table class="table">
              <thead>
                <tr>
                  <th>#</th>
                  <th>Mascota</th>
                  <th>Dia</th>
                  <th>tratamiento</th>
                </tr>
              </thead>
              <table class="table">
              <tbody>
                <tr>
                  <td>1</td>
                  <td>Yorky</td>
                  <td>29/06/2021</td>
                  <td>Corte de cabello</td>
                </tr>
                <tr>
                  <td>2</td>
                  <td>Ballena</td>
                  <td>29/06/2021</td>
                  <td>Revision estomacal</td>
                </tr>
                <tr>
                  <td>3</td>
                  <td>Girasol</td>
                  <td>29/06/2021</td>
                  <td>Examen de vista</td>
                </tr>
                <tr>
                  <td>4</td>
                  <td>Jirafa</td>
                  <td>29/06/2021</td>
                  <td>Revision de cuello</td>
                </tr>
                <tr>
                  <td>5</td>
                  <td>Pansa</td>
                  <td>29/06/2021</td>
                  <td>Chequeo patita</td>
                </tr>
              </tbody>
            </table>
            </table>
          </div>
        </div>
        <div class="col-md-6">
          <div class="tile">
            <h3 class="tile-title">Estadistica citas</h3>
            <div class="embed-responsive embed-responsive-16by9">
              <canvas class="embed-responsive-item" id="pieChartDemo"></canvas>
            </div>
          </div>
        </div>
      </div>
    </main>
 <?php footer_admin($data); ?>
