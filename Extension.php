<?php

namespace Bolt\Extension\Bolt\BaseWidget;

use Bolt\Application;
use Bolt\BaseExtension;

class Extension extends BaseExtension
{

    public function initialize() {

        $widget = new \Bolt\Asset\Widget\Widget();
        $widget
            ->setType('frontend')
            ->setLocation('aside_top')
            ->setCallback([$this, 'widget'])
            ->setCallbackArguments(['foo' => 'bar'])
        ;
        $this->addWidget($widget);

    }

    public function getName()
    {
        return "basewidget";
    }

    public function widget($foo, $bar)
    {

        dump($foo);

        return "hoi";
    }


}






