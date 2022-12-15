<?php
/**
 * [vrpResultsSearchForm] Template
 * 
 * @package VRPConnector
 */
global $vrp;
require 'assets/setupvars.php';

$hiddenFields = [];
$customMeta = [];
?>

<form method="GET" action="<?php bloginfo('url'); ?>/vrp/search/results/" class="abe-flex-form" id="abe-results-search">
<div class="abe-column group">
    <div class="abe-column">
        <div id="abe-filters-activator" class="button button-outline"><i class="fas fa-sliders-h"></i> Filters</div>
    </div>

    <div class="abe-filters-wrapper abe-row">
        <?php require 'assets/filters.php'; ?>
    </div>

    <div class="abe-column">
        <input type="text" name="search[arrival]" id="arrival" value="<?php echo $arrival; ?>" placeholder="Arrival">
    </div>

    <div class="abe-column">
        <input type="text" name="search[departure]" id="depart" value="<?php echo $depart; ?>" placeholder="Departure">
    </div>
</div>
<div class="abe-column group">

    <div class="abe-column">
        <select name="search[Adults]">
            <option selected="selected" value="">Adults</option>
            <option value="">Any</option>
            <?php foreach (range(2, $searchoptions->maxsleeps) as $v) : ?>
                <option value="<?= $v; ?>"
                    <?= $adults == $v ? "selected" : ""; ?>
                ><?= $v; ?> Adults</option>
            <?php endforeach; ?>
        </select>
    </div>

    <div class="abe-column">
        <select  name="search[Children]">
            <option selected="selected" value="">Children</option>
            <option value="">Any</option>
            <?php foreach (range(2, $searchoptions->maxsleeps) as $v) : ?>
                <option value="<?= $v; ?>"
                    <?= $children == $v ? "selected" : ""; ?>
                ><?= $v; ?> Children</option>
            <?php endforeach; ?>
        </select>
    </div>

    <input type="hidden" name="showmax" value="true">
    <input type="hidden" name="search[sort]" value="Name">
    <input type="hidden" name="search[order]" value="ASC">

    <div class="abe-column">
        <input type="submit" name="propSearch" value="Search">
    </div>
</div>
</form>
