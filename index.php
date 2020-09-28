<?php
require "vendor/autoload.php";
use PHPHtmlParser\Dom;
ini_set('max_execution_time', 0);
set_time_limit(6000);
ini_set('memory_limit', '-1');
for($pageindex = 572; $pageindex < 573; $pageindex++){
    $dom = new Dom;
    $dom->loadFromUrl("http://civicinfo.bc.ca/people?pn=".$pageindex."&stext=%&type=ss&lgid=+&firstnationid=+&agencyid=+&ministryid=+");
    // echo $dom->outerHtml;       
    
    $lis = $dom->find('ol li');
    $fp = fopen('export/'.$pageindex.'.csv', 'w');
    
    foreach($lis as $li){
        // echo $li->innerHtml;
        $links = $li->find('a');
    
        $title = '';
        $name = '';
        $phone = '';
        $email = '';
    
        if(count($links) >= 2){
            $title = $li->find('a')[0];
            $title = $title->find('b')[0]->text;
            $email = $li->find('a')[1]->text;
        }
        else if(count($links) >= 1){
            $title = $li->find('a')[0]->text;
        }
    
        $html = $li->innerHtml;
        // echo $html; echo "<br><br>";continue;
        $htmls = explode('<br>', $html);
        $htmls = preg_split('/<br[^>]*>/i', $html);
        if(count($htmls) == 4){
            $name = $htmls[1];
            $phone = $htmls[2];
            $phones = explode("Phone:", $htmls[2]);
            if(count($phones) == 2){
                $phone = $phones[1];
            }
            else{
                $phone = $phones[0];
            }
        }
    
        $phone = str_replace("&nbsp;", "", $phone);
        $email = str_replace("&nbsp;", "", $email);
    
        $list = array(
            $title, $name, $phone, $email
        );
    
        fputcsv($fp, $list);
    
    }
    
    fclose($fp);
}

echo "Success";
?>