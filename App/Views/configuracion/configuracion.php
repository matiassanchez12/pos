<div class="container-fluid">
    <h4 class="m-0 text-gray-800"><i class="fas fa-sliders-h"></i> Configuraciones</h4>
    <br>

    <form action="<?php echo base_url(); ?>/configuracion/actualizarConfiguracionGeneral" method="post">

        <ul class="nav nav-tabs" id="myTab" role="tablist">
            <li class="nav-item" role="presentation">
                <a class="nav-link active" id="estetica-tab" onclick="mostrarTicket(1)" data-toggle="tab" href="#estetica" role="tab" aria-controls="estetica" aria-selected="true">Personalizar vista</a>
            </li>
            <li class="nav-item" role="presentation">
                <a class="nav-link" id="home-tab" onclick="mostrarTicket(1)" data-toggle="tab" href="#home" role="tab" aria-controls="home" aria-selected="false">Ticket</a>
            </li>
            <li class="nav-item" role="presentation">
                <a class="nav-link" id="profile-tab" onclick="mostrarTicket(1)" data-toggle="tab" href="#profile" role="tab" aria-controls="profile" aria-selected="false">Moneda</a>
            </li>
        </ul>
        <div class="tab-content" id="myTabContent">
            <div class="tab-pane fade show active" id="estetica" role="tabpanel" aria-labelledby="estetica-tab">
                <div class="row">
                    <div class="col-12 col-sm-6">
                        <br>
                        <h5 class="text-gray-800">Tema de la aplicacion</h5>
                        <div class="p-3 d-flex">
                            <input type="hidden" id="tema" name="tema" value="<?php echo $color_tema; ?>">
                            <button class="btn bg-gradient-primary rounded-circle mr-2 " id="btn-color" name="btn-color">&#160&#160&#160&#160</button>
                            <button class="btn bg-gradient-secondary rounded-circle mr-2 " id="btn-color" name="btn-color">&#160&#160&#160&#160</button>
                            <button class="btn bg-gradient-success rounded-circle mr-2" id="btn-color" name="btn-color">&#160&#160&#160&#160</button>
                            <button class="btn bg-gradient-danger rounded-circle mr-2 " id="btn-color" name="btn-color">&#160&#160&#160&#160</button>
                            <button class="btn bg-gradient-warning rounded-circle mr-2 " id="btn-color" name="btn-color">&#160&#160&#160&#160</button>
                            <button class="btn bg-gradient-info rounded-circle mr-2 " id="btn-color" name="btn-color">&#160&#160&#160&#160</button>
                            <button class="btn bg-gradient-dark rounded-circle mr-2 " id="btn-color" name="btn-color">&#160&#160&#160&#160</button>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-12 col-sm-6">
                        <br>
                        <h5 class="text-gray-800">Tamaño de fuente</h5>
                        <select name="fuente" id="fuente" class="form-control w-25">
                            <option value="16" <?php echo ($fuente == 16 ? 'selected' : ''); ?>>16</option>
                            <option value="18" <?php echo ($fuente == 18 ? 'selected' : ''); ?>>18</option>
                            <option value="20" <?php echo ($fuente == 20 ? 'selected' : ''); ?>>20</option>
                            <option value="22" <?php echo ($fuente == 22 ? 'selected' : ''); ?>>22</option>
                        </select>
                    </div>
                </div>
                <input type="submit" id="btn-submit" class="btn btn-success mt-5" value="Guardar cambios">
            </div>
            <div class="tab-pane fade" id="home" role="tabpanel" aria-labelledby="home-tab">
                <div class="row">
                    <div class="col-12 col-sm-6">
                        <br>
                        <h5 class="text-gray-800">Personalizá tu ticket de venta</h5>
                        <br>
                        <div>
                            <input type="checkbox" id="direccion" name="direccion" checked>
                            <label for="direccion"> Agregar direccion</label>
                        </div>
                        <div>
                            <input type="checkbox" id="telefono" name="telefono" checked>
                            <label for="telefono"> Agregar telefono</label>
                        </div>
                        <div class="d-inline-flex mt-3" style="flex-direction: column;">
                            <label> Leyenda del ticket</label>
                            <textarea name="ticket_leyenda" id="ticket_leyenda" cols="40" rows="4" required><?php echo $ticket_leyenda; ?></textarea>
                        </div>
                    </div>

                    <div class="col-12 col-sm-6 text-center">
                        <div class="p-3">
                            <h5 class="text-gray-800"><i class="fas fa-ticket-alt"></i> Vista previa</h5>
                            <hr class="sidebar-divider d-none d-md-block">
                            <div>
                                <div class="panel">
                                    <div class="embed-responsive embed-responsive-4by3" style="width:100%; height: 340px;">
                                        <div class="clearfix" id="loader" hidden>
                                            <div class="spinner-border float-center position-absolute" style="top: 150px; z-index: 20;" role="status">
                                                <span class="sr-only">Loading...</span>
                                            </div>
                                        </div>
                                        <iframe class="embed-responsive-item" id="vista_ticket" src="">
                                        </iframe>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <input type="submit" id="btn-submit" class="btn btn-success" value="Guardar cambios">
            </div>
            <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">
                <div class="row" style="justify-content: space-between;">
                    <div class="col-12 col-sm-4">
                        <br>
                        <h5 class="text-gray-800">Personalizar moneda</h5>

                        <div class="mt-4">
                            <label>Simbolo de la moneda</label>
                            <select name="moneda" id="moneda" class="form-control">
                                <?php foreach ($monedas as $moneda) { ?>
                                    <option value="<?php echo $moneda['simbolo'] ?>" <?php echo ($moneda['simbolo'] == $simbolo ? 'selected' : '') ?>><?php echo $moneda['simbolo'] ?></option>
                                <?php } ?>
                            </select>
                        </div>

                        <div class="mt-3">
                            <label>Número de decimales</label>
                            <input type="number" name="nro_decimales" id="nro_decimales" class="form-control" min="1" max="5" value="<?php echo $nro_decimales ?>" required>
                        </div>

                        <div class="mt-3">
                            <label>Separador de miles</label>
                            <input type="text" name="miles" id="miles" class="form-control" value="<?php echo $separador_miles ?>" required>
                        </div>

                        <div class="mt-3">
                            <label>Separador de decimales</label>
                            <input type="text" name="decimales" id="decimales" class="form-control" value="<?php echo $separador_decimales ?>" required>
                        </div>
                    </div>

                    <div class="col-12 col-sm-6 text-center justify-content-right">
                        <div class="p-3">
                            <h5 class="text-gray-800"><i class="fas fa-ticket-alt"></i> Vista previa</h5>
                            <hr class="sidebar-divider d-none d-md-block">
                            <div>
                                <div class="panel">
                                    <div class="embed-responsive embed-responsive-4by3" style="width:100%; height: 340px;">
                                        <div class="clearfix" id="loader" hidden>
                                            <div class="spinner-border float-center position-absolute" style="top: 150px; z-index: 20;" role="status">
                                                <span class="sr-only">Loading...</span>
                                            </div>
                                        </div>
                                        <iframe class="embed-responsive-item" id="vista_ticket" src="">
                                        </iframe>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <input type="submit" id="btn-submit" class="btn btn-success" value="Guardar cambios">
            </div>
        </div>
        <hr class="sidebar-divider d-none d-md-block">
    </form>

