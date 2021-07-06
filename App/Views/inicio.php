<?php

use App\Models\DetalleVentasModel;

$a = new DetalleVentasModel();

$array = $a->ProductosMasVendido();
?>


<!-- Begin Page Content -->
<div class="container-fluid">
    </br>

    <!-- Tarjetas -->
    <div class="row position-relative">
        <div class="col-4">
            <div class="card text-white bg-primary">
                <div class="card-body">
                    <?php echo $total; ?> Total de productos
                </div>
                <a href="<?php echo base_url(); ?>/productos" class="card-footer text-white bg-primary">Ver detalles</a>
            </div>
        </div>

        <div class="col-4">
            <div class="card text-white bg-success">
                <div class="card-body">
                    <?php echo "$" . $totalVentas['total']; ?> Ventas del dia
                </div>
                <a href="<?php echo base_url(); ?>/ventas" class="card-footer text-white bg-success">Ver detalles</a>
            </div>
        </div>

        <div class="col-4">
            <div class="card text-white bg-danger">
                <div class="card-body">
                    <?php echo $minimos; ?> Productos con stock minimo
                </div>
                <a href="<?php echo base_url(); ?>/productos/mostrarMinimos" class="card-footer text-white bg-danger">Ver detalles</a>
            </div>
        </div>
    </div>
    <!-- Graficos -->
    <div class="row mt-4 mb-4">
        <div class="col-4">
            <canvas id="myChart" width="400" height="400"></canvas>
        </div>
    </div>
</div>
<!-- /.container-fluid -->

</div>
<!-- End of Main Content -->

<script>
    var datos = <?php echo json_encode($array); ?>;
    var ctx = document.getElementById('myChart').getContext('2d');
    var myChart = new Chart(ctx, {
        type: 'line',
        data: {
            labels: datos.map((data)=>{return data.nombre}),
            datasets: [{
                label: 'Productos mas vendidos',
                data:  datos.map((data)=>{return data.total}),
                backgroundColor: [
                    'rgba(255, 99, 132, 0.2)',
                    'rgba(54, 162, 235, 0.2)',
                    'rgba(255, 206, 86, 0.2)',
                    'rgba(75, 192, 192, 0.2)',
                    'rgba(153, 102, 255, 0.2)',
                    'rgba(255, 159, 64, 0.2)'
                ],
                borderColor: [
                    'rgba(255, 99, 132, 1)',
                    'rgba(54, 162, 235, 1)',
                    'rgba(255, 206, 86, 1)',
                    'rgba(75, 192, 192, 1)',
                    'rgba(153, 102, 255, 1)',
                    'rgba(255, 159, 64, 1)'
                ],
                borderWidth: 3
            }]
        },
        options: {
            scales: {
                yAxes: [{
                    ticks: {
                        beginAtZero: true
                    }
                }]
            }
        }
    });
</script>