'use strict';

const path = require('path');
const ExtractTextPlugin = require('extract-text-webpack-plugin');
const templateFn = require('adjust-sourcemap-loader').moduleFilenameTemplate({format: 'projectRelative'});

module.exports = {
  entry: path.join(__dirname, process.env.ENTRY),
  output: {
    // NB: deep output path (weirdly) forces loader.context to be relative
    path: path.join(__dirname, process.env.OUTPUT),
    filename: '[name].js',
    devtoolModuleFilenameTemplate: templateFn,
    devtoolFallbackModuleFilenameTemplate: templateFn
  },
  devtool: JSON.parse(process.env.DEVTOOL),
  resolve: {
    root: path.join(__dirname, 'modules') // specifically for isolation in module-relative test
  },
  module: {
    loaders: [{
      test: /\.scss$/,
      loader: ExtractTextPlugin.extract([
        `css-loader?${process.env.CSS_QUERY}`,
        `resolve-url-loader?${process.env.LOADER_QUERY}`,
        'sass-loader?sourceMap&sourceMapContents=false'
      ], {
        id: 'css'
      })
    }, {
      test: /\.(woff2?|ttf|eot|svg|jpg)(?:[?#].+)?$/,
      loader: 'file-loader'
    }]
  },
  plugins: [
    new ExtractTextPlugin('css', '[name].[md5:contenthash:hex].css', { allChunks: true })
  ],
  resolveUrlLoader: {
    join: process.env.LOADER_JOIN ?
      new Function('require', process.env.LOADER_JOIN)(require) : // jshint ignore:line
      undefined
  }
};
