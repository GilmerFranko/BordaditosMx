/**
 *-------------------------------------------------------/
 * @file        static/js/custom.js                      \
 * @package     One V                                     \

 * @Description Archivo relacionado con acciones generales
 *
 *
 * NOTA: archivo posiblemente particionado en un futuro
 */



 /** OCULTAR NAVEGACIÓN AL BAJAR, MOSTRAR AL SUBIR **/
var prevPosition = window.pageYOffset;
$(window).scroll(function() {
  var nowPosition = window.pageYOffset;
  if (prevPosition > nowPosition) {
    $('.nav-fixed').css('top', '0');
  } else {
    $('.nav-fixed').css('top', '-56px');
  }
  prevPosition = nowPosition;
});

 /** INICIALIZAR TODOS LOS MODALES MATERIALIZE */
/** Inicializa las imagenes materialbox */
(function ($) {
  $(function () {

        //initialize all modals
    $('.modal').modal();

    $('select').formSelect();

        //now you can open modal from code
        //$('#modal1').modal('open');

        //or by click on trigger
        //$('.trigger-modal').modal();

    }); // end of document ready

  $('.materialboxed').materialbox();


})(jQuery); // end of jQuery name space

/** ./OCULTAR NAVEGACIÓN AL BAJAR, MOSTRAR AL SUBIR **/

// PREDEFINIR VARIABLE NOTICIAS
var news = getCookie('news').split(',');
/*if (typeof newsHTML !== 'undefined') {
    var news = getCookie('news').split(',');
    var arrayNews = JSON.parse(newsHTML);
    var htmlNews = '';
    var newC = 0;
    if (arrayNews != 'undefined') {
        //htmlNews += '<div class="new card-panel blue lighten-4 blue-text text-darken-4 flow-text center-align carousel carousel-slider center" style="margin-bottom: 0;">';
        arrayNews.forEach(function(object) {
            if (news.indexOf(object.id) == -1) {
                htmlNews += '<a class="carousel-item grey darken-3 white-text" id="new' + object.id + '" href="#textNew' + newC + '"><p id="textNew' + newC + '" class="flow-text w90">' + object.content + '<button class="waves-effect btn-flat close" onclick="closeNew(' + object.id + ');"><i class="material-icons">close</i></button></p></a>';
                ++newC;
            }
        });
        //htmlNews += '</div>';

        // Comprobar si hay alguna noticia que mostrar
        if (newC > 0) {
            // Crear contenido en HTML
            $('header').append(htmlNews).css('margin-top', '-7px');
            // Pre-ajustar el tamaño
            $('.new.carousel.carousel-slider').css('height', 'auto');
            // Ocultar contenido en HTML
            $('header .new').hide();

            // Mostrar contenido en HTML
            $('header .new').slideDown(1000, function() {
                // Auto-ajustar el tamaño al contenido
                $('.new.carousel.carousel-slider').css('height', ($('#textNew0').height() + 20));
            });
        }
    }
  }*/

var stop = false; // PARAR CARGA DE NOTICIAS

