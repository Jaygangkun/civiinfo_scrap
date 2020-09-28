<?php
$fp_des = fopen('export/totals.csv', 'w');
for($pageindex = 1; $pageindex < 573; $pageindex++){
    $fp_src = fopen('export/'.$pageindex.".csv", "r");
    while(!feof($fp_src)) {
        fwrite($fp_des, fgets($fp_src));
    }
    fclose($fp_src);
}
fclose($fp_des);
echo "Success";
?>