<?php

/*
 *  $obj = new DrawImg();
 *  $obj->thumb("ffff00", 'l', 'null');
 * 根据颜色生成对应标注图片,同时支持生成缩略图
 * @author <liangpingzheng>
 * @date Jan 12, 2017 3:08:23 PM
 */

namespace app\common\components;

use Yii;
use app\common\components\Thumb;

class DrawImg {

    public $hueAbsoluteError = 7; //值越高越清晰
    public $colorToReplace; //原始图片的颜色
    public $iconPath;

    public function __construct() {
        $this->colorToReplace = $this->RGBtoHSL(255, 0, 0); //target color
        $this->iconPath = Yii::getAlias('@app') . '/web/icons';
    }

    /**
     * 图片主要（三通道）颜色判断
     * @param string $imgUrl 图片路径
     * @author <liangpingzheng>
     * @date 2017/1/12
     */
    function imgColor($imgUrl) {
        $imageInfo = getimagesize($imgUrl);
        //图片类型
        $imgType = strtolower(substr(image_type_to_extension($imageInfo[2]), 1));
        //对应函数
        $imageFun = 'imagecreatefrom' . ($imgType == 'jpg' ? 'jpeg' : $imgType);
        $i = $imageFun($imgUrl);
        //循环色值
        $rColorNum = $gColorNum = $bColorNum = $total = 0;
        for ($x = 0; $x < imagesx($i); $x++) {
            for ($y = 0; $y < imagesy($i); $y++) {
                $rgb = imagecolorat($i, $x, $y);
                //三通道
                $r = ($rgb >> 16) & 0xFF;
                $g = ($rgb >> 8) & 0xFF;
                $b = $rgb & 0xFF;
                $rColorNum += $r;
                $gColorNum += $g;
                $bColorNum += $b;
                $total++;
            }
        }
        $rgb = array();
        $rgb['r'] = round($rColorNum / $total);
        $rgb['g'] = round($gColorNum / $total);
        $rgb['b'] = round($bColorNum / $total);
        return $rgb;
    }

    /*
     * RGB TO HEX
     * @author <liangpingzheng>
     * @date 2017/1/12
     */

    function rgb2html($r, $g = -1, $b = -1) {
        if (is_array($r) && sizeof($r) == 3)
            list($r, $g, $b) = $r;
        $r = intval($r);
        $g = intval($g);
        $b = intval($b);
        $r = dechex($r < 0 ? 0 : ($r > 255 ? 255 : $r));
        $g = dechex($g < 0 ? 0 : ($g > 255 ? 255 : $g));
        $b = dechex($b < 0 ? 0 : ($b > 255 ? 255 : $b));
        $color = (strlen($r) < 2 ? '0' : '') . $r;
        $color .= (strlen($g) < 2 ? '0' : '') . $g;
        $color .= (strlen($b) < 2 ? '0' : '') . $b;
        return '#' . $color;
    }

    /*
     * HEX TO RGB
     * @author <liangpingzheng>
     * @date 2017/1/12
     */

    function html2rgb($color) {
        if ($color[0] == '#')
            $color = substr($color, 1);
        if (strlen($color) == 6)
            list($r, $g, $b) = array($color[0] . $color[1],
                $color[2] . $color[3],
                $color[4] . $color[5]);
        elseif (strlen($color) == 3)
            list($r, $g, $b) = array($color[0] . $color[0], $color[1] . $color[1], $color[2] . $color[2]);
        else
            return false;
        $r = hexdec($r);
        $g = hexdec($g);
        $b = hexdec($b);
        return array($r, $g, $b);
    }

    function RGBtoHSL($r, $g, $b) {
        $r /= 255;
        $g /= 255;
        $b /= 255;
        $max = max($r, $g, $b);
        $min = min($r, $g, $b);
        $l = ( $max + $min ) / 2;
        $d = $max - $min;
        if ($d == 0) {
            $h = $s = 0;
        } else {
            $s = $d / ( 1 - abs(2 * $l - 1) );
            switch ($max) {
                case $r:
                    $h = 60 * fmod(( ( $g - $b ) / $d), 6);
                    if ($b > $g) {
                        $h += 360;
                    }
                    break;
                case $g:
                    $h = 60 * ( ( $b - $r ) / $d + 2 );
                    break;
                case $b:
                    $h = 60 * ( ( $r - $g ) / $d + 4 );
                    break;
            }
        }
        return array(round($h, 2), round($s, 2), round($l, 2));
    }

