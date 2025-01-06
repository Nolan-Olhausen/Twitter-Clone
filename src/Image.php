<!--
/****************************************************************************************************
 *
 * @file:    Image.php
 * @author:  Nolan Olhausen
 * @date: 2024-04-5
 *
 * @brief:
 *      This file is the handler for images. It takes the image from the user and uploads it to an S3 bucket.
 *
 ****************************************************************************************************/
-->

<?php
    require('vendor/autoload.php');
    // this will simply read AWS_ACCESS_KEY_ID and AWS_SECRET_ACCESS_KEY from env vars

    class Image {
    
        public $name;
        public $tmp_name;
        public $new_name;
        public $type;
        public $extension;

        public function __construct($img , $post = null) {
            
            $this->name =$img['name'];
            $this->tmp_name =$img['tmp_name'];

            $this->extension = pathinfo($this->name)['extension'];

            $this->type = $this->extension;
            
            if ($post != null) {
                $this->new_name = 'post-' .  uniqid() . '.' . $this->extension ; 
            } else {
                $this->new_name = 'user-' .  uniqid() . '.' . $this->extension ;
            }
        }
            
        public function uploadImg() {
            list($width, $height) = getimagesize($this->tmp_name);
            $validImg = false;
            // Define maximum dimensions for the resized image
            $maxWidth = 1080; // Change according to your requirements
            $maxHeight = 1080; // Change according to your requirements

            // Calculate the aspect ratio
            $aspectRatio = $width / $height;

            // Calculate new dimensions while preserving aspect ratio
            if ($width > $height) {
                $newWidth = $maxWidth;
                $newHeight = $maxWidth / $aspectRatio;
            } else {
                $newWidth = $maxHeight * $aspectRatio;
                $newHeight = $maxHeight;
            }
            // Create a new image resource with the new dimensions
            $newImage = imagecreatetruecolor($newWidth, $newHeight);
            if($this->extension == 'png') {
                if(is_file($this->tmp_name) && mime_content_type($this->tmp_name) == 'image/png'){
                    $source = imagecreatefrompng($this->tmp_name);
                    $validImg = true;
                }else{
                    return false;
                }
                
            }
            if ($this->extension == 'jpg' || $this->extension == 'jpeg') {
                if(is_file($this->tmp_name) && (mime_content_type($this->tmp_name) == 'image/jpg' || mime_content_type($this->tmp_name) == 'image/jpeg')){
                    $source = imagecreatefromjpeg($this->tmp_name);
                    $validImg = true;
                }else{
                    return false;
                }
                
            }

            if($validImg == true) {
                // Resize the image
                imagecopyresampled($newImage, $source, 0, 0, 0, 0, $newWidth, $newHeight, $width, $height);
                $newImagePath = $this->new_name;
                if($this->extension == 'png') {
                    imagepng($newImage, $newImagePath, 7);
                }
                if ($this->extension == 'jpg' || $this->extension == 'jpeg') {
                    imagejpeg($newImage, $newImagePath, 75);
                }
                $newImagePath = $this->new_name;
                $s3 = new Aws\S3\S3Client([
                    'version'  => 'latest',
                    'region'   => 'us-west-2',
                ]);
                $bucket = getenv('S3_BUCKET_NAME')?: die('No "S3_BUCKET" config var in found in env!');
                $s3->putObject([
                    'Bucket' => $bucket,
                    'Key' => $this->new_name,
                    'SourceFile' => $this->new_name,
                ]);
                return true;
            }
            
        }
    }

?>