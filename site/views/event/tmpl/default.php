<?php
/**
 * @package     NYCCEvents
 * @subpackage  com_nyccevents
 *
 * @copyright   Copyright (C) 2016 Steve Binkowski.  All Rights Reserved.
 * @license     Commercial License Only
 */


// No direct access to this file
defined('_JEXEC') or die('Restricted access');

$doc = JFactory::getDocument();
// Add datatables
$doc->addScript("https://cdn.datatables.net/v/dt/dt-1.10.12/fh-3.1.2/datatables.min.js");
$doc->addScript('/media/com_nyccevents/js/nycc-base.js');
$doc->addScript('/media/com_nyccevents/js/venue-table-filter.js');
$doc->addScriptDeclaration("jQuery(function(\$) { \$('.nycc-datatable').DataTable({paging:false,dom:'t',scrollY:'250px',scrollCollapse:true, search:{regex:true}}); });");
$doc->addStyleSheet("https://cdn.datatables.net/v/dt/dt-1.10.12/fh-3.1.2/datatables.min.css");

$item = $this->item;
?>
<div class="nycchess-item-detail-container">
  <div class="nycchess-item-detail-title"><?php echo htmlentities($item->name, ENT_QUOTES); ?></div>
  <?php if ($item->image_path) { ?>
  <div class="nycchess-item-detail-image"><img src="/<?php echo $item->image_path; ?>" alt="<?php
    echo $item->name; ?>" /></div><?php } ?>
  <div class="nycchess-item-detail-short-description"><?php
    echo htmlentities($item->short_description, ENT_QUOTES);
    ?></div>
  <div class="nycchess-item-detail-primary-location"><?php
    echo htmlentities($this->item->location->name, ENT_QUOTES);
    ?></div>
  <div class="nycchess-item-detail-long-description"><?php
    echo $item->long_description;
    ?></div>
  <?php if (count($this->all_locations)) { ?>
  <div class="nycchess-item-detail-locations">
    <h3>Locations</h3>
    <ul class="nycchess-item-detail-location-list">
    <?php
    foreach ($this->all_locations as $key=>$value) {
      echo "<li>$value</li>";
    }
    ?>
    </ul>
  </div>
  <?php }
  if (count($this->venues_by_rate['_all'])) { ?>
  <div class="nycchess-item-detail-venues">
    <h3>Venues</h3>
    <div class="nycchess-item-detail-venue-filters">
      <span class="venue-filter venue-filter-all">All</span>
      <span class="venue-filter venue-filter-week">Full Week</span>
      <span class="venue-filter venue-filter-extended">Extended</span>
      <span class="venue-filter venue-filter-extended">VIP</span>
    </div>
    <div class="filter-text"></div>
    <table class="nycc-datatable table-venue-list" id="venue-register-list">
      <thead>
      <tr>
        <th>Location</th>
        <th>Date</th>
        <th>Availability</th>
      </tr>
      </thead>
      <tbody>
      <?php
      foreach ($this->venues_by_rate['_all'] as $key=>$venue) {
        $all_rates = array();
        foreach ($venue->rates as $key2 => $rate) {
          $all_rates[$rate->rate_label] = true;
        }
        $these_rates = array_unique(array_keys($all_rates));
        sort($these_rates, SORT_NATURAL); ?>
        <tr>
          <td><?php echo $venue->location_name; ?></td>
          <td><?php echo date("Y-m-d", $venue->event_date); ?></td>
          <td><?php echo implode(', ', $these_rates); ?></td>
        </tr>
      <?php } ?>
      </tbody>
    </table>
  </div>
  <?php } ?>
</div>