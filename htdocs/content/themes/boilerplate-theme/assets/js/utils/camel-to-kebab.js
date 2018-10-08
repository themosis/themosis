export function camelToKebab(string) {
	return string.replace(/([a-z])([A-Z])/g, '$1-$2').toLowerCase();
}

export function kebabToCamel(string) {
	return string.replace(/-([a-z])/g, function (g) {
		return g[1].toUpperCase();
	});
}
