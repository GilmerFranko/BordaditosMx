<?php defined('BORDAMEX') || exit;

/**
 *=======================================================
 *  BORDAMEX Project
 *-------------------------------------------------------
 * @author Gilmer Franco <gil2017.com@gmail.com>
 *=======================================================
 *
 * @Description Se incluyen los archivos necesarios para mostrar la página
 *
 *
 */

/* Se carga el modelo del internauta y se comprueba la sesión */
$session = Core::model('session', 'core');

/** Variables globales */
$extra = Core::model('extra', 'core');
/* Se carga el modelo de la base de datos */
$db = Core::model('db', 'core');
/* ID del usuario */
$m_id = $session->memberData['member_id'];

// Comprueba bbcode
$parser = new JBBCode\Parser();

// Cargar los tags predeterminados (b, i, u, url, img, etc.)
$parser->addCodeDefinitionSet(new JBBCode\DefaultCodeDefinitionSet());

// Definir el BBCode para `color`
$colorCode = new JBBCode\CodeDefinitionBuilder('color', '<span style="color:{option}">{param}</span>');
$parser->addCodeDefinition($colorCode->build());

// Definir el BBCode para `size`
$parser->addCodeDefinition(\JBBCode\CodeDefinition::construct('size', '<span style="font-size:{option}px">{param}</span>', true));

// Definir el BBCode para `font`
$parser->addCodeDefinition(\JBBCode\CodeDefinition::construct("font", '<span style="font-family:{option}">{param}</span>', true));

// Definir el BBCode para `code` con estilos Bootstrap
$codeBuilder = new JBBCode\CodeDefinitionBuilder('code', '<pre><code class="bg-dark text-light p-2 rounded">{param}</code></pre>');
$parser->addCodeDefinition($codeBuilder->build());


// ESTABLECE ZONA HORARIA EN LA QUE SE BASAN LAS PUBLICACIONES
date_default_timezone_set($session->memberData['pp_timezone']);
$extra->db->set_charset('utf8');
$extra->db->query('SET NAMES  "utf8"');
$extra->db->query("SET NAMES 'utf8'");


/* Se comprueba si se puede acceder al sitio */
Core::model('extra', 'core')->checkLoad();

/* Se define el módulo y la sección a cargar
* Si es visitante, muestra home-guest, si no, muestra home-member
*/
$sModule = (isset($_GET['app']) and $_GET['app'] != 'index.php') ? strtolower($_GET['app']) : ($session->is_member ? 'core' : 'core');
$sSection = (isset($_GET['section'])) ? strtolower($_GET['section']) : ($session->is_member ? 'home-guest' : 'home-guest');

// debug
if ($config['debug_mode'] == 1)
{
	error_log($sModule . ' - ' . $sSection);
}

/* Cambia la url si ya existe alguna predefinida */
$extra->setUrl($sModule, $sSection);

$sSection = isset($_GET['area']) ? $sSection . '.' . $_GET['area'] : $sSection;

/* Se comprueba si existe el archivo a cargar */
$sModuleFile = BG_MODS . $sModule . DS . 'controller' . DS . $sSection . '.php';


if (file_exists($sModuleFile))
{
	/* Se comprueba el nivel de acceso */
	require BG_CONF . 'config.level.php';

	/* Se establece el módulo */
	Core::setModule($sModule, $sSection, $config);

	/* Se incluye el controlador del módulo */
	require Core::controller($sSection);

	/* Se incluye la vista del módulo si no es una petición ajax. Si lo es se muestra un error en caso de haberlo - EN REVISIÓN */
	if (!isset($_POST['ajax']))
	{
		/*Mostrar la vista*/
		require Core::view($sSection, '', 'index');
		/*Se incluye archivo controlador javascript de existir*/
		$sModuleFile = BG_MODS . $sModule . DS . 'controller' . DS . $sSection . '.js.php';
		if (file_exists($sModuleFile))
		{
			require $sModuleFile;
		}

		/*Mostrar mensaje de sesion*/
		if (isset($_SESSION['message']))
		{
			echo Core::model('extra', 'core')->getToast();
		}

		/*Mostrar mensaje (con swalfire) de sesion*/
		if (isset($_SESSION['message_s']))
		{
			echo Core::model('extra', 'core')->getSwal();
		}

		/*Mostrar mensaje (con swalfire) de sesion*/
		if (isset($_SESSION['message_ti']))
		{
			echo Core::model('extra', 'core')->getTI();
		}
	}
	else
	{
		//echo Core::model('extra', 'core')->getToast($message);
	}
}
else
{
	require BG_TEMPLATES . 'error' . DS . '404.php';
}
