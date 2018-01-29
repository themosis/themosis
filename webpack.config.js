const { create } = require("@gladeye/bento");

const bento = create({
    homeDir: "./htdocs/content/themes/themosis/assets",
    outputDir: "./htdocs/content/themes/themosis/dist",
    proxy: "http://0.0.0.0:8080"
});

bento.bundle("main", "~/scripts/main.js");
bento.set("emitFiles", true);

module.exports = bento.export(process.env.NODE_ENV);
