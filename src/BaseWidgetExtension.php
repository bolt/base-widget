<?php

namespace Bolt\Extension\Bolt\BaseWidget;

use Bolt\Application;
use Bolt\BaseExtension;

class BaseWidgetExtension extends BaseExtension
{

    public function initialize()
    {
        foreach((array) $this->config['widgets'] as $name => $widget) {

            // Skip diabled extensions.
            if (isset($widget['enabled']) && $widget['enabled'] === false) {
                continue;
            }

            if(empty($widget['zone']) || $widget['zone'] !== 'backend') {
                $widget['zone'] = 'frontend';
            }

            $widgetObj = new \Bolt\Asset\Widget\Widget();
            $widgetObj
                ->setZone($widget['zone'])
                ->setLocation($widget['location'])
                ->setCallback([$this, 'widget'])
                ->setCallbackArguments(['widget' => $widget])
            ;

            if (!empty($widget['class'])) {
                $widgetObj->setClass($widget['class']);
            }

            if (!empty($widget['defer'])) {
                $widgetObj->setDefer($widget['defer']);
            }

            if (!empty($widget['cacheduration'])) {
                $widgetObj->setCacheDuration($widget['cacheduration']);
            }

            // dump($widgetObj);

            $this->addWidget($widgetObj);
        }
    }

    public function getName()
    {
        return "basewidget";
    }

    public function widget($widget)
    {
        // If we need a 'static' widget, we can just retun the output here and we're done
        if (!empty($widget['static'])) {
            return $widget['static'];
        }

        // Make sure 'content' is defined
        if (empty($widget['content'])) {
            $widget['content'] = [];
        }

        // Fetch the configured record, if any
        if (!empty($widget['record'])) {
            list($ct, $slug) = explode('/', $widget['record']);
            $key = is_numeric($slug) ? 'id' : 'slug';
            $record = $this->app['storage']->getContent($ct, [$key => $slug, 'returnsingle' => true]);
        } else {
            $record = $widget['content'];
        }

        // Data to pass into the widget
        $data = [
            'record' => $record,
            'widget' => $widget,
            'content' => $widget['content']
        ];

        // Add the `widgets/` path, so it can be overridden in themes
        $this->app['twig.loader.filesystem']->addPath(__DIR__);

        // Make sure 'template' is defined, and the template file exists
        if (empty($widget['template'])) {
            return "<strong>Base Widget error:</strong> Custom widgets need to define a template.";
        } elseif (!$this->app['twig.loader']->exists($widget['template'])) {
            return "<strong>Base Widget error:</strong> Widget template '<tt>" . $widget['template'] .
                "</tt>' does not exist, or isn't readable.";
        }

        // Render the template, and return the results
        return $this->app['render']->render($widget['template'], $data);
    }


}






