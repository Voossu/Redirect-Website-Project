<div class="content">
    <div class="logo"></div>
    <form class="create" action="<?=$_DATA['action']?>" method="<?=$_DATA['method']?>">
        <input type="url" name="<?=$_DATA['fields']['url']['name']?>">
        <input type="reset" value="Clear">
        <input type="submit" value="Compress">
    </form>

    <? if (!empty($_DATA['last_compress'])) { ?>
        <div class="compress">
            <label for="compress">Your last compressed link:</label>
            <input type="text" value="<?=$_DATA['last_compress']?>" id="compress" disabled>
        </div>

    <? } ?>

</div>