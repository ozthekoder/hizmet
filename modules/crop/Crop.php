<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Crop
 *
 * @author thekoder
 */
class Crop extends Module {
    public $url;
    public $imgInfo;
    public $imgType;
    public function __construct() {
        if(isset($_FILES['avatar']) && !empty($_FILES['avatar']))
        {
            $file = $_FILES['avatar'];
            if($r = move_uploaded_file($file['tmp_name'], 'images/temp/' . $file['name']))
            {
                $this->url = 'images/temp/' . $file['name'];
                $this->imgInfo = getimagesize($this->url);
                $this->imgType = exif_imagetype($this->url);
            }
        }
    }
    
    public function load(){
        if(EventManager::$post['cropped'] == "true")
        {
            $ratio = $this->imgInfo[0] / 258;
            $dst_w = 258;
            $dst_h = 258;
            $dst_x = 0;
            $dst_y = 0;
            $src_x = floatval(EventManager::$post['x']) * $ratio; 
            $src_y = floatval(EventManager::$post['y']) * $ratio; 
            $src_w = floatval(EventManager::$post['w']) * $ratio; 
            $src_h = floatval(EventManager::$post['h']) * $ratio; 
            switch($this->imgType)
            {
                case IMAGETYPE_GIF:
                    $src = imagecreatefromgif($this->url);
                    $dest = imagecreatetruecolor($dst_w, $dst_h);
                    $r = imagecopyresampled ( $dest , $src , $dst_x , $dst_y , $src_x , $src_y , $dst_w , $dst_h , $src_w , $src_h );
                    if($r)
                    {
                        imagegif($dest, 'images/' . $_FILES['avatar']['name']);
                        unlink($this->url);
                        $this->url = 'images/' . $_FILES['avatar']['name'];
                    }
                    break;
                case IMAGETYPE_JPEG:
                    $src = imagecreatefromjpeg($this->url);
                    $dest = imagecreatetruecolor($dst_w, $dst_h);
                    $r = imagecopyresampled ( $dest , $src , $dst_x , $dst_y , $src_x , $src_y , $dst_w , $dst_h , $src_w , $src_h );
                    if($r)
                    {
                        imagejpeg($dest, 'images/' . $_FILES['avatar']['name']);
                        unlink($this->url);
                        $this->url = 'images/' . $_FILES['avatar']['name'];
                        
                    }
                    break;
                case IMAGETYPE_PNG:
                    $src = imagecreatefrompng($this->url);
                    $dest = imagecreatetruecolor($dst_w, $dst_h);
                    $r = imagecopyresampled ( $dest , $src , $dst_x , $dst_y , $src_x , $src_y , $dst_w , $dst_h , $src_w , $src_h );
                    if($r)
                    {
                        imagepng($dest, 'images/' . $_FILES['avatar']['name']);
                        unlink($this->url);
                        $this->url = 'images/' . $_FILES['avatar']['name'];
                    }
                    break;
            }
            
            
            
            $script = '<script type="text/javascript">';
            $script .= 'window.parent.stopCropper({ src: "' . $this->url . '", status:' . $r . '})';
            $script .= '</script>';
            
        }
        else
        {
            $view = new View('crop/templates/Modal.view.php');
        
            $modal = $view->createHTML(array(
                'url' => $this->url,
                'imgInfo' => $this->imgInfo[3]
            ));
            $script = '<script type="text/javascript">';
            $script .= 'window.parent.startCropper(' . json_encode($modal) . ')';
            $script .= '</script>';

            
        }
        return $script;
    }
}
