<?php

if (isset($_GET['search']['arrival'])) {
    $_SESSION['arrival'] = $_GET['search']['arrival'];
}

if (isset($_GET['search']['departure'])) {
    $_SESSION['depart'] = $_GET['search']['departure'];
}

$arrival="";
if (!empty($_SESSION['arrival'])) {
    $arrival = date('m/d/Y', strtotime($_SESSION['arrival']));
}

$depart="";
if (!empty($_SESSION['depart'])) {
    $depart = date('m/d/Y', strtotime($_SESSION['depart']));
}

$nights = (strtotime($depart) - strtotime($arrival)) / 86400;

$adults="";
if (!empty($_GET['search']['Adults'])) {
    $adults=$_GET['search']['Adults'];
}
if (!empty($_GET['obj']['Adults'])) {
    $adults=$_GET['obj']['Adults'];
}

$children="";
if (!empty($_GET['search']['Children'])) {
    $children=$_GET['search']['Children'];
}
if (!empty($_GET['obj']['Children'])) {
    $children=$_GET['obj']['Children'];
}

$pets="";
if (!empty($_GET['search']['Pets'])) {
    $pet=$_GET['search']['Pets'];
}
if (!empty($_GET['obj']['Pets'])) {
    $pets=$_GET['obj']['Pets'];
}

$type="";
if (isset($_GET['search']['type'])) {
    $_SESSION['type']=$_GET['search']['type'];
}

if (isset($_SESSION['type'])) {
    $type=$_SESSION['type'];
}

$sleeps="";
if (isset($_GET['search']['sleeps'])) {
    $_SESSION['sleeps']=$_GET['search']['sleeps'];
}

if (isset($_SESSION['sleeps'])) {
    $sleeps=$_SESSION['sleeps'];
}

$view="";
if (isset($_GET['search']['view'])) {
    $_SESSION['view']=$_GET['search']['view'];
}

if (isset($_SESSION['view'])) {
    $view=$_SESSION['view'];
}

$location="";
if (isset($_GET['search']['location'])) {
    $_SESSION['location']=$_GET['search']['location'];
}

if (isset($_SESSION['location'])) {
    $location=$_SESSION['location'];
}

$bedrooms="";
if (isset($_GET['search']['bedrooms'])) {
    $_SESSION['bedrooms']=$_GET['search']['bedrooms'];
}

if (isset($_SESSION['bedrooms'])) {
    $bedrooms=$_SESSION['bedrooms'];
}

$area="";
if (isset($_GET['search']['area'])) {
    $_SESSION['area']=$_GET['search']['area'];
}

if (isset($_SESSION['area'])) {
    $area=$_SESSION['area'];
}

$bathrooms="";
if (isset($_GET['search']['bathrooms'])) {
    $_SESSION['bathrooms']=$_GET['search']['bathrooms'];
}

$searchoptions=$vrp->searchoptions();

if (!empty($vrp->searchParams)) {
    $searchParams = $vrp->searchParams;
}

if (!empty($searchoptions->attrs)) {
    $chunkedAmenities = array_chunk($searchoptions->attrs, 5);
}

if (isset($_GET['search']['meta'])) {
   $meta = $_GET['search']['meta'];
}

$city = "";
if (isset($_GET['search']['city'])) {
    $_SESSION['city'] = $city = $_GET['search']['city'];
}

if ($_GET['xd']) {
    die(var_dump($data));
}

$customMeta = [
    'petsFriendly' => 'Pet Friendly',
    'featured_pool' => 'Pool'
];

$priceRange = ['daily', 0, 10000];
if (!empty($_GET['search']['price'])) {
    $priceRange = explode('-', $_GET['search']['price']);
}