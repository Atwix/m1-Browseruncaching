<?php
/**
 * Atwix
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Open Software License (OSL 3.0)
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://opensource.org/licenses/osl-3.0.php
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to license@magentocommerce.com so we can send you a copy immediately.

 * @category    Atwix Mod
 * @package     Atwix_Browseruncaching
 * @author      Atwix Core Team
 * @copyright   Copyright (c) 2014 Atwix (http://www.atwix.com)
 * @license     http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */

class Atwix_Browseruncaching_Block_Page_Html_Head extends Mage_Page_Block_Html_Head
{
    protected function _prepareStaticAndSkinElements($format, array $staticItems, array $skinItems,
                                                      $mergeCallback = null)
    {
        $html = parent::_prepareStaticAndSkinElements($format, $staticItems, $skinItems, $mergeCallback);

        if(Mage::getStoreConfig('atwix_browseruncaching/general/enabled') == 1) {
            $ips = Mage::getStoreConfig('atwix_browseruncaching/general/ips');
            if($ips != '' && in_array(Mage::helper('core/http')->getRemoteAddr(), explode(',', $ips)) == false) {
                return $html;
            }
            $salt = md5(time());
            $html = str_replace('.js', '.js?t='.$salt, $html);
            $html = str_replace('.css', '.css?t='.$salt, $html);
        }

        return $html;
    }
}