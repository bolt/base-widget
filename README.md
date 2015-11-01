Bolt Base Widget
================

Using this extension, you can easily configure and add widgets to a Bolt website. This can be done both in the 'frontend' as well as in the backend. 

This allows you to define specific 'blocks' for your website that don't really fit into anything else, or you can use it to render and cache parts of the page that are slowing down the performance. By adding these as a 'cached' or 'deferred' widget, the page will no longer slow down while waiting for all of the content to render. 

Some of the features of this extension are: 

 - Adding a widget with static, predefined content
 - Adding widgets that retrieve a specific record
 - Using templates to render widgets
 - Widgets can be added to both the 'frontend' and 'backend'
 - Widgets can be cached and rendered non-blocking (deferred)

This extension uses Bolt's widget functionality. For the various locations that you can add widgets, you'll find an [updated list][1] on the Bolt documentation website. 

To get a good idea of the possibilities of this extension, simply check out the [default configuration][2], which shows various types of widgets to add.


        content:
            title: This is a sample widget
            excerpt: "Edit <tt>config/extensions/basewidget.bolt.yml</tt> to change the widgets."


        record: page/1
        location: aside_top
        template: contentblock.twig
        enabled: true

        type: backend
        location: dashboard_aside_top
        template: backend_panel.twig
        content:
            icon: camera-retro # any font-awesome icon will work: http://fontawesome.io/icons/
            title: An example of a Dashboard widget
            description: "Lorem ipsum dolor sit amet, consectetur adipiscing elit. Et certamen honestum et disputatio splendida!"
            buttons:
                About:
                    type: primary
                    icon: heart
                    path: about # Note, Use a route that's registered in Bolt.
                Documentation:
                    type: default
                    icon: leanpub
                    link: 'https://docs.bolt.cm' # This can be a fixed (external) link
                    target: '_blank'

        type: backend
        location: dashboard_aside_top
        template: backend_panel.twig
        content:
            icon: camera-retro # any font-awesome icon will work: http://fontawesome.io/icons/
            title: An example of a Dashboard widget
            description: "Lorem ipsum dolor sit amet, consectetur adipiscing elit. Et certamen honestum et disputatio splendida!"
            buttons:
                About:
                    type: primary
                    icon: heart
                    path: about # Note, Use a route that's registered in Bolt.
                Documentation:
                    type: default
                    icon: leanpub
                    link: 'https://docs.bolt.cm' # This can be a fixed (external) link
                    target: '_blank'

Overriding the templates
------------------------
This extension comes with a few default `.twig` files, to render blocks of content or backend widgets. Especially if you are using this extension to add blocks to your frontend pages, chances are that you will want to modify the way it looks. 

In one of the stock examples, you'll see: 

```
template: widgets/contentblock.twig

This is the result: 

![screenshot 2015-11-01 13 26 02](https://cloud.githubusercontent.com/assets/1833361/10868858/3e93eca6-809c-11e5-8212-179f909cf94d.png)


![screenshot 2015-11-01 13 52 01](https://cloud.githubusercontent.com/assets/1833361/10868978/e0f4bfd6-809f-11e5-9119-c2bf6a4e7d47.png)


[1]: https://docs.bolt.cm/widgets
[2]: https://github.com/bolt/base-widget/blob/master/config.yml.dist