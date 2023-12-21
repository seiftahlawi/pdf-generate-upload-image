<?php

namespace App;

class Helper
{



static function validateImage($mime_type)
    {
            if(in_array($mime_type,['image/jpg','image/jpeg','image/png','image/svg+xml','image/svg','image/gif']))
            {
                return true;
            }

         return false;
    }


static function convertImageToWebP($source, $destination, $quality=80) {
        $extension = pathinfo($source, PATHINFO_EXTENSION);
        if ($extension == 'jpeg' || $extension == 'jpg')
            $image = imagecreatefromjpeg($source);
        elseif ($extension == 'gif')
            $image = imagecreatefromgif($source);
        elseif ($extension == 'png')
            $image = imagecreatefrompng($source);


            imagepalettetotruecolor($image);

        return imagewebp($image, $destination, $quality);

    }




}
