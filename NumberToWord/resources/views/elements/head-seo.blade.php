<?php if(!empty($store)): ?>
<title><?php echo(!empty($seoConfig['title']) ? $seoConfig['title'] : $store['name'].' coupon codes') ?></title>
<meta name="description" content="{{ !empty($seoConfig['desc']) ? $seoConfig['desc'] : (isset($store['head_description'])&&empty($store['head_description']) ? $store['head_description'] : '') }}"/>
<meta property="og:type" content="article" />
<?php if($store['social_image']): ?>
<meta property="og:image" content="<?php echo $store['social_image'] ?>" />
<?php endif; ?>
<?php else: ?>
<title><?php echo(!empty($seoConfig['title']) ? $seoConfig['title'] : '') ?></title>
<meta name="description" content="<?php echo(!empty($seoConfig['desc']) ? $seoConfig['desc'] : '') ?>"/>
<?php endif; ?>

@if (!empty($seoConfig['disableNoindex']) && $seoConfig['disableNoindex'] !='' && $seoConfig['disableNoindex'] != 1 )
    <META NAME="ROBOTS" CONTENT="noindex, noarchive">
@endif
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta charset="UTF-8"/>

<meta name="keywords" content="<?php echo(!empty($seoConfig['keyword']) ? $seoConfig['keyword'] : '') ?>"/>

<!-- FB Share -->
<meta property="og:url"           content="<?php echo "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]"  ?>" />
<meta property="og:title"         content="" />
<meta property="og:description"   content="" />