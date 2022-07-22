
<div class="card-deck" style="padding: 9% 0 10px 6%;">
    <?php foreach ($exercicios as $cate => $exec) :?> 
        <div class="card border-dark mb-3 mr-7" style="max-width: 18rem;">
            <div class="card-header">Categoria <?= $cate ?></div>
            <div class="card-body text-dark">
                <?php foreach($exec as $ex): ?>
                    <p class="card-text"> <?= $nivel ." - " . $ex ?> </p>
                <?php endforeach;?>
            </div>
        </div>
    <?php endforeach;?>
</div>

<script>
    function onReady() {
        // marcação no dropdown
        $('.nav-link').removeClass('active');
        $('.treinos-link').addClass('active');
        //$('#treinos').addClass('active');

        $('.nav-link').click(function() {
            $('.nav-link').removeClass('active');
            $(this).addClass('active');
        });

    }
</script>

