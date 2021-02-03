<?php

class Controller_Barcode extends Controller
{
    public function action_generator()
    {
        $params = Input::get();
        if (isset($params['s']) && isset($params['d'])) {
            $barcode = new Barcode();
            $format = (isset($params['f']) ? $params['f'] : 'png');
            $params['bc'] = (isset($params['bc']) ? $params['bc'] : '#f5f5f5');
            $barcode->output_image($format, $params['s'], $params['d'], $params);
            exit(0);
        }
    }
}