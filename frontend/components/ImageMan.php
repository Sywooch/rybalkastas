<?php
namespace frontend\components;

use Imagine\Image\Box;
use Imagine\Image\ImageInterface;
use Imagine\Image\Point;
use yii\base\Component;
use yii\helpers\BaseFileHelper;
use yii\helpers\BaseInflector;
use yii\imagine\Image;

/**
 * @author Denis Volin <denvolin@gmail.com>
 */
class ImageMan extends Component
{

    public $imageFolder;
    public $cacheFolder;
    public $imageFolderUrl;
    public $cacheFolderUrl;
    
    public $watermarks;

    public function load($path, $size = null, $quality = 100, $wm = false, $category = 'common', $crop = false, $expires = 31536000)
    {
        //return 'http://rybalkashop.ru/img'.$path;



        $fileExtension =  pathinfo($path, PATHINFO_EXTENSION);
        if(!in_array($fileExtension, ['gif', 'GIF', 'jpg', 'JPG', 'jpeg', 'JPEG','png', 'PNG','wbmp', 'WBMP','xbm', 'XBM']))return null;
        $fileName =  pathinfo($path, PATHINFO_FILENAME);
        $divname = strtolower(substr(BaseInflector::transliterate($fileName), 0, 2).'/'.$size);
        $cacheFolder = $this->cacheFolder.'/'.$category.'/'.$divname.'/';

        $imageFile = $this->imageFolder.$path;

        $cacheFile = $this->cacheFolder.'/'.$category.'/'.$divname.'/'.$fileName.'.'.$fileExtension;
        $cacheFileUrl = $this->cacheFolderUrl.'/'.$category.'/'.$divname.'/'.$fileName.'.'.$fileExtension;



        if (is_file($cacheFile) && $lastModified = filemtime($cacheFile))
        {
            $expiresIn = $lastModified + $expires;

            if (time() > $expiresIn)
            {
                unlink($cacheFile);
            }
        }

        if (is_file($cacheFile))
        {
            return str_replace(' ', '%20', $cacheFileUrl);;
        }
        if(!is_file($imageFile)){
            $imageFile = $this->imageFolder.'/onDesign.jpg';
            if(!is_file($imageFile)) return null;
        }

        BaseFileHelper::createDirectory(dirname($cacheFile), 0777, true);

        $image = Image::getImagine();
        $newImage = $image->open($imageFile);

        if(!empty($size)){
            $data = explode('x', $size);
            $w = $data[0];
            $h = $data[1];
        } else {
            $w = $newImage->getSize()->getWidth();
            $h = $newImage->getSize()->getHeight();
        }

        if($crop != false){
            $w = $w*2;
            $h = $h*2;
        }


        if($wm != false && isset($this->watermarks[$wm])){
            $newImage->thumbnail(new Box($w, $h));

            $watermark = $image->open($this->watermarks[$wm])->resize($newImage->getSize());

            //$size      = $newImage->getSize();
            //$wSize     = $watermark->getSize();

            //if($size->getWidth() - $wSize->getWidth() <= 0 || $size->getHeight() - $wSize->getHeight() <= 0) {
            //    $watermark->resize(new Box($size->getWidth()/2, $size->getHeight()/2));
            //}

            $size      = $newImage->getSize();
            $wSize     = $watermark->getSize();

            $bottomRight = new Point($size->getWidth() - $wSize->getWidth(), $size->getHeight() - $wSize->getHeight());
            $newImage->paste($watermark, $bottomRight)->save($cacheFile, ['quality'=>$quality]);
        } else {
            $newImage->thumbnail(new Box($w, $h))->save($cacheFile, ['quality'=>$quality]);
        }

        if($crop != false){
            $cropImage = $image->open($cacheFile);
            $targetSize = array('width'=> $w, 'height' => $h);

            $originalSize = $cropImage->getSize();
            $originalWidth = $originalSize->getWidth();
            $originalHeight = $originalSize->getHeight();

            $targetWidth = $targetSize['width'];
            $targetHeight = $targetSize['height'];

            // START resize image to fit the width of height of target Size first
            $resizeToFitWidthRatio = $targetWidth/$originalWidth;
            $image1Width = $originalWidth*$resizeToFitWidthRatio;
            $image1Height = $originalHeight*$resizeToFitWidthRatio;

            $resizeToFitHeightRatio = $targetHeight/$originalHeight;
            $image2Width = $originalWidth*$resizeToFitHeightRatio;
            $image2Height = $originalHeight*$resizeToFitHeightRatio;
            if( $image1Width >= $targetWidth && $image1Height >= $targetHeight ) {
                $cropImage->resize( new Box($image1Width,$image1Height) );
            }else {
                $cropImage->resize( new Box($image2Width,$image2Height) );
            }
            $originalSize = $cropImage->getSize();
            // END resize image to fit the width of height of target Size first

            // START get the cropping point
            $center = new Point\Center($originalSize);
            $centerX = $center->getX();
            $centerY = $center->getY();
            $targetX = $centerX - $targetWidth/2;
            $targetY = $centerY - $targetHeight/2;
            // END get the cropping point

            $cropImage->crop( new Point($targetX, $targetY), new Box($targetWidth, $targetHeight) );

            $cropImage->save($cacheFile, ['quality'=>$quality]);
        }


        return str_replace(' ', '%20', $cacheFileUrl);

    }
}