/** EJECUTAR CUANDO EL DOCUMENTO ESTÉ LISTO **/
//document.addEventListener('DOMContentLoaded', function() {
$(document).ready(function() {

    // EVITAR TRADUCIR ICONOS, NOMBRES, PAGINACIÓN, ETC.
  $('i.material-icons, .shout-like, .shout-comment, .pagination').addClass('notranslate');

  $('.autodisabled').click(function() {
    $(this).addClass('disabled');
  });

    // INICIAR SIDENAV
  $('.sidenav').sidenav({
        menuWidth: 300, // Default is 300
        edge: 'left', // Choose the horizontal origin
        closeOnClick: false, // Closes side-nav on <a> clicks, useful for Angular/Meteor
        draggable: true, // Choose whether you can drag to open on touch screens
        preventScrolling: true,
      });


    // DROPDOWN (BOTON DESPLEGABLE)
  $('.dropdown-trigger').dropdown({
        //autoTrigger: true,
    coverTrigger: false,
        //hover: true,
  });
    // BOTON FLOTANTE
  $('.fixed-action-btn').floatingActionButton();
    // COLLAPSIBLE
  $('.collapsible').collapsible({
    accordion: true,
  });
    // MATERIALBOX (MOSTRAR IMAGEN PANTALLA COMPLETA)
  $('.materialboxed').materialbox();

    /**
     * PAGINAS
     *
     */

  if (global.page_c == 'homeMember') {
    $('.carousel').carousel({
      fullWidth: true,
      numVisible: 4,
        //indicators: true
        noWrap: true, // No volver al principio al finalizar
        onCycleTo: function(idNew) {
            //idNew = idNew.toString();
            //idNew = idNew.substring(idNew.length - 1, idNew.length);
            //$('.new.carousel.carousel-slider').css('height', ($('#textNew' + idNew).height() + 20));
        },
      });
  }

    // REGISTRO

  if (global.page_c == 'membersRegister') {
    $('.modal').modal();
    $('#btnModalAge').click();

    $('#btnAge').click(function() {
      if($('#indeterminate-checkbox').prop('checked') == false )
      {
        window.location.href = 'https://www.google.com/search?q=dibujos';
      }
    });
  }

  if (global.page_c == 'memberLogin') {
    $('.modal').modal();
  }

    /**
     *
     * SHOUTS
     *
     */

  // Seleccionamos el elemento `div` con el ID "performance-data"
  $( "#performance-data" ).click(function() {
  // Ocultamos el elemento usando el método `hide()` de jQuery
    $(this).hide();
  });

});


/**
 *
 * FUNCIONES EXTRA
 *
 */

// IR HACIA URL
function goToUrl(url) {
  window.location.href = url;
}


// OBTENER COOKIES
function getCookie(key = 'uuid') {
  var name = key + '=';
  var sep = document.cookie.split(';');
  for (var i = 0; i < sep.length; i++) {
    var k = sep[i];
    while (k.charAt(0) == ' ') k = k.substring(1);
    if (k.indexOf(name) == 0) return k.substring(name.length, k.length);
  }
  return '';
}

// GENERAR ENLACE DE DESCARGA DIRECTA Y COPIARLO AL NAVEGADOR
function getDirectLink() {
    // CAMBIAR ENLACE DE LA DESCARGA
  var link = global.url + '/index.php?app=shouts&section=download&shout=' + shoutID + '&img=' + shoutImg + '&token=' + token + '&session=' + session;
  var inputTemp = $('<input id="directLink" type="text">').val(link).appendTo('#modalBuy').select();
  var copied = document.execCommand('copy');
  if (copied == true) {
    swal.fire('','Enlace copiado al portapapeles','');
  }
  $('#directLink').remove();
}


function showAlert(data)
{
  swal.fire(data[0],data[1],data[2])
}



    // Función para formatear el tiempo restante
function formatTimeAgo(diff) {
  var string = {
    'y': 'año',
    'm': 'mes',
    'w': 'semana',
    'd': 'día',
    'h': 'hora',
    'i': 'minuto',
    's': 'segundo',
  };

  var result = [];
  for (var key in string) {
    if (diff[key]) {
      result.push(diff[key] + ' ' + string[key] + (diff[key] > 1 ? 's' : ''));
    }
  }

  return result.length ? result.join(', ') : 'Hace unos segundos';
}

// OBTENER NOTIFICACIONES
function getNotifications(action = 'open') {
  var sidenavNots = document.querySelector('#sidenav-notifications');
  var instances = M.Sidenav.init(sidenavNots, { 'edge': 'right' });
  var instance = M.Sidenav.getInstance(sidenavNots);

  if(action == 'open')
  {
        // CARGAR NOTIFICACIONES
    $.post(global.url + '/index.php?app=members&section=notifications', 'ajax=true', function(a) {
      success: {
                // SI SE HA HECHO LIKE
        if (a.charAt(0) == '1') {
          $('#sidenav-notifications').html(a.substring(2));
          $('#notsCount').text('0');
          instance.open();
        } else {
          swal.fire('',a.substring(2),'');
        }
      }
    });
  }
  else
  {
        // OCULTAR NOTIFICACIONES
    instance.close();
    instance.destroy();
  }
}