</div>
</div>

<script>
    $(document).ready(function() {
        mostrarTicket(1);
        $(document).on('click', '#btn-color', function(event) {
            event.preventDefault();
            let color = event.currentTarget.classList[1];

            $('#tema').val(color);
            $('#accordionSidebar')[0].classList.remove($('#accordionSidebar')[0].className.split(' ').pop())
            $('#accordionSidebar')[0].classList.add(color);
        })

        $('#fuente').on('change', function(event) {
            let tamaño = `font-size: ${this.value}px;`;

            $('#page-top')[0].removeAttribute('style');
            $('#page-top')[0].setAttribute('style', tamaño);
        })

        $('#direccion,#telefono,#ticket_leyenda,#moneda,#miles,#decimales,#nro_decimales').on('change', function(event) {
            $("[id='loader']")[0].hidden = false;
            $("[id='loader']")[1].hidden = false;

            $('#page-top').css('pointer-events', 'none');

            mostrarTicket(0);

            setTimeout(() => {
                mostrarTicket(1);

                $('#page-top').css('pointer-events', '');

                $("[id='loader']")[0].hidden = true;
                $("[id='loader']")[1].hidden = true;

            }, 500, []);
        })
    });

    function devolverDatos() {
        let direccion = ($('#direccion').is(":checked") ? 1 : 0);
        let telefono = ($('#telefono').is(":checked") ? 1 : 0);
        let ticket_leyenda = $('#ticket_leyenda').val();

        let moneda = $(`#moneda`).val();
        let nro_decimales = $('#nro_decimales').val();
        let decimales = $('#decimales').val();
        let miles = $('#miles').val();

        console.log(ticket_leyenda);

        return `${direccion}/${telefono}/${moneda}/${ticket_leyenda}/${nro_decimales}/'${decimales}'/'${miles}'`;
    }

    function mostrarTicket(mostrar) {
        let iframes = $("[id='vista_ticket']");
        if (mostrar == 1) {
            iframes[0].setAttribute('src', "<?php echo base_url() . "/configuracion/ticketVistaPrevia/"; ?>" + devolverDatos())
            iframes[1].setAttribute('src', "<?php echo base_url() . "/configuracion/ticketVistaPrevia/"; ?>" + devolverDatos())
        } else {
            iframes[0].setAttribute('src', '');
            iframes[1].setAttribute('src', '');
        }
    }
</script>