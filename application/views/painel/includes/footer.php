</div>
    </div>
    <!-- DatePicker -->
  

  </div>
  <!-- /#wrapper -->
  <script src="<?php echo base_url('assets/painel/vendor/bootstrap/js/bootstrap.bundle.min.js'); ?>"></script>

  <!-- Jquery para insserção de multiplos arquivos -->
  <script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
  <script src="<?php echo base_url('assets/js/arquivos.js') ?>" ></script>

  

  <!-- Menu Toggle Script -->
  <script>
    $("#menu-toggle").click(function(e) {
      e.preventDefault();
      $("#wrapper").toggleClass("toggled");
    });
  </script>

</body>

</html>
