'use strict';

const path = require('path');
const LastCallWebpackPlugin = require('last-call-webpack-plugin');
const OptimizeCSSAssetsPlugin = require('optimize-css-assets-webpack-plugin');
const MiniCssExtractPlugin = require('mini-css-extract-plugin');
const templateFn = require('adjust-sourcemap-loader').moduleFilenameTemplate({format: 'projectRelative'});
const processFn = require('adjust-sourcemap-loader/lib/process');

module.exports = {
  entry: path.join(__dirname, process.env.ENTRY),
  output: {
    path: path.join(__dirname, process.env.OUTPUT),
    filename: '[name].js',
    devtoolModuleFilenameTemplate: templateFn,
    devtoolFallbackModuleFilenameTemplate: templateFn
  },
  devtool: JSON.parse(process.env.DEVTOOL),
  resolve: {
    modules: [path.join(__dirname, 'modules'), 'node_modules'] // specifically for isolation in module-relative test
  },
  module: {
    rules: [{
      test: /\.scss$/,
      use: [
        MiniCssExtractPlugin.loader,
        {
          loader: 'css-loader',
          options: JSON.parse(process.env.CSS_OPTIONS)
        }, {
          loader: 'resolve-url-loader',
          options: Object.assign(JSON.parse(process.env.LOADER_OPTIONS), {
            join: process.env.LOADER_JOIN ?
              new Function('require', process.env.LOADER_JOIN)(require) : // jshint ignore:line
              undefined
          })
        }, {
          loader: 'sass-loader',
          options: {
            sourceMap: true,
            sourceMapContents: false
          }
        }
      ]
    }, {
      test: /\.(woff2?|ttf|eot|svg|jpg)(?:[?#].+)?$/,
      use: [{
        loader: 'file-loader'
      }]
    }]
  },
  plugins: [
    new MiniCssExtractPlugin({
      filename: '[name].[contenthash].css'
    }),
    // currently devtoolModuleFilenameTemplate is not respected by OptimizeCSSAssetsPlugin so we must do it ourselves
    new LastCallWebpackPlugin({
      assetProcessors: [{
        regExp: /\.css\.map/,
        processor: (assetName, asset) => Promise.resolve(JSON.parse(asset.source()))
          .then(obj => processFn({}, {format: 'projectRelative'}, obj))
          .then(obj => JSON.stringify(obj))
      }]
    })
  ],
  optimization: {
    minimizer: [
      new OptimizeCSSAssetsPlugin({
        cssProcessorOptions: {
          map: !!JSON.parse(process.env.DEVTOOL),
          // the following optimisations are fine but e2e assertions are easier without them
          cssDeclarationSorter: false,
          normalizeUrl: false,
          discardUnused: false
        }
      })
    ]
  }
};
