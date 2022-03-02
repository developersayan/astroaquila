<?php

namespace App\Providers\Libraries;

use Illuminate\Support\ServiceProvider;

use Image;

class ImageResize extends ServiceProvider
{

    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        // 
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }


    public function initialize() {

    }
    /*
    * @ Method: getResize
    * @ Description: This method is used for get image resize
    * @ Created date: 23-Jul-2018
    */
    public static function doResize($config = array()) {
        if($config['file']) {
            $image_resize = Image::make($config['original_path'] . $config['filename']);
            $image_resize->resize($config['dimension'][0], $config['dimension'][1]);
            $image_resize->save($config['resize_path'] . $config['filename']);
        }// die;
    }
}
