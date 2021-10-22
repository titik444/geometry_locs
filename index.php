<?php

header('Content-Type: application/json; charset=utf-8');

$string = file_get_contents("./data.json");
$json = json_decode($string, true);

foreach($json['features'] AS $i => $features){

    $geometry_locs = [];
    
    foreach($features['geometry']['coordinates'] AS $coordinates){

        foreach($coordinates AS $arr){

            if($features['geometry']['type'] == 'MultiPolygon'){ // MultiPolygon

                foreach($arr AS $subArr){
                    unset($subArr[2]);
                    $subArr = array_reverse($subArr);
                    $geometry_locs[] = implode(',',$subArr);    
                }

            } else { // Polygon
                unset($arr[2]);
                $arr = array_reverse($arr);
                $geometry_locs[] = implode(',',$arr);
            }
        }
    }

    $json['features'][$i]['geometry']['geometry_locs'] = $geometry_locs;
}

echo json_encode($json);
?>