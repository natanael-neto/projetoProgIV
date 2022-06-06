<script type="text/javascript" src="<?php echo base_url() . 'public/js/jquery/jquery-3.5.1.js' ?>"></script>
<script type="text/javascript" src="<?php echo base_url() . 'public/js/bootstrap/bootstrap.min.js' ?>"></script>
<script type="text/javascript" src="<?php echo base_url() . 'public/js/masked-input/jquery.maskedinput.min.js' ?>"></script>
<script type="text/javascript" src="<?php echo base_url() . 'public/js/maskmoney/jquery.maskMoney.min.js' ?>"></script>

<script>

jQuery(document).ready(function($) { 
    $(".scroll").click(function(event){        
        event.preventDefault();
        $('html,body').animate({scrollTop:$(this.hash).offset().top}, 600);
   });
});

</script>

<script type="text/javascript">
    if (typeof onReady !== "undefined") {
        onReady();
    }
</script>
