<?php

namespace Bolt\Extension\Bolt\BaseWidget;

use Bolt\Application;
use Bolt\BaseExtension;

class Extension extends BaseExtension
{

    public function initialize() {

        dump($this->config);

        foreach($this->config['widgets'] as $name => $widget) {

            // Skip diabled extensions.
            if ($this->config['enabled'] === false) {
                continue;
            }

            if(empty($widget['type']) || $widget['type'] !== 'backend') {
                $widget['type'] = 'frontend';
            }

            $widgetObj = new \Bolt\Asset\Widget\Widget();
            $widgetObj
                ->setType($widget['type'])
                ->setLocation($widget['location'])
                ->setCallback([$this, 'widget'])
                ->setCallbackArguments(['widget' => $widget])
            ;
            $this->addWidget($widgetObj);


        }



    }

    public function getName()
    {
        return "basewidget";
    }

    public function widget($widget)
    {

        dump($widget);



        return "hoi";
    }


}






