<?php
/**
 * @version		$Id: default.php 21576 2011-06-19 16:14:23Z chdemko $
 * @package		Joomla.Administrator
 * @subpackage	com_checkavet
 * @copyright	Copyright (C) 2005 - 2011 Open Source Matters, Inc. All rights reserved.
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 */

// No direct access.
defined('_JEXEC') or die;

// Include the component HTML helpers.
JHtml::addIncludePath(JPATH_COMPONENT.'/helpers/html');


$petservice = $this->petservice;
$petservice = CheckavetHelperHtml::clean_blanks($petservice);

$imagesrc = file_exists(JPATH_BASE.DS.'images'.DS.'checkavet'.DS.'logos'.DS.$petservice['logo']) ?
	$this->baseurl.'/images/checkavet/logos/'.$petservice['logo'] : $this->baseurl.'/images/checkavet/logos/logo-unavailable.png';
?>
<div class="result<?php echo $vet['featured'] == 1 ? " featured" : ""; ?>">
	<div class="column1">
		<img src="<?php echo $imagesrc; ?>" alt="<?php echo $petservice['name']; ?>" class="logo" />
		<?php 
        if($petservice['featured'] == 1) :
            $website = trim($petservice['website']);
            if($website != "&nbsp;") 
                echo '<a href="'.$website.'" target="_blank">'.$website.'</a>';
        endif;
        ?>
	</div>
	<div class="column2">
		<table>
			<tr>
				<td>Name:</td>
				<td class="right"><?php echo $petservice['name']; ?></td>
			</tr>
			<tr>
				<td>Address:</td>
				<td class="right"><?php echo $petservice['address1']; ?></td>
			</tr>
			<?php if($petservice['address2'] != "&nbsp;") { ?>
			<tr>
				<td></td>
				<td class="right"><?php echo $petservice['address2']; ?></td>
			</tr>
			<?php } ?>
			<?php if($petservice['address3'] != "&nbsp;") { ?>
			<tr>
				<td></td>
				<td class="right"><?php echo $petservice['address3']; ?></td>
			</tr>
			<?php } ?>
			<?php if($petservice['town'] != "&nbsp;") { ?>
			<tr>
				<td>Town:</td>
				<td class="right"><?php echo $petservice['town']; ?></td>
			</tr>
			<?php } ?>
			<tr>
				<td>County:</td>
				<td class="right"><?php echo $petservice['county']; ?></td>
			</tr>
			<tr>
				<td>Postcode:</td>
				<td class="right"><?php echo $petservice['postcode']; ?></td>
			</tr>
			<tr>
				<td>Contact Number:</td>
				<td class="right"><?php echo $petservice['phone']; ?></td>
			</tr>
		</table>
	</div>
	<hr />
</div>