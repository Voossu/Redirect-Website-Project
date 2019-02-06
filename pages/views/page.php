<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title><?=$_DATA['title']?></title>

    <link rel="stylesheet" href="<?=HOME_URL?>/res/css/style.css">

</head>
<body>

<header>
    <div class="head-menu">
        <? if (isset($_DATA['logo']) && $_DATA['logo'] == true) { ?>
            <a href="" class="logo"></a>
        <? } ?>
        <? foreach ($_DATA['menu'] as $item) { ?>
            <? if (isset($item['is_active'])) { ?>
                <a href="<?=$item['href']?>" class="active"><?=$item['title']?></a>
            <? } else { ?>
                <a href="<?=$item['href']?>"><?=$item['title']?></a>
            <? } ?>
        <? } ?>
    </div>
</header>
<?=$_DATA['content']?>
<footer>
    <div class="data">
        <div class="copyright">
            © 2016 ReURL
        </div>
        <div class="author">
            <img src="<?=HOME_URL?>/res/img/author-logo.png" alt="author logo" class="author-logo">
        </div>
    </div>
</footer>
<script>
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','https://www.google-analytics.com/analytics.js','ga');

  ga('create', 'UA-80174691-1', 'auto');
  ga('send', 'pageview');

</script>
</body>
</html>