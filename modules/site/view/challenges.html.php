<?php defined('BORDAMEX') || exit;

/**
 *=======================================================
 *  BORDAMEX Project
 *-------------------------------------------------------
 * @author Gilmer Franco <gil2017.com@gmail.com>
 *=======================================================
 * @Description Vista de foro
 *
 *
 */

require Core::view('head', 'core');
?>

<!-- Header -->
<?php require Core::view('menu', 'core'); ?>
<!-- / Header -->

<!-- Body -->
<<section id="dailyChallenge" class="grey darken-4">
    <div class="container">
        <div class="row">
            <div class="col s12">
                <h2 class="white-text center-align">Reto del Día</h2>
            </div>
            <div class="col s12" style="">
                <div class="card-panel grey darken-3 white-text" style="overflow: auto;overflow: auto;border: solid 1px #6f6f6f;border-radius: 16px; background: #4242423b !important;">
                    <h4 class="center-align"><?php echo $challenge['title'] ?></h4>
                    <div>
                        <?php echo $challenge['description'] ?>
                    </div>

                    <br><br>
                    <hr>
                    <p><strong>Recompensa:</strong> <?php echo  $challenge['reward'] ?></p>
                </div>
            </div>
        </div>
    </div>
    </section>



    <!-- Footer -->
    <?php require Core::view('footer', 'core'); ?>
    <!-- / Footer -->