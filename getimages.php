<?php
    //PHP SCRIPT: getimages.php
    header("content-type: application/x-javascript");

    //This function gets the file names of all images in the current directory
    //and ouputs them as a JavaScript array
    function returnimages($dirname="./media") {
        $pattern='/\.(jpg|png|jpeg)$/'; //valid image extensions
        $files = array();
        $curimage=0;
        if($handle = opendir($dirname)) {
            while(false !== ($file = readdir($handle))){
                if(preg_match($pattern, $file)){ //if this file is a valid image
                    //Output it as a JavaScript array element
                    echo 'galleryarray['.$curimage.']="media/'.$file .'";';
                    $curimage++;
                }
            }

            closedir($handle);
        }
        return($files);
    }
    echo 'var galleryarray=new Array();'; //Define array in JavaScript

    //Output the array elements containing the image file names
    returnimages();

    // Get the values from xml file
    $xmldata = simplexml_load_file("settings.xml") or die("Failed to load");
    $effects_param_lists = array();
    foreach($xmldata->Effects->children() as $p){
        $tmp_params = array();
        foreach($p->children() as $pp){
            array_push($tmp_params, $pp->getName());

        }
        $effects_param_lists[$p->getName()] = $tmp_params;
        echo 'console.log("'.$p->getName().'");';
    }



    // Get the Slide effect for playing from xml data
    $play_effect = $xmldata->Slideshows->effect;
    echo 'let plyEffect="'.$play_effect.'";';

    // Get the params of Slide effect from xml data
    // Out put params array in Javascript.
    echo 'let effectParams=new Array();';
    $i = 0;
    foreach($xmldata->Effects->{$play_effect}->children() as $p){
        echo 'effectParams["'.$effects_param_lists[(string)$play_effect][$i].'"]='.$p.';';
        $i++;
    }


?>

