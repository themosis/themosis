var gulp = require('gulp'),
    gutil = require('gulp-util'),
    autoprefixer = require('autoprefixer'),
    babel = require('gulp-babel'),
    bs = require('browser-sync').create(),
    cleancss = require('gulp-clean-css'),
    concat = require('gulp-concat'),
    notify = require('gulp-notify'),
    plumber = require('gulp-plumber'),
    rename = require('gulp-rename'),
    sass = require('gulp-sass'),
    sourcemaps = require('gulp-sourcemaps'),
    stylus = require('gulp-stylus'),
    uglify = require('gulp-uglify'),
    webpack = require('webpack'),
    webpackConfig = require('./webpack.config.js'),
    postcss = require('gulp-postcss'),
    flexibility = require('postcss-flexibility');

/* Directories */
var dirs = {
    src: './assets',
    dest: './dist'
};

/**
 * Error reporting helper function.
 * Code from https://github.com/brendanfalkowski
 *
 * @param err
 */
var errorReport = function(err)
{
    var lineNumber = (err.lineNumber) ? 'LINE ' + err.lineNumber + ' -- ' : '';

    notify({
        title: 'Task failed [' + err.plugin + ']',
        message: lineNumber + 'See console.',
        sound: 'Basso'
    }).write(err);

    gutil.beep();

    // Report the error on the console
    var report = '';
    var chalk = gutil.colors.bgMagenta.white;

    report += chalk('TASK:') + ' [' + err.plugin + ']\n';
    report += chalk('ISSUE:') + ' ' + err.message + '\n';
    if (err.lineNumber) { report += chalk('LINE:') + ' ' + err.lineNumber + '\n'; }
    if (err.fileName)   { report += chalk('FILE:') + ' ' + err.fileName + '\n'; }
    console.log(report);

    // Prevent the 'watch' task from stopping
    this.emit('end');
};

/*-------*/
/* Tasks */
/*-------*/
// Stylus
gulp.task('stylus:dev', function()
{
    return gulp.src(dirs.src + '/stylus/*.styl')
        .pipe(plumber({
            errorHandler: errorReport
        }))
        .pipe(sourcemaps.init())
        .pipe(stylus())
        .pipe(postcss([autoprefixer({
            browsers: [
                "Android 2.3",
                "Android >= 4",
                "Chrome >= 20",
                "Firefox >= 24",
                "Explorer >= 8",
                "iOS >= 6",
                "Opera >= 12",
                "Safari >= 6"
            ]
        }), flexibility()]))
        .pipe(cleancss())
        .pipe(rename({
            suffix: '.min'
        }))
        .pipe(sourcemaps.write('./maps'))
        .pipe(gulp.dest(dirs.dest + '/css'))
        .pipe(bs.stream());
});

gulp.task('stylus', function()
{
    return gulp.src(dirs.src + '/stylus/*.styl')
        .pipe(stylus({
            compress: true
        }))
        .pipe(postcss([autoprefixer({
            browsers: [
                "Android 2.3",
                "Android >= 4",
                "Chrome >= 20",
                "Firefox >= 24",
                "Explorer >= 8",
                "iOS >= 6",
                "Opera >= 12",
                "Safari >= 6"
            ]
        }), flexibility()]))
        .pipe(cleancss())
        .pipe(rename({
            suffix: '.min'
        }))
        .pipe(gulp.dest(dirs.dest + '/css'));
});

// Sass
// Compatibility with Bootstrap 3.3.7 Sass
gulp.task('sass:dev', function () {
    return gulp.src(dirs.src + '/sass/*.scss')
        .pipe(sourcemaps.init())
        .pipe(sass({
            outputStyle: 'compressed',
            precision: 10
        }).on('error', sass.logError))
        .pipe(postcss([autoprefixer({
            browsers: [
                "Android 2.3",
                "Android >= 4",
                "Chrome >= 20",
                "Firefox >= 24",
                "Explorer >= 8",
                "iOS >= 6",
                "Opera >= 12",
                "Safari >= 6"
            ]
        })]))
        .pipe(cleancss())
        .pipe(rename({
            suffix: '.min'
        }))
        .pipe(sourcemaps.write('./maps'))
        .pipe(gulp.dest(dirs.dest + '/css'))
        .pipe(bs.stream());
});

gulp.task('sass', function () {
    return gulp.src(dirs.src + '/sass/*.scss')
        .pipe(sass({
            outputStyle: 'compressed',
            precision: 10
        }).on('error', sass.logError))
        .pipe(postcss([autoprefixer({
            browsers: [
                "Android 2.3",
                "Android >= 4",
                "Chrome >= 20",
                "Firefox >= 24",
                "Explorer >= 8",
                "iOS >= 6",
                "Opera >= 12",
                "Safari >= 6"
            ]
        })]))
        .pipe(cleancss())
        .pipe(rename({
            suffix: '.min'
        }))
        .pipe(gulp.dest(dirs.dest + '/css'));
});


/**
 * Webpack.
 *
 * JS files are transpiled through BabelJS and bundled thanks to webpack.
 * In order to define multiple entry points, for example, a JS bundle
 * for the front-end and a second one for the wp-admin, edit the `webpack.config.js`
 * entry property: the key is the filename output, with a '.min.js' file extension and the
 * value is the file path.
 */
var config = Object.create(webpackConfig);

config.devtool = 'sourcemap';
config.debug = true;

var compiler = webpack(config);

/**
 * JS files for development - Watch
 */
gulp.task('webpack:dev', function (callback) {
    compiler.run(function (err, stats) {
        if (err) {
            throw new gutil.PluginError('webpack:dev', err);
        }
        gutil.log('[webpack:dev]', stats.toString({
            colors: true
        }));
        callback();
    });
});

/**
 * JS files for production - Build
 */
gulp.task('webpack', function (callback) {
    var config = Object.create(webpackConfig);
    /**
     * Optimize webpack for production.
     */
    config.plugins = config.plugins.concat(
        new webpack.DefinePlugin({
            'process.env': {
                'NODE_ENV': JSON.stringify('production')
            }
        }),
        new webpack.optimize.DedupePlugin(),
        new webpack.optimize.UglifyJsPlugin()
    );

    webpack(config, function (err, stats) {
        if (err) {
            throw new gutil.PluginError('webpack', err);
        }
        gutil.log('[webpack]', stats.toString({
            colors: true
        }));
        callback();
    });
});

/*------------*/
/* Watch Task */
/*------------*/
gulp.task('watch', function()
{
    bs.init({
        https: false
    });

    gulp.watch(dirs.src + '/stylus/**/*.styl', gulp.series('stylus:dev'));
    gulp.watch(dirs.src + '/sass/**/*.scss', gulp.series('sass:dev'));
    gulp.watch(dirs.src + '/js/**/*.js', gulp.series('webpack:dev')).on('change', bs.reload);
});

/*------------*/
/* Build task */
/*------------*/
gulp.task('build', gulp.series('sass', 'webpack'));