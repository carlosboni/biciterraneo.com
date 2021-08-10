<?php
/**
 * @package     Falang for Joomla!
 * @author      Stéphane Bouey <stephane.bouey@faboba.com> - http://www.faboba.com
 * @license     GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
 * @copyright   Copyright (C) 2010-2017. Faboba.com All rights reserved.
 */

// No direct access to this file
defined('_JEXEC') or die;

?>

<table class="adminlist  table table-striped">
	<?php $i = 0; ?>
	<?php foreach ($this->pluginsInfos as $plugin => $values) : ?>
        <tr class="row<?php echo $i % 2; ?>">
            <th width="180" align="left"><?php echo JText::_($values['title']); ?></th>
            <td><?php
				if ($values['installed'] == 0)
				{ ?>
					<?php if ($this->versionType != 'free')
					//version payate on affiche toujours le  lien
				{ ?>
                    <i class="fa fa-times fa-danger"></i>
                    - <a
                        href="http://www.faboba.com/index.php?option=com_ars&view=release&id=<?php echo $values['ars_id']; ?>"
                        target="_blank" alt="download"><?php echo JText::_('COM_FALANG_DOWNLOAD_PLUGIN_LINK'); ?></a>
				<?php }
				else
					//version gratuite on affiche le lien que pour les plugin gratuit
				{ ?>
					<?php if ($values['type'] == 'paid')
				{
					echo JText::_('COM_FALANG_ONLY_PAID');
				}
				else
				{ ?>
                    <i class="fa fa-times fa-danger"></i>
                    - <a
                        href="http://www.faboba.com/index.php?option=com_ars&view=release&id=<?php echo $values['ars_id']; ?>"
                        target="_blank" alt="download"><?php echo JText::_('COM_FALANG_DOWNLOAD_PLUGIN_LINK'); ?></a>

				<?php } ?>
				<?php } ?>
				<?php }
				else
				{
					if ($values['enabled'] == 1)
					{ ?>
                        <i class="fa fa-check fa-success"></i>
					<?php }
					else
					{ ?>
                        <i class="fa fa-times fa-danger"></i>
					<?php } ?>
                    <span class="version"><?php if (isset($values['version_local'])){echo $values['version_local'];}?> </span>
				<?php } ?>
            </td>
        </tr>
		<?php $i++; ?>
	<?php endforeach; ?>


</table>