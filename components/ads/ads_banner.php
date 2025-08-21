<section>
    <div class="container">
        <div class="column">
            <div class="ads">
                <?php if (get_theme_mod($ad.'source')) { ?>
                    <img src="<?=get_theme_mod($ad.'source')?>"/>
                <?php } else { ?>
                    <h2>Espaço reservado para Ads</h2>
                    <p>Você pode customizar esse campo na seção de "Aparência" do seu tema
                    <?php } ?>

            </div>
        </div>
    </div>
</section>