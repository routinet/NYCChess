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

$item = $this->item->data;
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
  <?php if (is_array($item->venues) && count($item->venues)) { ?>
  <div class="nycchess-item-detail-locations">
    <h3>Locations</h3>
    <ul class="nycchess-item-detail-location-list">
    <?php
    foreach ($item->venues as $key=>$venue) {
      echo '<li>' . $venue->location_name . '</li>';
    }
    ?>
    </ul>
  </div>
  <?php } ?>
</div>
<pre><?php echo var_export($this->item,1); ?></pre>