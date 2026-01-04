<?php defined('BORDAMEX') || exit;

/**
 *=======================================================
 *  BORDAMEX Project
 *-------------------------------------------------------
 * @author Gilmer Franco <gil2017.com@gmail.com>
 *=======================================================
 *
 * @Description Archivo que incluye parte de la cabecera
 */

?>
<!DOCTYPE HTML>

<html lang="es" style="overflow-x: hidden">

<head>
	<?php if ($sModule != 'admin' and $sModule != 'mod')
	{ ?>
		<!-- Google tag (gtag.js) -->
		<script async src="https://www.googletagmanager.com/gtag/js?id=G-DGY33MBNWW"></script>
		<script>
			window.dataLayer = window.dataLayer || [];

			function gtag() {
				dataLayer.push(arguments);
			}
			gtag('js', new Date());

			gtag('config', 'G-DGY33MBNWW');
		</script>
	<?php } ?>
	<!-- Global site tag (gtag.js) - Google Analytics -->
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, user-scalable=yes, initial-scale=1.0, maximum-scale=5.0, minimum-scale=1.0">
	<meta http-equiv="X-UA-Compatible" content="ie=edge">
	<!--jQuery -->
	<script type="text/javascript" src="<?php echo $config['base_url']; ?>/static/js/jquery-3.3.1.min.js"></script>

	<!-- Si esa es el modulo admin, se inyecta el JS de materialize si no se utiliza bootstrap-->
	<script src="<?php echo $config['base_url'] . '/static/js/' . ($sModule == 'admin' ? 'materialize.min.js' : 'bootstrap.min.js'); ?>"></script>

	<!-- Import Toastify.js -->
	<script type="text/javascript" src="<?php echo $config['base_url']; ?>/static/js/toastify.js"></script>
	<!--Custom JS-->
	<!-- Importa estilos solo para modulo admin -->
	<?php if ($sModule == 'admin')
	{ ?>
		<script type="text/javascript" src="<?php echo $config['base_url']; ?>/static/js/custom.js">
		</script>
	<?php } ?>

	<!-- JS Para los foros -->
	<script type="text/javascript" src="<?php echo $config['base_url']; ?>/static/js/forums.js">
	</script>

	<!-- SweetAlert -->
	<script type="text/javascript" src="<?php echo $config['base_url']; ?>/static/js/sweetalert.min.js" />
	</script>
	<title><?php echo isset($page['name']) ? $page['name'] : ucfirst($sModule) . ' - ' . $config['script_name']; ?></title>

	<!--Import Google Icon Font-->

	<link href="<?php echo $config['base_url'] ?>/static/css/materialize-icons.css" rel="stylesheet">

	<!--Import materialize.css or bootstrap-->
	<link rel="stylesheet" href="<?php echo $config['base_url'] . '/static/css/' . ($sModule == 'admin' ? 'materialize.min.css' : 'bootstrap.min.css'); ?>">

	<!-- Import toastify.css -->
	<link type="text/css" rel="stylesheet" href="<?php echo $config['base_url']; ?>/static/css/toastify.css" />

	<!-- Importa estilos generales -->
	<link type="text/css" rel="stylesheet" href="<?php echo $config['base_url']; ?>/static/css/custom.css?r=<?php echo time(); ?>" />
	<!-- Importa estilos solo para modulo admin -->
	<?php if ($sModule == 'admin')
	{ ?>
		<link type="text/css" rel="stylesheet" href="<?php echo $config['base_url']; ?>/static/css/admin.css?r=<?php echo time(); ?>" />
	<?php
		// Importa estilo cuando no es modulo admin 
	}
	else
	{
	?>
		<link type="text/css" rel="stylesheet" href="<?php echo $config['base_url']; ?>/static/css/custom2.css?r=<?php echo time(); ?>" />
	<?php
	}
	?>

	<link href="https://emoji-css.afeld.me/emoji.css" rel="stylesheet">

	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

	<!--Import night.css-->

	<!--<link type="text/css" rel="stylesheet" href="<?php echo $config['base_url']; ?>/static/css/night.css?<?php echo time() ?>" />-->

	<!--Sitio optimizado para moviles-->

	<meta name="viewport" content="width=device-width, initial-scale=1.0" />

	<!-- Favicon -->

	<link rel="shortcut icon" href="<?php echo $config['images_url']; ?>/logo.png">

	<script>
		var global = {

			url: '<?php echo $config['base_url']; ?>',

			page: '<?php echo $page['name']; ?>',

			page_c: '<?php echo isset($page['code']) ? $page['code'] : $sSection; ?>',

			page_n: '<?php echo $page['number']; ?>',

			images: '<?php echo $config['images_url']; ?>'

		};

		var member = {

			id: '<?php echo $session->memberData['member_id']; ?>',

			name: '<?php echo $session->memberData['name']; ?>',

			group: '<?php echo $session->memberData['group_id']; ?>',

			platform: '<?php echo $session->platform; ?>',

		};
	</script>

	<?php if ($session->platform == 'android' || $session->platform == 'app')
	{ ?>

		<style>
			nav a.left,

			nav a.right {

				width: 16.6666666667%;

			}
		</style>

	<?php } ?>

</head>

<body>

	<!-- mostrar preloader solo si no se esta en modo debug -->
	<?php //if($config['debug_mode'] == 0) { 
	?>
	<!--<div class="preloader-background">

			<div class="preloader-wrapper big active">

				<div class="spinner-layer spinner-blue-only">

					<div class="circle-clipper left">

						<div class="circle"></div>

					</div>

					<div class="gap-patch">

						<div class="circle"></div>

					</div>

					<div class="circle-clipper right">

						<div class="circle"></div>

					</div>

				</div>

			</div>

		</div>-->
	<?php //} 
	?>

	<?php
	if ($session->is_member and $sModule == 'admin')
	{
		require Core::view('sidenav', 'core');
	}
	?>


	<!-- Modal de Bootstrap -->
	<div class="modal fade" id="imageModal" tabindex="-1" aria-labelledby="imageModalLabel" aria-hidden="true">
		<div class="modal-dialog modal-dialog-centered">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title" id="imageModalLabel">Vista previa de la imagen</h5>
					<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
				</div>
				<div class="modal-body">
					<img src="" id="modalImage" alt="Descripción ampliada" class="img-fluid">
				</div>
			</div>
		</div>
	</div>

	<script>
		$(document).ready(function() {
			// Escucha el evento de clic en las imágenes con el atributo data-bs-toggle="modal"
			$('img[data-bs-toggle="modal"]').on('click', function() {
				// Obtiene el src de la imagen que fue clickeada
				var imageSrc = $(this).attr('src');

				// Cambia el src de la imagen dentro del modal
				$('#modalImage').attr('src', imageSrc);
			});
		});
	</script>