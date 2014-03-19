<?php
/**
 *
 *
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @since         1.3.0
 * @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
 */
namespace UploadPack\View\Helper;

use Cake\View\Helper;

class UploadHelper extends Helper {

    public $helpers = array('Html');

    public function uploadImage($data, $path, $options = array(), $htmlOptions = array())
    {
        $options += array('urlize' => false);
        return $this->output($this->Html->image($this->uploadUrl($data, $path, $options), $htmlOptions));
    }

    public function uploadLink($title, $data, $field, $urlOptions = array(), $htmlOptions = array())
    {
        $urlOptions += array('style' => 'original', 'urlize' => true);
        return $this->Html->link($title, $this->uploadUrl($data, $field, $urlOptions), $htmlOptions);
    }

    public function uploadUrl($data, $field, $options = array())
    {
        $options += array('style' => 'original', 'urlize' => true);
        list($model, $field) = explode('.', $field);
        if(is_array($data)){
            if(isset($data[$model])){
                if(isset($data[$model]['id'])){
                    $id = $data[$model]['id'];
                    $filename = $data[$model][$field.'_file_name'];
                }
            } elseif(isset($data['id'])){
                $id = $data['id'];
                $filename = $data[$field.'_file_name'];
            }
        }

        if(isset($id) && !empty($filename)){
            $settings = UploadBehavior::interpolate($model, $id, $field, $filename, $options['style'], array('webroot' => ''));
            $url = isset($settings['url']) ? $settings['url'] : $settings['path'];
        } else {
            $settings = UploadBehavior::interpolate($model, null, $field, null, $options['style'], array('webroot' => ''));
            $url = isset($settings['default_url']) ? $settings['default_url'] : null;
        }

        return $options['urlize'] ? $this->Html->url($url) : $url;
    }

    /**
     * Returns appropriate extension for given mimetype.
     *
     * @param string $mime Mimetype
     * @return void
     * @author Bjorn Post
     */
    public function extension($mimeType = null)
    {
        $knownMimeTypes = array(
            'gif' => 'image/gif',
            'jpe' => 'image/jpeg', 
			'jpeg' => 'image/jpeg', 
			'jpg' => 'image/jpeg',
            'png' => 'image/png'
        );

        return array_search($mimeType, $knownMimeTypes);
    }
}
