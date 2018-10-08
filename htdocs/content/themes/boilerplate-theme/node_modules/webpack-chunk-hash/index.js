var crypto = require('crypto');

module.exports = WebpackChunkHash;

function WebpackChunkHash(options)
{
  options = options || {};

  this.algorithm = options.algorithm || 'md5';
  this.digest = options.digest || 'hex';
  this.additionalHashContent = options.additionalHashContent || function() { return ''; };
}

WebpackChunkHash.prototype.apply = function(compiler)
{
  var _plugin = this;

  compiler.plugin('compilation', function(compilation)
  {
    compilation.plugin('chunk-hash', function(chunk, chunkHash)
    {
      var source = chunk.modules.map(getModuleSource).sort(sortById).reduce(concatenateSource, '')
        , hash   = crypto.createHash(_plugin.algorithm).update(source + _plugin.additionalHashContent(chunk))
        ;

      chunkHash.digest = function(digest)
      {
        return hash.digest(digest || _plugin.digest);
      };
    });
  });
};

// helpers

function sortById(a, b)
{
  return a.id - b.id;
}

function getModuleSource(module)
{
  return {
    id    : module.id,
    source: (module._source || {})._value || '',
    dependencies: (module.dependencies || []).map(function(d){ return d.module ? d.module.id : ''; })
  };
}

function concatenateSource(result, module)
{
  return result + '#' + module.id + ':' + module.source + '$' + (module.dependencies.join(','));
}
