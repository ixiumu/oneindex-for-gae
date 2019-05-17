<?php

function time_elapsed_string($datetime, $full = false) {
    $now = new DateTime;
    $ago = new DateTime;

    $ago->setTimestamp($datetime);
    $diff = $now->diff($ago);

    $diff->w = floor($diff->d / 7);
    $diff->d -= $diff->w * 7;

    $string = array(
        'y' => 'year',
        'm' => 'month',
        'w' => 'week',
        'd' => 'day',
        'h' => 'hour',
        'i' => 'minute',
        's' => 'second',
    );
    foreach ($string as $k => &$v) {
        if ($diff->$k) {
            $v = $diff->$k . ' ' . $v . ($diff->$k > 1 ? 's' : '');
        } else {
            unset($string[$k]);
        }
    }

    if (!$full) $string = array_slice($string, 0, 1);
    return $string ? implode(', ', $string) . ' ago' : 'just now';
}
?><!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Index of <?php echo urldecode($path);?></title>
    <style>
    body{
        color:#999;
        font-size:14px;
    }
    a{
        text-decoration: none;
        color:#333;
    }
    a:hover {
        text-decoration: underline;
    }
    a:active, a:hover {
        outline-width: 0;
    }
    table.files{
        width:100%;
        margin-right: auto;
        margin-left: auto;
        border-collapse: collapse;
        border-spacing: 0;
    }
    table.files td {
        border-top: 1px solid #eaecef;
        line-height: 20px;
        padding: 6px 3px;
    }
    table.files tbody tr:first-child td {
        border-top: 0;
    }
    table.files td.icon {
        padding-left: 10px;
        padding-right: 2px;
        width: 17px;
    }
    table.files td .css-truncate {
        display: inline-block;
        max-width: 400px;
        overflow: hidden;
        text-overflow: ellipsis;
        vertical-align: top;
        white-space: nowrap;
    }
    table.files td.size {
        max-width: 42px;
    }
    table.files td.age {
        padding-right: 10px;
        text-align: right;
        white-space: nowrap;
        width: 125px;
    }
    </style>
</head>
<body>

<h1>Index of <?php echo urldecode($path);?></h1>

<table class="files js-navigation-container js-active-navigation-container">
<tbody>
<?php if($path != '/'):?>
    <tr class="up-tree js-navigation-item navigation-focus" aria-selected="true">
        <td></td>
        <td><a rel="nofollow" title="Go to parent directory" class="js-navigation-open" href="<?php echo get_absolute_path($root.$path.'../');?>">..</a></td>
        <td></td>
        <td></td>
    </tr>
<?php endif;?>
<?php if (!$items):?>
    <tr class="warning include-fragment-error">
        <td class="icon"><svg class="octicon octicon-alert" viewBox="0 0 16 16" version="1.1" width="16" height="16" aria-hidden="true"><path fill-rule="evenodd" d="M8.893 1.5c-.183-.31-.52-.5-.887-.5s-.703.19-.886.5L.138 13.499a.98.98 0 0 0 0 1.001c.193.31.53.501.886.501h13.964c.367 0 .704-.19.877-.5a1.03 1.03 0 0 0 .01-1.002L8.893 1.5zm.133 11.497H6.987v-2.003h2.039v2.003zm0-3.004H6.987V5.987h2.039v4.006z"></path></svg></td>
        <td class="content" colspan="3">Failed to load directory list.</td>
    </tr>
<?php else:?>
<?php foreach((array)$items as $item):?>
<?php if(!empty($item['folder'])):?>
    <tr class="js-navigation-item" aria-selected="false">
        <td class="icon">
            <svg aria-label="directory" class="octicon octicon-file-directory" viewBox="0 0 14 16" version="1.1" width="14" height="16" role="img"><path fill-rule="evenodd" d="M13 4H7V3c0-.66-.31-1-1-1H1c-.55 0-1 .45-1 1v10c0 .55.45 1 1 1h12c.55 0 1-.45 1-1V5c0-.55-.45-1-1-1zM6 4H1V3h5v1z"></path></svg>
        </td>
        <td class="content">
            <span class="css-truncate css-truncate-target"><a class="js-navigation-open" title="<?php echo $item['name'];?>/" href="<?php echo get_absolute_path($root.$path.rawurlencode($item['name']));?>"><?php echo $item['name'];?>/</a></span>
        </td>
        <td class="size">
            <span class="css-truncate css-truncate-target"><?php echo onedrive::human_filesize($item['size']);?></span>
        </td>
        <td class="age">
            <span class="css-truncate css-truncate-target"><time-ago datetime="<?php echo date("Y-m-dTH:i:s\Z", $item['lastModifiedDateTime']);?>" title="<?php echo date("Y-m-d H:i", $item['lastModifiedDateTime']);?>"><?php echo time_elapsed_string($item['lastModifiedDateTime']);?></time-ago></span>
        </td>
    </tr>
<?php else:?>
    <tr class="js-navigation-item" aria-selected="false">
        <td class="icon">
            <svg aria-label="file" class="octicon octicon-file" viewBox="0 0 12 16" version="1.1" width="12" height="16" role="img"><path fill-rule="evenodd" d="M6 5H2V4h4v1zM2 8h7V7H2v1zm0 2h7V9H2v1zm0 2h7v-1H2v1zm10-7.5V14c0 .55-.45 1-1 1H1c-.55 0-1-.45-1-1V2c0-.55.45-1 1-1h7.5L12 4.5zM11 5L8 2H1v12h10V5z"></path></svg>
        </td>
        <td class="content">
            <span class="css-truncate css-truncate-target"><a class="js-navigation-open" title="<?php echo $item['name'];?>" href="<?php echo get_absolute_path($root.$path).rawurlencode($item['name']);?>"><?php echo $item['name'];?></a></span>
        </td>
        <td class="size">
            <span class="css-truncate css-truncate-target"><?php echo onedrive::human_filesize($item['size']);?></span>
        </td>
        <td class="age">
            <span class="css-truncate css-truncate-target"><time-ago datetime="<?php echo date("Y-m-dTH:i:s\Z", $item['lastModifiedDateTime']);?>" title="<?php echo date("Y-m-d H:i", $item['lastModifiedDateTime']);?>"><?php echo time_elapsed_string($item['lastModifiedDateTime']);?></time-ago></span>
        </td>
    </tr>
<?php endif;?>
<?php endforeach;?>
<?php endif;?>
</tbody>
</table>
</body>
</html>
