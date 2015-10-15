<?php

namespace common\helpers;

use yii;
use yii\base\ErrorException;
use yii\helpers\ArrayHelper;
use yii\helpers\FileHelper;
use yii\helpers\Html;
use yii\imagine\Image;
use Imagine\Image\Box;
use Imagine\Image\ManipulatorInterface;

/*
 *
 * use
 * echo \common\helpers\ThumbHelper::getImg('/uploads/users/jedi_master_yoda-wide.jpg', 230, 230);
 *
 * */
class ThumbHelper
{
    /** @var string $cacheAlias path alias relative with @web where the cache files are kept */
    public static $cacheAlias = '@uploads/cache/_thumbs';

    public static function getUrl($file, $width, $height, $options = [])
    {
        if(strpos($file, 'uploads')) {
            $file = substr($file, strpos($file, 'uploads') + strlen('uploads'));
        }

        $file = self::getFilePath($file);

        if (!$file) {
            return self::handleDefault($width, $height, $options, __METHOD__);
        }

        $thumbPath = self::generateThumbnail($file, $width, $height, $options);

        preg_match('#[^\\' . DIRECTORY_SEPARATOR . ']+$#', $thumbPath, $matches);
        $fileName = $matches[0];
        $fileName = substr($fileName, strpos($fileName, 'uploads') - 1);

        return $fileName;
    }

    public static function getFile($file, $width, $height, $options = [])
    {
        $file = self::getFilePath($file);

        if (!$file) {
            return self::handleDefault($width, $height, $options, __METHOD__);
        }

        return self::generateThumbnail($file, $width, $height, $options);
    }

    public static function getImg($file, $width, $height, $options = [])
    {
        $thumbUrl = self::getUrl($file, $width, $height, $options);

        unset(
            $options['mode'],
            $options['default']
        );
        return Html::img($thumbUrl, $options);
    }

    public static function removeThumbs($file)
    {
        $fileName = pathinfo($file, PATHINFO_FILENAME);
        $thumbDir = self::getThumbCachePath($fileName);

        try {
            $thumbs = FileHelper::findFiles($thumbDir, ['only' => ["/{$fileName}*"]]);

            foreach ($thumbs as $thumb) {
                unlink($thumb);
            }

            if (is_readable($thumbDir) && count(scandir($thumbDir)) === 2) {
                unlink($thumbDir);
            }
        } catch (ErrorException $e) {

        }
    }

    protected static function generateThumbnail($file, $width, $height, $options)
    {

        $thumbName = self::getThumbFileName($file, $width, $height);
        $thumbDir = self::getThumbCachePath($thumbName);
        $thumbPath = "{$thumbDir}/{$thumbName}";

        if (file_exists($thumbPath)) {
            return $thumbPath;
        }

        FileHelper::createDirectory($thumbDir);

        $mode = ArrayHelper::getValue($options, 'mode', ManipulatorInterface::THUMBNAIL_OUTBOUND);

        $box = new Box($width, $height);

        if(isset(Yii::$app->params['imageDriver']) && is_array(Yii::$app->params['imageDriver'])) {
            Image::$driver = Yii::$app->params['imageDriver'];
        }

        $image = Image::getImagine()->open($file);
        $image = $image->thumbnail($box, $mode);

        $image->save($thumbPath);

        return $thumbPath;
    }

    protected static function getFilePath($file)
    {
        if (strpos($file, '@') !== 0) {
            $file = '@uploads/' . $file;
        }

        $file = FileHelper::normalizePath(Yii::getAlias($file));

        if (!is_file($file)) {
            return false;
        }

        return $file;
    }

    protected static function getThumbCachePath($fileBase)
    {
        //return Yii::getAlias('@uploads/' . self::$cacheAlias) . '/' . substr($fileBase, 0, 2);
        return Yii::getAlias(self::$cacheAlias) . '/' . substr($fileBase, 0, 2);
    }

    protected static function getThumbFileName($file, $width, $height)
    {
        $fileName = pathinfo($file, PATHINFO_FILENAME);
        $fileExt = pathinfo($file, PATHINFO_EXTENSION);

        return "{$fileName}_{$width}x{$height}.{$fileExt}";
    }

    protected static function handleDefault($width, $height, $options, $callback)
    {
        if ($file = ArrayHelper::getValue($options, 'default')) {
            unset($options['default']);

            return call_user_func($callback, $file, $width, $height, $options);
        } else {
            throw new ErrorException("File $file doesn't exist");
        }
    }
}
