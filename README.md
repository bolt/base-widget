Bolt Base Widget
================

Using this extension, you can easily configure and add widgets to a Bolt
website. This can be done both in the 'frontend' as well as in the backend.

This allows you to define specific 'blocks' for your website that don't really
fit into anything else, or you can use it to render and cache parts of the page
that are slowing down the performance. By adding these as a 'cached' or
'deferred' widget, the page will no longer slow down while waiting for all of
the content to render.

Some of the features of this extension are:

 - Adding a widget with static, predefined content
 - Adding widgets that retrieve a specific record
 - Using templates to render widgets
 - Widgets can be added to both the 'frontend' and 'backend'
 - Widgets can be cached and rendered non-blocking (deferred)

This extension uses Bolt's widget functionality. For the various locations that
you can add widgets, you'll find an [updated list][1] on the Bolt documentation
website.

To get a good idea of the possibilities of this extension, simply check out the
[default configuration][2], which shows various types of widgets to add.

Options:

 - `location`: The location determines where the widget will be inserted in the
   template. For the backend there are a number of pre-defined positions, but
   for the frontend this depends on where the theme's author has provided
   `{{ widget() }}` areas.
 - `zone`: Use this to specify a widget for 'backend'. If you omit this option,
   it'll be inserted in the 'frontend' by default.
 - `record`: Specify If the `content` option is also used, it will be used as a
   fallback for the values of `{{ record }} `
 - `template`: Define the template to use for rendering this widget. See the
   section 'Overriding the templates' below.
 - `content`: The content defines the static content for the widget and is
   normally defined as an array. This will be passed into the widget as-is, and
   will be accessible in the widget's template as `{{ content }}`. For backend
   widgets, there's a pre-defined format for this. See the section 'backend
   widgets' below.
 - `enabled`: Use this option to (temporarily) disable a widget. If set to
   `enabled: false`, the widget will not be shown anywhere.
 - `defer`: Insert this widget using 'ajaxy loading'. The page is rendered with
   an empty placeholder for the widget, which is then rendered in a separate
   request, and inserted in the page.
 - `cacheduration`: The amount (in seconds) that the entire widget is cached on
   the server. This can significantly speed up the rendering of pages, but be
   aware that _cached_ widgets can not show tailored content. The widget will
   show the same on every page, for all visitors.
 - `withcontext`: By design, widgets are "without context", because in normal
   use, the contents of a widget should _not_ depend on the page it's rendered
   on. Sometimes, however, you might really need this context. Setting
   `withcontext: true` will make sure your widget knows about all defined Twig
   variables that were available in the surrounding page, like
   `{{ dump(record) }}` in the front- or `{{ dump(context) }}` in the backend.
   Note that if you use this option, `cacheduration` and `defer` will both be
   disabled for this specific widget, so use with care and thought.
 - `priority`: Use this to specify the order in which widgets are displayed.
   Higher priorities are displayed first.

Overriding the templates
------------------------
This extension comes with a few default `.twig` files, to render blocks of
content or backend widgets. Especially if you are using this extension to add
blocks to your frontend pages, chances are that you will want to modify the way
it looks.

In one of the stock examples, you'll see:

```
template: widgets/contentblock.twig
```

This uses the template at`basewidget/widgets/templates/contentblock.twig`, in
the `extensions/vendor/bolt` folder. If you wish to use your own template,
simply create a folder `widgets` in your current theme directory, and copy the
file `contentblock.twig` to it. Bolt will automatically pick up the one from
your own theme, if you've overridden it.

Obviously you can also give a widget another template to render, but it is good
practice to keep these organized in a `widgets/` folder inside your theme.

Backend widgets
---------------

Using this extension, you'll be able to easily add two types of widgets to the
Bolt backend:

 - Panel widgets, for the sidebars on 'Dashboard', 'Overview listing', and
   'Edit content' pages.
 - Button widgets, for almost all pages.

To add a button to the Dashboard, use the following:

```
    block6:
        type: backend
        location: dashboard_below_header
        template: widgets/backend_buttons.twig
        content:
            buttons:
                About:
                    type: secondary
                    icon: heart
                    path: about
```

This is the result:

![screenshot 1][img1]


The `location` is one of the pre-defined locations in Bolt's backend where you
can add widgets. The `content` has a field `buttons`, that defines one or more
buttons. In the above example, only one button is added, that's labeled
'About'. To determine the functionality of the buttons, there are four options:

 - `type`: Specify the type of button. Accepted values are `primary`,
   `secondary`, `tertiary` and `default`. When adding multiple buttons, you
   should take care not to make the interface too cluttered by having too many
   "primary" button. Ideally, you'd add one "primary" button at most, and any
   others should bet either "tertiary" or "default".
 - `icon`: This can be any [Font Awesome][fa] icon. If omitted, the button will
   have no icon.
 - `path`: Specify a named path, as defined by `->bind('…')` in the controller.
   This will mostly be useful if you have created an extension, and would like
   to add some buttons for it. If this is used, it takes priority over the
   `link` option.
 - `link`: This can be either an internal (relative) or an external (absolute)
   link to any URL you'd like.
 - `target`: Set this to `_blank` in order to open the specified link in a new
   tab/window in the browser.


To add a panel widget to the backend, use the following structure:

```
    block5:
        type: backend
        location: dashboard_aside_top
        template: widgets/backend_panel.twig
        content:
            icon: camera-retro
            title: An example of a Dashboard widget
            description: "Lorem ipsum dolor sit amet … …"
            buttons:
                About:
                    type: primary
                    icon: heart
                    path: about
                Documentation:
                    type: default
                    icon: leanpub
                    link: 'https://docs.bolt.cm'
                    target: '_blank'
```

The result will look like this:

![screenshot 2][img2]

As before, you'll note the section with "buttons". These have the same options
as before. This widget has some additional fields, like `icon`, `title` and
`description`, which should all be self explanatory.


[1]: https://docs.bolt.cm/extensions/intermediate/widgets#locations
[2]: https://github.com/bolt/base-widget/blob/master/config/config.yml.dist
[fa]: http://fontawesome.io/icons/
[img2]: https://cloud.githubusercontent.com/assets/1833361/10868858/3e93eca6-809c-11e5-8212-179f909cf94d.png
[img1]: https://cloud.githubusercontent.com/assets/1833361/10868978/e0f4bfd6-809f-11e5-9119-c2bf6a4e7d47.png
