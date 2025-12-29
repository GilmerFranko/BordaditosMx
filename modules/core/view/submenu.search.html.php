<?php defined('BORDAMEX') || exit;

/**
 *=======================================================
 *  BORDAMEX Project
 *-------------------------------------------------------
 * @author Gilmer Franco <gil2017.com@gmail.com>
 *=======================================================
 *
 * @Description Archivo que incluye el sub menu de busqueda
 *
 *
 */

// Carga todos los foros
$forums_search = loadClass('forums/f_forums')->getAllForums();

// Carga todos los foros
$subforums_search = loadClass('forums/subforums')->getAllSubforums();

$forum_id = isset($_GET['forum_id']) ? $_GET['forum_id'] : '';

$subforum_id = isset($_GET['subforum_id']) ? $_GET['subforum_id'] : '';

$age_from = isset($_GET['age_from']) ? $_GET['age_from'] : '';

$age_to = isset($_GET['age_to']) ? $_GET['age_to'] : '';

$words = isset($_GET['words']) ? $_GET['words'] : '';

$order_by = isset($_GET['order_by']) ? $_GET['order_by'] : '';/*
?>

<form class="d-flex justify-content-center align-items-center search-bar menu-search" action="<?= gLink('forums/view.searches') ?>">
  <!-- Select 1 -->
  <select id="search-category" class="form-select me-2" name="forum_id">
    <option selected value="">Selecciona</option>
    <?php foreach ($forums_search['data'] as $forum_search) : ?>
      <option value="<?= $forum_search['id'] ?>" <?php if ($forum_id == $forum_search['id']) echo 'selected' ?>><?= $forum_search['name'] ?></option>
    <?php endforeach; ?>
  </select>

  <!-- Select 2 -->
  <select id="search-subforum" class="form-select me-2" name="subforum_id">
    <option value="">En toda España</option>
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

  <!-- Input de búsqueda -->
  <input type="text" name="words" class="form-control me-2" placeholder="¿Qué buscas?" value="<?= $words ?>">

  <!-- Select para ordenar por fecha -->
  <select class="form-select me-2" name="order_by">
    <option value="">Orden por fecha</option>
    <option value="asc" <?php if ($order_by == 'asc') echo 'selected' ?>>Más recientes</option>
    <option value="desc" <?php if ($order_by == 'desc') echo 'selected' ?>>Más antiguos</option>
  </select>

  <!-- Botón de búsqueda -->
  <button type="submit" class="btn btn-submenu"><i class="material-icons">search</i>Buscar</button>
</form>


<style>
  .search-bar {
    background-color: unset;
    padding: 10px;
    display: flex;
    justify-content: center;
    margin-bottom: 18px;
  }

  .search-bar form {
    display: flex;
    align-items: center;
    justify-content: space-between;
    width: 100%;
    max-width: 1000px;
  }

  .btn-submenu {
    background-color: var(--primary-200);
    padding: 8px 20px;
    border: none;
    border-radius: 5px;
    cursor: pointer;
    display: flex;
    transition: background-color 0.3s ease;
  }

  .btn-submenu:hover {
    background-color: var(--primary-300);
  }

  @media (max-width: 768px) {
    .search-bar form {
      flex-wrap: wrap;
    }

    .form-select,
    .form-control,
    .btn-primary {
      width: 100%;
    }

    .form-select {
      display: none !important;
    }
  }
</style>
*/ ?>


<!-- Main Content -->
<form class="d-flex justify-content-center align-items-center search-bar menu-search" action="<?= gLink('forums/view.searches') ?>">
  <div class="container my-4">
    <!-- Search Section -->
    <div class="search-container mb-4">
      <h1 class="text-white mb-3"><strong>Explora las comunidades</strong></h1>
      <p class="text-primary-light mb-4">Encuentra las mejores discusiones y comparte conocimiento</p>

      <div class="row g-3 sub-search-container">
        <div class="col-md-3">
          <select class="form-select" name="subforum_id">
            <option value="" selected disabled>Selecciona una sección</option>
            <?php foreach ($forums_search['data'] as $forum_search) : ?>
              <option value="<?= $forum_search['id'] ?>" <?php if ($forum_id == $forum_search['id']) echo 'selected' ?>><?= $forum_search['name'] ?></option>
            <?php endforeach; ?>
          </select>
        </div>
        <div class="col-md-5">
          <input type="search" class="form-control" placeholder="¿Qué buscas?" name="words" value="<?= $words ?>">
        </div>
        <div class="col-md-3">
          <select class="form-select me-2" name="order_by">
            <option value="">Orden por fecha</option>
            <option value="asc" <?php if ($order_by == 'asc') echo 'selected' ?>>Más recientes</option>
            <option value="desc" <?php if ($order_by == 'desc') echo 'selected' ?>>Más antiguos</option>
          </select>
        </div>
        <div class="col-md-1">
          <button type="submit" class="form-select" style="border: none !important;!i;!;background: none;color: white;"><i class="material-icons">search</i></button>
        </div>
      </div>
    </div>
  </div>
</form>

<style>
  .navbar {
    background-color: var(--primary) !important;
  }

  .btn-register {
    background-color: var(--accent-color);
    color: white;
    border: none;
  }


  .category-icon {
    color: var(--primary);
    font-size: 1.5rem;
    margin-right: 10px;
  }

  .search-container {
    background-color: var(--primary);
    padding: 2rem;
    border-radius: 8px;
  }

  .see-all {
    color: #00a896;
    text-decoration: none;
  }

  .join-section {
    background-color: #e8f4e5;
    padding: 2rem;
    text-align: center;
    border-radius: 8px;
  }

  .sub-search-container {}
</style>

<script>
  const forums_s = <?= json_encode($forums_search) ?>;
  const subforums_s = <?= json_encode($subforums_search) ?>;

  $(document).ready(function() {
    // Maneja el cambio en la categoría
    $('#search-category').on('change', function() {
      const selectedForum = $(this).val();
      const $subforumSelect = $('#search-subforum');

      // Limpia el select de subforos
      $subforumSelect.empty();

      // Filtra y agrega las subforos correspondientes a la categoría seleccionada
      $subforumSelect.append('<option value="">En toda España</option>');
      // Filtra y agrega las subforos correspondientes a la categoría seleccionada
      subforums_s.data.forEach(function(subforum) {
        if (subforum.forum_id == selectedForum) {
          $subforumSelect.append('<option value="' + subforum.id + '">' + subforum.name + '</option>');
        }
      });
    });
  })
</script>