    function HSLtoRGB($h, $s, $l) {
        $c = ( 1 - abs(2 * $l - 1) ) * $s;
        $x = $c * ( 1 - abs(fmod(( $h / 60), 2) - 1) );
        $m = $l - ( $c / 2 );
        if ($h < 60) {
            $r = $c;
            $g = $x;
            $b = 0;
        } else if ($h < 120) {
            $r = $x;
            $g = $c;
            $b = 0;
        } else if ($h < 180) {
            $r = 0;
            $g = $c;
            $b = $x;
        } else if ($h < 240) {
            $r = 0;
            $g = $x;
            $b = $c;
        } else if ($h < 300) {
            $r = $x;
            $g = 0;
            $b = $c;
        } else {
            $r = $c;
            $g = 0;
            $b = $x;
        }
        $r = ( $r + $m ) * 255;
        $g = ( $g + $m ) * 255;
        $b = ( $b + $m ) * 255;
        return array(floor($r), floor($g), floor($b));
    }

    /**
     * 对气泡进行颜色的替换
     * @param string $color 颜色
     * @param string $size 尺寸(l,m,s)
     * @param string $icon 小图标
     * @param boole $bubble 是否有气泡
     * @return void
     * @author <liangpingzheng>
     * @date 2017/01/13
     * @return string 文件名
     */
    function thumb($color = 'ff0000', $size = 'l', $icon = 'null', $bubble = true) {
        $color = strtolower($color);
        if ($bubble) {//判断是否是气泡图片
            $newFileName = $color . '-' . $size . '-' . $icon . '.png'; //新文件名
        } else {
            $newFileName = $color . '-' . $size . '-' . $icon . '_marker.png'; //新文件名
        }
        $templateFilePath = $this->iconPath . '/template/' . $size . '.png'; //模板图片
        $iconPath = $this->iconPath . '/thumb/' . $icon . '-' . $size . '.png'; //模板图片
        $newFilePath = $this->iconPath . '/default/' . $newFileName; //生成新图片
//        if (file_exists($newFilePath)) {
//            return $newFileName;
//        }

        if ($bubble == FALSE) {
            return $this->iconThumb($color, $iconPath, $newFilePath, $newFileName);
        }

        $rgb = $this->html2rgb('#' . $color); //进行颜色转换
        $replacementColor = $this->RGBtoHSL($rgb[0], $rgb[1], $rgb[2]); //生成新的标注颜色

        $im = imagecreatefrompng($templateFilePath);
        $width = imagesx($im);
        $height = imagesy($im);
        $out = imagecreatetruecolor($width, $height); //建立一个真彩色画布
        $transColor = imagecolorallocatealpha($out, 255, 255, 255, 127); //拾取白色
        imagefill($out, 0, 0, $transColor); //填充 如果不填充生成图片为不透明 底色为黑色

        for ($x = 0; $x < imagesx($im); $x++) {
            for ($y = 0; $y < imagesy($im); $y++) {
                $pixel = imagecolorat($im, $x, $y);

                $red = ($pixel >> 16) & 0xFF;
                $green = ($pixel >> 8) & 0xFF;
                $blue = $pixel & 0xFF;
                $alpha = ($pixel & 0x7F000000) >> 24;

                $colorHSL = $this->RGBtoHSL($red, $green, $blue);

                if ((($colorHSL[0] >= $this->colorToReplace[0] - $this->hueAbsoluteError) && ($this->colorToReplace[0] + $this->hueAbsoluteError) >= $colorHSL[0])) {
                    $color = $this->HSLtoRGB($replacementColor[0], $replacementColor[1], $colorHSL[2]);
                    $red = $color[0];
                    $green = $color[1];
                    $blue = $color[2];
                }

                if ($alpha == 127) {
                    imagesetpixel($out, $x, $y, $transColor);
                } else {
                    imagesetpixel($out, $x, $y, imagecolorallocatealpha($out, $red, $green, $blue, $alpha));
                }
            }
        }

        imagecolortransparent($out, $transColor); //把图片中白色设置为透明色
        imagesavealpha($out, TRUE);
        imagepng($out, $newFilePath);

        if ($icon != 'null') {
            if (strlen($icon) == 1) {//单字符
                if (preg_match('/[a-z0-9]{1}/', $icon)) {
                    return $this->charThumb($width, $height, $newFilePath, $icon, $size, $newFileName);
                }
            } else {
                return $this->water($width, $height, $newFilePath, $iconPath, $size, $newFileName);
            }
        } else {
            return $newFileName;
        }
    }

    /**
     *  给气泡图片加上小图标(类似水印吧)
     * @param int $width
     * @param int $height
     * @param string $newFilePath 气泡图片位置
     * @param string $iconPath 小图标图片位置
     * @param string $size 生成图片的尺寸
     * @author <liangpingzheng>
     * @date 2017/01/13
     * @return string 文件名
     */
    public function water($width, $height, $newFilePath, $iconPath, $size, $filename) {
        $images = new Thumb();
        $images->open($newFilePath);
        $images->resize_to($width, $height, 'center');
        if ($size == 's') {
            $images->add_watermark($iconPath, 4, 15);
        } else {
            $images->add_watermark($iconPath, 6, 25);
        }
        return $images->save_to($newFilePath, $filename);
    }

