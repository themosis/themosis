# webpack-chunk-hash

Plugin to replace a standard webpack chunk hashing with custom (md5) one.

_Note: It's a clone of [webpack-md5-hash](https://www.npmjs.com/package/webpack-md5-hash) plugin, but without sorting provided chunks (unobtrusive),
and using native crypto module (performance)._

## Install

```
npm install --save-dev webpack-chunk-hash
```

## Example

Just add this plugin as usual.

```javascript

// webpack.config.js

var WebpackChunkHash = require('webpack-chunk-hash');

module.exports = {
  // ...
  output: {
    filename: '[name].[chunkhash].js',
    chunkFilename: '[name].[chunkhash].js',
  },
  plugins: [
    new WebpackChunkHash({algorithm: 'md5'}) // 'md5' is default value
  ]
};

```

## Options

```
// a callback to add more content to the resulting hash
additionalHashContent: function(chunk) { return 'your additional content to hash'; } 
// which algorithm to use (https://nodejs.org/api/crypto.html#crypto_crypto_createhash_algorithm)
algorithm: 'md5'
// which digest to use (https://nodejs.org/api/crypto.html#crypto_hash_digest_encoding)
digest:    'hex'
```

## License

WebpackChunkHash plugin is released under the [MIT](License) license.
