<?php
// Carga todos los foros
$forums_search = loadClass('forums/f_forums')->getAllForums();

// Carga todos los foros
$subforums_search = loadClass('forums/subforums')->getAllSubforums();

$forum_id = isset($_GET['forum_id']) ? $_GET['forum_id'] : '';

$subforum_id = isset($_GET['subforum_id']) ? $_GET['subforum_id'] : '';

$age_from = isset($_GET['age_from']) ? $_GET['age_from'] : '';

$age_to = isset($_GET['age_to']) ? $_GET['age_to'] : '';

$words = isset($_GET['words']) ? $_GET['words'] : '';

$order_by = isset($_GET['order_by']) ? $_GET['order_by'] : '';


?>
<style>
  .menu-search {
    background-color: #F8F1F7;
    margin: 10px 0;
    font-size: 0.9rem;
    color: var(--primary-dark);
    text-align: left;
    padding: 6px 0 0 0;
    border-right: 4px solid #F0DCED;
    border-bottom: 2px solid #F0DCED;
    border-radius: 5px 0 5px 5px;

    .form-select,
    .form-control {
      border: var(--bs-border-width) solid var(--primary);
      color: var(--primary-dark);
      font-weight: bold;
      font-size: 0.8rem !important;
      /* Tamaño de fuente reducido */
      padding: 0rem 0.5rem !important;
      /* Espaciado reducido */
    }

    .form-select {
      height: 20px;
      /* Ajusta la altura del select */
      border-radius: 2px !important;
    }

    .form-control {
      height: 20px;
      /* Ajusta la altura del input */
      border-radius: 2px !important;
    }

    .row>* {
      padding: 0 2px !important;
    }
  }



  .search-form .btn {
    font-size: 0.875rem;
    /* Reduce el tamaño de fuente del botón */
    padding: 0rem 0.75rem;
    /* Reduce el padding del botón */
  }

  .search-form .input-group {
    width: 100%;
  }

  .search-form .form-row {
    margin-bottom: 0.5rem;
    /* Reduce el espacio entre filas */
  }

  .search-header {
    margin-bottom: 10px;
    width: 200px;
    font-size: 20px;
  }
</style>

<div class="menu-search mt-4">
  <!--<div class="search-header">
    Buscador
  </div>-->
  <span style="color: var(--bs-gray-800); font-weight:500;">BUSCAR ANUNCIO</span>
  <br><br>
  <div class="container">
    <form class="search-form" action="<?= gLink('forums/view.searches') ?>">
      <div class="row">
        <!-- Select de Categorías -->
        <div class="col col-sm-5 col-md-4 ">
          <select id="search-category" name="forum_id" class="form-select">
            <option selected value="">Categorías</option>
            <?php foreach ($forums_search['data'] as $forum_search) : ?>
              <option value="<?= $forum_search['id'] ?>" <?php if ($forum_id == $forum_search['id']) echo 'selected' ?>><?= $forum_search['name'] ?></option>
            <?php endforeach; ?>

          </select>
        </div>
        <!-- Select de Subforos -->
        <div class="col col-sm-3 col-md-3 ">
          <select id="search-subforum" name="subforum_id" class="form-select">
            <option selected value="">Subforos</option>
            <?php foreach ($subforums_search['data'] as $subforum_search)
            {
              // Si se ha seleccionado un foro 
              if ($forum_id and $forum_id == $subforum_search['forum_id'])
              {
                // Muestra las subforos de ese foro y si la ubicación coincide con la ubicación seleccionada se marca como seleccionada
                echo '<option value="' . $subforum_search['id'] . '" ' . ($subforum_id == $subforum_search['id'] ? 'selected' : '') . '>' . $subforum_search['name'] . '</option>';
              }
            } ?>

          </select>
        </div>
      </div>
      <div class="row" style="margin: -5px;">
        <!-- Input de Palabras -->
        <div class="col col-sm-8 col-md-8">
          <div class="input-group" style="display: flex; align-items: center;">
            <label for="searh-words" style="margin: 15px;">Que contenga las palabras</label>
            <input id="searh-words" type="text" class="form-control" name="words" value="<?= $words ?>">
          </div>
        </div>
      </div>
      <div class="row" style="align-items: center;">
        <!-- Select Edad Desde -->
        <div class="col col-sm-2 col-md-2">
          <select name="age_from" class="form-select">
            <option selected value="">Desde</option>
            <option value="18" <?php if ($age_from == 18) echo 'selected' ?>>18</option>
            <option value="25" <?php if ($age_from == 25) echo 'selected' ?>>25</option>

          </select>
        </div>
        <!-- Select Edad Hasta -->
        <div class="col col-sm-2 col-md-2">
          <select name="age_to" class="form-select">
            <option selected value="">Hasta</option>
            <option value="30" <?php if ($age_to == 30) echo 'selected' ?>>30</option>
            <option value="40" <?php if ($age_to == 40) echo 'selected' ?>>40</option>

          </select>
        </div>
        <!-- Select Ordenar por Fecha -->
        <div class="col col-sm-4 col-md-4">
          <select name="order_by" class="form-select">
            <option selected value="">Ordenar por fecha</option>
            <option value="asc" <?php if ($order_by == 'asc') echo 'selected' ?>>Ascendente</option>
            <option value="desc" <?php if ($order_by == 'desc') echo 'selected' ?>>Descendente</option>
          </select>
        </div>

        <!-- Botón Buscar -->
        <div class="col col-sm-2 col-md-4" style="display:flex;justify-content: flex-end;">
          <a href="javascript:void(0)" onclick="$(this).closest('form').submit()"><img src="<?= $config['images_url'] . '/button-search.png' ?>" class="" alt="Buscar" /></a>
        </div>
      </div>
    </form>
  </div>
</div>

<script>
  const forums_s = <?= json_encode($forums_search) ?>;
  const subforums_s = <?= json_encode($subforums_search) ?>;

  $(document).ready(function() {
    // Maneja el cambio en la categoría
    $('#search-category').on('change', function() {
      const selectedForum = $(this).val();
      const $subforumSelect = $('#search-subforum');

      $subforumSelect.empty();

      // Filtra y agrega las subforos correspondientes a la categoría seleccionada
      subforums_s.data.forEach(function(subforum) {
        if (subforum.forum_id == selectedForum) {
          $subforumSelect.append('<option value="' + subforum.id + '">' + subforum.name + '</option>');
        }
      });
    });
  })
</script>