<?php
/**
 * @version     $Id: default.php 21576 2011-06-19 16:14:23Z chdemko $
 * @package     Joomla.Administrator
 * @subpackage  com_checkavet
 * @copyright   Copyright (C) 2005 - 2011 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

// No direct access.
defined('_JEXEC') or die;

$vet = $this->vet;
$vet = CheckavetHelperHtml::clean_blanks($vet);

$imagesrc = file_exists(JPATH_BASE.DS.'images'.DS.'checkavet'.DS.'logos'.DS.$vet['logo']) ?
    $this->baseurl.'/images/checkavet/logos/'.$vet['logo'] : $this->baseurl.'/images/checkavet/logos/logo-unavailable.png';
?>
<div class="result<?php echo $vet['featured'] == 1 ? " featured" : ""; ?>">
    <div class="column1">
        <img src="<?php echo $imagesrc; ?>" alt="<?php echo $vet['name']; ?>" class="logo" />
        <?php 
        if($vet['featured'] == 1) :
            $website = trim($vet['website']);
            if($website != "&nbsp;") 
                echo '<a href="'.$website.'" target="_blank">'.$website.'</a>';
        endif;
		
		echo $vet['rating'];
        ?>
    </div>
    <div class="column2">
        <table>
            <tr>
                <td>Name:</td>
                <td class="right"><?php echo $vet['name']; ?></td>
            </tr>
            <tr>
                <td>Address:</td>
                <td class="right"><?php echo $vet['address1']; ?></td>
            </tr>
            <?php if($vet['address2'] != "&nbsp;") { ?>
            <tr>
                <td></td>
                <td class="right"><?php echo $vet['address2']; ?></td>
            </tr>
            <?php } ?>
            <?php if($vet['address3'] != "&nbsp;") { ?>
            <tr>
                <td></td>
                <td class="right"><?php echo $vet['address3']; ?></td>
            </tr>
            <?php } ?>
			<?php if($vet['town'] != "&nbsp;") { ?>
			<tr>
				<td>Town:</td>
				<td class="right"><?php echo $vet['town']; ?></td>
			</tr>
			<?php } ?>
            <tr>
                <td>County:</td>
                <td class="right"><?php echo $vet['county']; ?></td>
            </tr>
            <tr>
                <td>Postcode:</td>
                <td class="right"><?php echo $vet['postcode']; ?></td>
            </tr>
            <tr>
                <td>Contact Number:</td>
                <td class="right"><?php echo $vet['phone']; ?></td>
            </tr>
            <tr>
                <td>RCVS Accredited:</td>
                <td class="right"><?php echo $vet['accredited']; ?></td>
            </tr>
            <tr>
                <td>24 Hour Service:</td>
                <td class="right"><?php echo $vet['24hour']; ?></td>
            </tr>
        </table>
    </div>
</div>
<hr />