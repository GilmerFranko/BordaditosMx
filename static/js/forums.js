/**
 * Script que controla el comportamiento de los hilos, secciones y foros
 * 
 * @author Gilmer Franco <gil2017.com@gmail.com>
 */

$(document).ready(function() {
  
  // Usar delegación de eventos para manejar los clics en los botones de favoritos
  $(document).on('click', '.favoriteBtn', function() {
    addFavorite(this);
  }); 
})

function addFavorite(button)
{
  
    // Obtener el ID del hilo
    var threadId = $(button).data('thread-id');

    // Obtener el elemento HTML del botón
    var $this = $(button);

    // Realizar la solicitud AJAX para marcar como favorito
    $.ajax({
      url: global.url + '/index.php?app=forums&section=threads.actions', // URL del controlador que maneja la solicitud
      type: 'POST',
      data: {
        ajax: true,
        do: 'addFavorite',
        thread_id: threadId
      },
      dataType: 'json',
      success: function(response) {
        // Verificar si la solicitud fue exitosa
        if (response.status) {
          // Alternar el estado de favorito
          $this.toggleClass('isFavorite');

          // Cambiar el contenido del botón según el estado
          if ($this.hasClass('isFavorite')) {
            $this.html('<i class="em em-heart" aria-role="presentation" aria-label="STAR"></i> Favorito');
            $this.attr('title', 'Pulsa para quitar de favoritos');
          } else {
            $this.html('<i class="em em-star2" aria-role="presentation" aria-label="GLOWING STAR"></i> Favorito');
            $this.attr('title', 'Pulsa para agregar a favoritos');
          }

          // Mostrar notificación
          Toastify({
            text: response.message,
            backgroundColor: "linear-gradient(120deg, #7dd957, #7dd957)",
            className: "info",
            close: true
          }).showToast();
        } else {
          alert('No se pudo agregar a favoritos. Inténtalo de nuevo.');
        }
      },
      error: function() {
        alert('Hubo un error al procesar la solicitud.');
      }
    });

}
