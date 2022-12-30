<!-- Navbar -->
<?php if($session->get('tema') == 1): ?>
    <nav class="main-header navbar navbar-expand navbar-white navbar-light bg-light">
  <?php elseif($session->get('tema') == 2): ?>
    <nav class="main-header navbar navbar-expand navbar-white navbar-light bg-light">
  <?php elseif($session->get('tema') == 3): ?>
    <nav class="main-header navbar navbar-expand navbar-dark navbar-danger bg-light">
  <?php elseif($session->get('tema') == 4): ?>
    <nav class="main-header navbar navbar-expand navbar-dark navbar-info bg-light">
  <?php endif; ?>
    <!-- Left navbar links -->
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="#" style="margin-top: -10px; color: #212529"><i class="fas fa-bars"></i></a>
      </li>
    </ul>
    
    <ul class="navbar-nav ml-auto">
      <?php if($session->get('tema') == 1): ?>
		<li class="nav-item" style="font-size: 20px; font-weight: bold; color: #212529">
			<?= $session->get('xFant') ?>
		</li>
	  <?php elseif($session->get('tema') == 2): ?>
		<li class="nav-item" style="font-size: 20px; font-weight: bold; color: #212529">
			<?= $session->get('xFant') ?>
		</li>
	  <?php elseif($session->get('tema') == 3): ?>
		<li class="nav-item" style="font-size: 20px; font-weight: bold; color: #212529">
			<?= $session->get('xFant') ?>
		</li>
	  <?php elseif($session->get('tema') == 4): ?>
		<li class="nav-item" style="font-size: 20px; font-weight: bold; color: #212529">
			<?= $session->get('xFant') ?>
		</li>
	  <?php endif; ?>
    </ul>

    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">
      <li class="nav-item">
        <a class="nav-link" href="/login/logout" style="margin-top: -10px; color: #212529">
          Sair
          <i class="fas fa-sign-out-alt"></i>
        </a>
      </li>
    </ul>
  </nav>
  <!-- /.navbar -->