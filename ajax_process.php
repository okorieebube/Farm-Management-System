<?php
require_once('lib/library.php');

if(isset($_POST['full-name'])){
    $msg =  $lib->registerOwner($_POST['full-name'],$_POST['email'],$_POST['sex'],$_POST['phone'],$_POST['pass'],$_POST['cpass']);
    print $msg;
}


if(isset($_POST['crop-name'])){
    $msg = $lib->addSingleCrop($_POST['crop-name'],$_POST['location']);
    print $msg;
}

if(isset($_POST['field-name'])){

    $msg = $lib->registerField($_POST['field-name'],$_POST['field-location'],$_POST['size'],$_POST['soil-type'],$_POST['farm-owner']);
    print $msg;
}

if(isset($_POST['farm-id'])){
    $msg = $lib->calcFarmArea($_POST['farm-id']);
    print json_encode($msg);
}

if(isset($_POST['cropid'])){
    $msg = $lib->linkCropToFarm($_POST['linkfarm'],$_POST['linkarea'],$_POST['cropid']);
    print $msg;
}
if(isset($_POST['c-name'])){
    $msg = $lib->completeCropRegistration($_POST['c-id'],$_POST['c-name'],$_POST['plot'],$_POST['status'],$_POST['season'],$_POST['f-date'],$_POST['e-date'],$_POST['e-yield'],$_POST['f-yield']);
    print $msg;
}
if(isset($_POST['task-farm-id'])){
    $msg = $lib->getCropsLinkedToFarm($_POST['task-farm-id']);
    print json_encode($msg);
}
if(isset($_POST['t-name'])){
    if(empty($_POST['workers'])){
        print 'please assign task to workers';
    }else{
        $msg = $lib->createTask($_POST['t-name'],$_POST['category'],$_POST['t-startdate'],$_POST['t-enddate'],$_POST['t-status'],$_POST['incharge'],$_POST['farm-task'],$_POST['crop-task'],$_POST['note'],$_POST['session'],$_POST['workers']);
    print $msg;
    }
}

if(isset($_POST['w-name'])){
    $msg = $lib->registerWorker( $_POST['w-name'],$_POST['w-email'],$_POST['radio1'],$_POST['w-phone'],$_POST['session'] );
    print $msg;
}
if(isset($_POST['m-name'])){
    $msg = $lib->registerMachinery($_POST['m-name'],$_POST['m-category'],$_POST['m-factory'],$_POST['m-year'],$_POST['session']);
    print $msg;
}

if(isset($_POST['f-name'])){
   $msg =  $lib->registerFinance($_POST['f-name'],$_POST['f-category'],$_POST['amount'],$_POST['p-method'],$_POST['session']);
   print $msg;
}


?>