    <!-- Footer -->

    <footer class="sticky-footer bg-white">
        <div class="container my-auto">
            <div class="copyright text-center my-auto">
                <span>Copyright &copy; Sanchez Matias <?php echo date('Y'); ?></span>
            </div>
            <div>
                <a href="http://facebook.com/" target="_blank">Facebook</a>
                &middot;
                <a href="http://facebook.com/" target="_blank">WebSite</a>
            </div>
        </div>
    </footer>
    <!-- End of Footer -->

    </div>
    <!-- End of Content Wrapper -->

    </div>
    <!-- End of Page Wrapper -->

    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>

   
    <script>
        $(document).ready(function() {
            $("#dataTable").DataTable({
                destroy: true,
                sDom: 'lrtip',
                "language": {
                    "url": "//cdn.datatables.net/plug-ins/1.10.15/i18n/Spanish.json"
                },
                //muestro el ultimo ingresado
                "ordering": false,
                "info": false
            });
        });
   
        $('#modal-confirma').on('show.bs.modal', function(e) {
            $(this).find('.btn-ok').attr('href', $(e.relatedTarget).data('href'));
        });

        $(document).ready(function() {
            if ("<?php echo session()->res; ?>" == 'ok') {
                $(".toast").toast('show');
            }
        });
    </script>


    </body>

    </html>