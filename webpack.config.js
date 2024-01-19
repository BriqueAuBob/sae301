const Encore = require('@symfony/webpack-encore');

if (!Encore.isRuntimeEnvironmentConfigured()) {
    Encore.configureRuntimeEnvironment(process.env.NODE_ENV || 'dev');
}

Encore
    .setOutputPath('public/build/')
    .setPublicPath('/build')

    .addEntry('app', [
        './assets/app.js',
    ])
    .addEntry('calendar', './assets/js/calendar.js')
    .addEntry('modal', './assets/js/modal.js')
    .addEntry('delete', './assets/js/delete.js')
    .addEntry('isRead', './assets/js/isRead.js')
    .addEntry('card', './assets/js/card.js')

    .enableStimulusBridge('./assets/controllers.json')

    .splitEntryChunks()
    .enableSingleRuntimeChunk()

    .cleanupOutputBeforeBuild()
    .enableBuildNotifications()
    .enableSourceMaps(!Encore.isProduction())
    .enableVersioning(Encore.isProduction())

    .configureBabelPresetEnv((config) => {
        config.useBuiltIns = 'usage';
        config.corejs = '3.23';
    })

    .enableSassLoader()
    .enablePostCssLoader()

    // .autoProvidejQuery()
;

module.exports = Encore.getWebpackConfig();
