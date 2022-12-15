<?php
/**
 * Unit Print Page Template based on original Unit page
 *
 * @package VRPConnector
 * @since 2.0.1
 */

global $vrp;
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

?>

<style>
    <?php require 'css/css.css'; ?>
    @media print, screen {
        .abe #calendar table {
            width: 40% !important;
        }

        .abe #calendar td, .abe #calendar th {
            border: none;
            padding: 4px !important;
        }

        .abe #calendar table {
            width: 48% !important;
        }

        .abe-amen-name {
            margin: 0px;
            min-width: 30%;
            width: 30% !important;
        }
    }
</style>

<div class="abe">
    <div class="abe-container">

        <div class="abe-row">
            <div class="abe-column">
                <h1 class="unit-title"><?= esc_html( $data->Name ) ?></h1>
            </div>
        </div>

        <div class="abe-row">
            <div class="abe-icons"> 
                <span><?= $data->Bedrooms; ?> <i class="fas fa-bed"></i> Bedrooms</span>  
                <span><?= $data->Bathrooms; ?> <i class="fas fa-bath"></i> Bathrooms</span>
                <span><?= $data->Sleeps; ?> <i class="fas fa-user-friends"></i> Sleeps</span>
                <span><?= $data->City; ?></span>
            </div>
        </div>

        <hr>

        <div class="abe-row">
            <div class="abe-colum">
                <img src="<?= $data->photos[0]->thumb_url  ?>">
            </div>
        </div>

        <hr>

        <div class="abe-row">
            <div class="abe-column">
                <p><?= (nl2br($data->Description) ) ?></p>
            </div>
        </div>

        <hr>

        <div id="amenities">
            <ul class="abe-column">
                <?php foreach ($data->attributes as $amenity) : ?>
                    <li class="abe-amen-name">
                        <?php echo esc_html( $amenity->name ); ?>
                    </li>
                <?php endforeach; ?>
            </ul>
        </div>

        <hr>

        <div id="calendar">
            <div class="abe-container">
                <div class="abe-row">
                    <div class="abe-column">
                    <?php if (!empty($data->rates)) : ?>
                        <?php echo wp_kses_post( vrp_calendar( $data->avail, 12, $data->rates ) ); ?>
                    <?php else: ?>
                        <?php echo wp_kses_post( vrp_calendar( $data->avail, 12 ) ); ?>
                    <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>

        <hr>

    </div>
</div>
