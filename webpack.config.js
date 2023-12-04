const Encore = require('@symfony/webpack-encore');
const dotenv = require('dotenv-webpack');
const resolve = require('path').resolve;


require("dotenv").config({
    path: `./.env${Encore.isProduction() ? '.prod' : ''}`
});

// Manually configure the runtime environment if not already configured yet by the "encore" command.
// It's useful when you use tools that rely on webpack.config.js file.
if (!Encore.isRuntimeEnvironmentConfigured()) {
    Encore.configureRuntimeEnvironment(process.env.NODE_ENV || 'dev');
}

Encore
    // directory where compiled assets will be stored
    .setOutputPath('public/build/')
    // public path used by the web server to access the output path
    .setPublicPath(process.env.APP_URL + '/build')
    // .setPublicPath('/build')
    .setManifestKeyPrefix('build/')
    .addEntry('carro/app', './assets/carro/index.js')
    .addEntry('print/app', './assets/print/index.js')
    .addEntry('buscar/app', './assets/buscar/index.js')
    .enableVersioning(Encore.isProduction())
    .splitEntryChunks()
    .enableSingleRuntimeChunk()
    /*
     * FEATURE CONFIG
     *
     * Enable & configure other features below. For a full
     * list of features, see:
     * https://symfony.com/doc/current/frontend.html#adding-more-features
     */
    .cleanupOutputBeforeBuild()
    .configureBabel((config) => {
        config.plugins.push('@babel/plugin-proposal-class-properties');
    })
    .configureBabelPresetEnv((config) => {
        config.useBuiltIns = 'usage';
        config.corejs = 3;
    })
    // dotenv
    .addPlugin(new dotenv({
        ignoreStub: true,
        path: `./.env${Encore.isProduction() ? '.prod' : ''}`
    }))
;


let config = Encore.getWebpackConfig();
config.resolve.alias = {
    '@': resolve(__dirname, './assets')
};

module.exports = config;
