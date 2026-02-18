const mix = require("laravel-mix");
const mix_pwa = require("laravel-mix");

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
  .js("view/client/Vue/internationalFlight-v1.js",  "js/internationalFlight.js")
  .sass("view/client/assets/styles/v1/flight.scss", "css/flight.css")
  .options({
    processCssUrls: true,
    cssNano: {
      discardComments: { removeAll: true },
    },
  }).sourceMaps(true, "source-map")
  .setPublicPath("dist/flight")
  .setResourceRoot("../")
  .vue();


