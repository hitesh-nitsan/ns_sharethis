<?php
namespace Nitsan\NsSharethis\Controller;
use TYPO3\CMS\Extbase\Utility\DebuggerUtility as Debug;

/***************************************************************
 *
 *  Copyright notice
 *
 *  (c) 2016
 *
 *  All rights reserved
 *
 *  This script is part of the TYPO3 project. The TYPO3 project is
 *  free software; you can redistribute it and/or modify
 *  it under the terms of the GNU General Public License as published by
 *  the Free Software Foundation; either version 3 of the License, or
 *  (at your option) any later version.
 *
 *  The GNU General Public License can be found at
 *  http://www.gnu.org/copyleft/gpl.html.
 *
 *  This script is distributed in the hope that it will be useful,
 *  but WITHOUT ANY WARRANTY; without even the implied warranty of
 *  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *  GNU General Public License for more details.
 *
 *  This copyright notice MUST APPEAR in all copies of the script!
 ***************************************************************/

/**
 * SharethisController
 */
class SharethisController extends \TYPO3\CMS\Extbase\Mvc\Controller\ActionController
{

    /**
     * action list
     *
     * @return void
     */
    public function listAction()
    {

        $settings = $this->settings;
        
        $protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' || $_SERVER['SERVER_PORT'] == 443) ? "https" : "http";
        
        if($protocol == 'https'){
            $button_JS = 'https://ws.sharethis.com/button/buttons.js';
            $loader_JS = 'https://ss.sharethis.com/loader.js';
        }
        else{
            $button_JS = 'http://w.sharethis.com/button/buttons.js';
            $loader_JS = 'http://s.sharethis.com/loader.js';
        }
            
        $hash_script = '"publisher": "'.$settings['publisher'].'", doNotHash: '.$settings['doNotHash'].' , doNotCopy: '.$settings['doNotCopy'].', hashAddressBar: '.$settings['hashAddressBar'].' ' ;
        
        $main_script = '"publisher": "'.$settings['publisher'].'", "position": "' .$settings['position'].'" , "ad":{"visible": '.$settings['visible'].', "openDelay": '.$settings['openDelay'].' , "closeDelay": '.$settings['closeDelay'].'}';

        $chicklets = ' "chicklets":{"items":['.$settings['items'].']}';

        if($settings['chicklets'] == 1){
            $script = ''.$main_script.','.$chicklets.' ';
        }
        else{
            $script = ''.$main_script.'';
        }

        $GLOBALS['TSFE']->getPageRenderer()->addHeaderData('
            <script type="text/javascript">
                var switchTo5x= true ;
            </script>
            <script type="text/javascript" src="'.$button_JS.'"></script>
            <script type="text/javascript" src="'.$loader_JS.'"></script>
            ');

        $GLOBALS['TSFE']->getPageRenderer()->addFooterData('
            <script type="text/javascript">
                stLight.options({'.$hash_script.'});
            </script> 
            ');

        if($settings['categories'] == 'hoverBar' || $settings['globalSharing'] == 1)
        {
          if($settings['position']=='bottom'){
                $GLOBALS['TSFE']->getPageRenderer()->addFooterData('
                <script>
                    var options={'.$script.'};
                    var st_bar_widget = new sharethis.widgets.sharebar(options);
                </script> ');   
            } else if($settings['position']=='top'){
                $GLOBALS['TSFE']->getPageRenderer()->addFooterData('
                <script>
                    var options={'.$script.'};
                    var st_pulldown_widget = new sharethis.widgets.pulldownbar(options);
                </script> ');
            } else{
                $GLOBALS['TSFE']->getPageRenderer()->addFooterData('
                <script>
                    var options={'.$script.'};
                    var st_hover_widget = new sharethis.widgets.hoverbuttons(options);
                </script>
                ');
            }
        }            
    }
}
		

		