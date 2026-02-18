const mix = require("laravel-mix");

/*
 |--------------------------------------------------------------------------
 | Mix Asset Management
 |--------------------------------------------------------------------------
 |
 | Mix provides a clean, fluent API for defining some Webpack build steps
 | for your Laravel applications. By default, we are compiling the CSS
 | file for the application as well as bundling up all the JS files.
 |
 */

mix
  .js("view/client/Vue/pwaApp.js", "js/pwaApp.js")
  .postCss("view/client/Vue/style/pwa.css", "css/pwaApp.css")
  .options({
    processCssUrls: true,
    cssNano: {
      discardComments: { removeAll: true },
    },
  }).sourceMaps(true, "source-map")
  .setPublicPath("dist")
  .setResourceRoot("../")
  .vue();