    /**
     * 生成没有气泡的图标
     * @param string $color 颜色
     * @param string $icon 图标路径
     * @param string $file 文件路径
     * @param string $filename  文件名
     * @author <liangpingzheng>
     * @date 2017/01/13
     * @return string 
     */
    public function iconThumb($color, $icon, $file, $filename) {

        $rgb = $this->html2rgb('#' . $color); //进行颜色转换
        $im = imagecreatefrompng($icon);
        $width = imagesx($im);
        $height = imagesy($im);
        $out = imagecreatetruecolor($width, $height); //建立一个真彩色画布
        $transColor = imagecolorallocatealpha($out, 0, 0, 0, 127); //拾取白色
        imagefill($out, 0, 0, $transColor); //填充 如果不填充生成图片为不透明 底色为黑色

        for ($x = 0; $x < imagesx($im); $x++) {
            for ($y = 0; $y < imagesy($im); $y++) {
                $pixel = imagecolorat($im, $x, $y);

                $red = ($pixel >> 16) & 0xFF;
                $green = ($pixel >> 8) & 0xFF;
                $blue = $pixel & 0xFF;
                $alpha = ($pixel & 0x7F000000) >> 24;

                //以纯白或纯黑进行替换时 无法实现 故修改成这样的
                //http://stackoverflow.com/questions/32710180/replace-a-color-with-another-color-in-an-image-with-php/32710756#32710756
                if ($red == 249 && $green == 251 && $blue == 249) {
                    $red = $rgb[0];
                    $green = $rgb[1];
                    $blue = $rgb[2];
                }

                if ($red == 255 && $green == 255 && $blue == 255) {
                    $red = $rgb[0];
                    $green = $rgb[1];
                    $blue = $rgb[2];
                }

                if ($alpha == 127) {
                    imagesetpixel($out, $x, $y, $transColor);
                } else {
                    imagesetpixel($out, $x, $y, imagecolorallocatealpha($out, $red, $green, $blue, $alpha));
                }
            }
        }

        imagecolortransparent($out, $transColor); //把图片中白色设置为透明色
        imagesavealpha($out, TRUE);
        imagepng($out, $file);
        return $filename;
    }

    /**
     * 生成单字符气泡图标
     * @param int $width
     * @param int $height
     * @param string $filePath
     * @param string $icon
     * @param string $size
     * @param string $filename
     * @return string
     */
    public function charThumb($width, $height, $filePath, $icon, $size, $filename) {
        $fontSet = [
            'l' => ['size' => 20, 'x' => 10, 'y' => 25],
            'm' => ['size' => 18, 'x' => 8, 'y' => 21],
            's' => ['size' => 12, 'x' => 4, 'y' => 13],
        ];

        $style = [
            'fill_color' => 'white',
            'font_size' => $fontSet[$size]['size'],
            'font' => $this->iconPath . '/template/fz.TTF',
        ];

        $images = new Thumb();
        $images->open($filePath);
        $images->resize_to($width, $height, 'scale_fill');
        $images->add_text($icon, $fontSet[$size]['x'], $fontSet[$size]['y'], 0, $style);
        return $images->save_to($filePath, $filename);
    }

    /**
     * 生成创建城市自定义数据的logo
     * @param int $id 城市ID
     * @param string $name 水印文字
     * @return null
     * @author <liangpingzheng>
     * @date 2017-01-19
     */
    public function logo($id = 2, $name = '京') {

        $colorArr = ['#1dbabc', '#ed6464', '#468cf5', '#134cf0', '#c605e9'];
        $width = 100;
        $height = 100;
        $newName = md5($id);
        $filePath = $this->iconPath . '/default/' . $newName . '.png'; //生成新图片

        if (file_exists($filePath)) {
            return $newName;
        }

        $color = $colorArr[array_rand($colorArr, 1)];
        $rgb = $this->html2rgb($color); //进行颜色转换
        $out = imagecreatetruecolor($width, $height); //建立一个真彩色画布
        $transColor = imagecolorallocate($out, $rgb[0], $rgb[1], $rgb[2]);
        imagefill($out, 0, 0, $transColor); //填充 如果不填充生成图片为不透明 底色为黑色
        imagepng($out, $filePath);

        $style = [
            'fill_color' => 'white',
            'font_size' => 65,
            'font' => $this->iconPath . '/template/fz.TTF',
        ];
        $images = new Thumb();
        $images->open($filePath);
        $images->resize_to($width, $height, 'scale_fill');
        $images->add_text($name, 15, 15, 0, $style);
        $images->save_to($filePath);
    }

}
