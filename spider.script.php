<?php
$fp = fopen('package.txt', 'r');
// $fpcsv = fopen("package.csv", 'w');

$sum = $hascatalog = 0;

// fputcsv($fpcsv, ["packagename", "brief", "QQ", "MI", "appchina"]);

$header = ['packagename', 'category', 'brief'];

$filelist = [
    'qq' => [
        'worker' => function($page, &$line) {
            if (preg_match_all('/id="J_DetCate">(.*?)<\/a>/', $page, $reg)) {
                $line['category'] = $reg[1][0];
            }
            if (preg_match_all('/<div class="det-app-data-info">(.*?)<\/div>/', $page, $reg)) {
                $line['brief'] = $reg[1][0];
            }
        }
    ],
    'mi' => [
        'worker' => function($page, &$line) {
            if (preg_match('/<p class="special-font action"><b>.*?<\/b>(.*?)<span/', $page, $reg)) {
                $line['category'] = $reg[1];
            }
            if (preg_match('/<h3>.*?<\/h3><p class="pslide">([\S\s]*?)<\/p>/', $page, $reg)) {
                $line['brief'] = $reg[1];
            }
        }
    ],
    'appchina' => [
        'worker' => function($page, &$line) {
            if (preg_match('/<p class="art-content">分类：(.*?)<\/p>/', $page, $reg)) {
                $line['category'] = $reg[1];
            }
            if (preg_match('/<h2 class="part-title">[\s\S]*?<p class="art-content">([\s\S]*?)<\/p>/', $page, $reg)) {
                $line['brief'] = $reg[1];
            }
        }
    ],
    'wandoujia' => [
        'worker' => function($page, &$line) {
            if (preg_match_all('/data-track="detail-click-appTag">(.*?)<\/a>/', $page, $reg)) {
                $line['category'] = join(',', $reg[1]);
            }
            if (preg_match('/itemprop="description">([\s\S]*?)<\/div>/', $page, $reg)) {
                $line['brief'] = $reg[1];
            }
        }
    ],
    'anzhi' => [
        'worker' => function($page, &$line) {
            if (preg_match_all('/<li>分类：(.*?)<\/li>/', $page, $reg)) {
                $line['category'] = join(',', $reg[1]);
            }
            if (preg_match_all('/<div class="app_detail_infor">[\s\S]*?<p>[\s]*([\s\S]*?)<\/p>/', $page, $reg)) {
                $line['brief'] = $reg[1][0];
            }
        }
    ],
];

foreach ($filelist as $filename => $conf) {
    print $filename."\r\n";
    $count = 0;
    $fpcsv = fopen($filename.'.csv', 'w');
    fputcsv($fpcsv, $header);
    rewind($fp);
    while (false !== ($pkgname = fgets($fp))) {
        $pkgname = trim($pkgname);
        $line = [];
        foreach ($header as $field) {
            $line[$field] = '';
        }
        $line['packagename'] = $pkgname;
        $filepath = sprintf("package/%s/".$filename, $pkgname);
        if (file_exists($filepath)) {
            $page = file_get_contents($filepath);
            call_user_func_array($conf['worker'], [$page, &$line]);
        }
        $line = array_map(function($e) {
            return iconv("UTF-8", "gb18030", $e);
        }, $line);
        fputcsv($fpcsv, $line);
    }
    fclose($fpcsv);
}
