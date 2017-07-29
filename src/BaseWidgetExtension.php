<?php

namespace Bolt\Extension\Bolt\BaseWidget;

use Bolt\Asset\Widget\Widget;
use Bolt\Extension\SimpleExtension;

class BaseWidgetExtension extends SimpleExtension
{
    protected function registerAssets()
    {
        $widgets = [];
        $config = $this->getConfig();
        foreach ((array) $config['widgets'] as $name => $widget) {

            // Skip disabled extensions.
            if (isset($widget['enabled']) && $widget['enabled'] === false) {
                continue;
            }

            if (empty($widget['zone']) || $widget['zone'] !== 'backend') {
                $widget['zone'] = 'frontend';
            }

            $widgetObj = new Widget();
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
            } else {
                $widgetObj->setCacheDuration(-1);
            }

            if (!empty($widget['withcontext']) && $widget['withcontext'] === true) {
                $widgetObj->setCacheDuration(-1);
                $widgetObj->setDefer(false);
            }

            if (!empty($widget['priority'])) {
                $widgetObj->setPriority($widget['priority']);
            }

            $widgets[] = $widgetObj;
        }

        return $widgets;
    }

    public function widget($widget)
    {
        $app = $this->getContainer();

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
            $record = $app['storage']->getContent($ct, [$key => $slug, 'returnsingle' => true]);
        } else {
            $record = $widget['content'];
        }

        // Data to pass into the widget
        $data = [
            'record'  => $record,
            'widget'  => $widget,
            'content' => $widget['content'],
        ];

        if (!empty($widget['withcontext']) && $widget['withcontext'] === true) {
            $data = array_merge($data, $app['twig']->getGlobals());
        }

        // Make sure 'template' is defined, and the template file exists
        if (empty($widget['template'])) {
            return '<strong>Base Widget error:</strong> Custom widgets need to define a template.';
        }

        try {
            // Render the template, and return the results
            return $this->renderTemplate($widget['template'], $data);
        } catch (\Twig_Error_Loader $e) {
            return "<strong>Base Widget error:</strong> Widget template '<tt>" . $widget['template'] .
            "</tt>' does not exist, or isn't readable.";
        }
    }
}
