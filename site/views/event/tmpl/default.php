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
    <form name="nycchess-item-detail-register-venue" method="POST">
      <input type="submit" name="register_venue_submit" value="Register Now!" />
      <h3>Venues</h3>
      <div class="nycchess-item-detail-venue-filters">
        <span class="venue-filter venue-filter-all">All</span>
        <?php
        foreach ($this->all_rates as $key=>$value) {
          $rate_name = preg_replace('/[^a-z0-9]/i', '-', strtolower($value));
          echo '<span class="venue-filter venue-filter-' . $rate_name .
            '">' . htmlentities($value, ENT_QUOTES) . '</span>';
        }
        ?>
      </div>
      <table class="nycc-datatable table-venue-list" id="venue-register-list">
        <thead>
        <tr>
          <th>Location</th>
          <th>Date</th>
          <th>Availability</th>
          <th></th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($this->venues_by_rate['_all'] as $key=>$venue) { ?>
          <tr>
            <td><?php echo $venue->location_name; ?></td>
            <td><?php echo date("Y-m-d", $venue->event_date); ?></td>
            <td><?php echo implode(', ', $venue->getRateLabels()); ?></td>
            <td>
              <input type="checkbox" name="register_venue" class="register-venue-button" value="<?php echo $venue->id; ?>" id="register_<?php echo $venue->id; ?>" /><label for="register_<?php echo $venue->id; ?>" class="register-venue-label">select</label>
            </td>
          </tr>
        <?php } ?>
        </tbody>
      </table>
    </form>
  </div>
  <?php } ?>
</div>