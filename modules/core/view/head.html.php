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
	<meta name="description" content="Tienda online de bordados. En nuestra tienda puedes encontrar una gran variedad de sweters bordados de alta calidad, con diseños exclusivos y materiales de primera clase. Envíos nacional a todo Mexico.">

	<!-- Carga JS dependiendo del modulo -->
	<?php if ($sModule == 'admin'): ?>
		<!--<link rel="stylesheet" href="<?php echo $config['base_url']; ?>/static/dist/css/admin.css">-->
		<link rel="stylesheet" href="<?php echo $config['base_url']; ?>/static/css/materialize.min.css">
		<link rel="stylesheet" href="<?php echo $config['base_url']; ?>/static/css/materialize-icons.css" onload="this.media='all'">
		<link rel="stylesheet" href="<?php echo $config['base_url']; ?>/static/css/admin.css">
		<script src="<?php echo $config['base_url']; ?>/static/js/materialize.min.js"></script>
		<script src="<?php echo $config['base_url']; ?>/static/js/custom.js"></script>
		<script src="<?php echo $config['base_url']; ?>/static/js/admin.js"></script>
	<?php else: ?>
		<link rel="stylesheet" href="<?php echo $config['base_url']; ?>/static/dist/css/public.css">
		<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" onload="this.media='all'">

		<script type="module" src="<?php echo $config['base_url']; ?>/static/dist/js/public.js" defer></script>
	<?php endif; ?>


	<!-- Solo cargar en Pagina de Contacto -->
	<?php if ($sModule == 'site' and $sSection == 'contact'): ?>
		<!-- Import Toastify.js -->
		<script defer type="text/javascript" src="<?php echo $config['base_url']; ?>/static/js/toastify.js"></script>
		<!-- Import toastify.css -->
		<link type="text/css" rel="stylezsheet" href="<?php echo $config['base_url']; ?>/static/css/toastify.css" />
	<?php endif; ?>


	<!-- Titulo -->
	<title><?php echo isset($page['name']) ? $page['name'] : ucfirst($sModule) . ' - ' . $config['script_name']; ?></title>

	<!--Import Google Icon Font-->

	<!-- Importa estilos generales -->
	<link type="text/css" rel="stylesheet" href="<?php echo $config['base_url']; ?>/static/css/custom.css" />
	<!-- Importa estilos solo para modulo admin -->


	<link href="https://emoji-css.afeld.me/emoji.css" rel="stylesheet" onload="this.media='all'">


	<!--Sitio optimizado para moviles-->

	<meta name="viewport" content="width=device-width, initial-scale=1.0" />

	<!-- Favicon -->

	<link rel="shortcut icon" href="<?php echo $config['images_url']; ?>/logo.webp">

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

	<script defer src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js" integrity="sha512-+NqPlbbtM1QqiK8ZAo4Yrj2c4lNQoGv8P79DPtKzj++l5jnN39rHA/xsqn8zE9l0uSoxaCdrOgFs6yjyfbBxSg==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
	<script defer src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>

<body>

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