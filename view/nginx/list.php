<html>
<head><title>Index of <?php echo urldecode($path);?></title></head>
<body bgcolor="white">
<h1>Index of <?php echo urldecode($path);?></h1><hr><pre><?php if($path != '/'):?><a href="../">../</a>
<?php endif;?>
<?php foreach((array)$items as $item):?>
<?php if(!empty($item['folder'])):?>
<a href="<?php echo get_absolute_path($root.$path.rawurlencode($item['name']));?>"><?php echo $item['name'];?>/</a>                                <?php echo date("Y-m-d H:i:s", $item['lastModifiedDateTime']);?>                   <?php echo onedrive::human_filesize($item['size']);?>

<?php else:?>
<a href="<?php echo get_absolute_path($root.$path).rawurlencode($item['name']);?>"><?php echo $item['name'];?></a>                                <?php echo date("Y-m-d H:i:s", $item['lastModifiedDateTime']);?>                   <?php echo onedrive::human_filesize($item['size']);?>

<?php endif;?>
<?php endforeach;?>
</pre><hr></body>
</html>
