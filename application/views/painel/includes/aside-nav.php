
<?php $this->load->view('painel/includes/header'); ?>

<!-- Sidebar -->
<div class="bg-light border-right" id="sidebar-wrapper">
  <div class="sidebar-heading">Painel Central de estágio</div>
  <div class="list-group list-group-flush">
    <a target="_blank" href="<?php echo base_url(); ?>" class="list-group-item list-group-item-action bg-light">Ver página</a>
    <a href="<?php echo base_url('noticia'); ?>" class="list-group-item list-group-item-action bg-light">Listagem</a>
    <a href="<?php echo base_url('setup/config') ?>" class="list-group-item list-group-item-action bg-light">Configurações</a>
    <a href="<?php echo base_url('setup/logout') ?>" class="list-group-item list-group-item-action bg-light">Sair</a>
  </div>
</div>
<!-- /#sidebar-wrapper -->

<!-- Page Content -->
<div id="page-content-wrapper">
  <nav class="navbar navbar-expand-lg navbar-light bg-light border-bottom">
    <button class="btn btn-default" id="menu-toggle">
      <span class="navbar-toggler-icon"></span>
    </button>
  </nav>
<div class="container-fluid">
