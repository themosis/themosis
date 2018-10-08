'use strict';

const path = require('path');
const ExtractTextPlugin = require('extract-text-webpack-plugin');
const templateFn = require('adjust-sourcemap-loader').moduleFilenameTemplate({format: 'projectRelative'});

const extractSass = new ExtractTextPlugin({
  filename: '[name].[contenthash].css',
  disable: false,
  allChunks: true
});

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
      use: extractSass.extract({
        use: [
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
      })
    }, {
      test: /\.(woff2?|ttf|eot|svg|jpg)(?:[?#].+)?$/,
      use: [{
        loader: 'file-loader'
      }]
    }]
  },
  plugins: [
    extractSass
  ]
};
