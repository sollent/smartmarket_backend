const Encore = require('@symfony/webpack-encore');

Encore
    .setOutputPath('web/build')
    .setPublicPath('/build')
    .addEntry('app', './web/assets/libs/materialize-sass/sass/materialize.scss')
    .addEntry('custom', './web/assets/scss/style.scss')
    .addEntry('homepage', './web/assets/scss/homepage.scss')
    .addEntry('catalog', './web/assets/scss/catalog.scss')
    .addEntry('news', './web/assets/scss/news.scss')
    .addEntry('product', './web/assets/scss/product.scss')
    .enableSassLoader()
    .autoProvidejQuery()
    .cleanupOutputBeforeBuild()
    .enableBuildNotifications()
;

module.exports = Encore.getWebpackConfig();
