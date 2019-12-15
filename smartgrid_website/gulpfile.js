const gulp = require('gulp');
const del = require('del');
const gulpif = require('gulp-if');
const plumber = require('gulp-plumber');
const rigger = require('gulp-rigger');
const sass = require('gulp-sass');
const smart_grid = require('smart-grid');
const autoprefixer = require('gulp-autoprefixer');
const cleanCSS = require('gulp-clean-css');
const sourcemaps = require('gulp-sourcemaps');
const ggcmq = require('gulp-group-css-media-queries');
const webpackStream = require('webpack-stream');
const browserSync = require('browser-sync').create();


//  Flags for switching production and development mode.
/* global process */
const isDevelopment = process.argv.includes('--dev');
const isSync = process.argv.includes('--sync');

let devPath = {
    dest: './app'
};

let prodPath = {
    dest: './public'
};

const syncConfig = {
    /**
     *  This optional used fot the work php files
     *   proxy: '{SITENAME.LOC}',
     *
     server: {
        baseDir: './public/',
    },
     */
    proxy: 'cp.loc',
    logPrefix: 'limbo-zone',
    // tunnel: true,
    // https: false,
    // port: 9000,
    // notify: false
};

let webConfig = {
    output: {
        filename: 'script.js'
    },
    module: {
        rules: [
            {
                test: /\.js$/,
                loader: 'babel-loader',
                exclude: '/node_modules/'
            }
        ]
    },
    mode: isDevelopment ? 'development' : 'production',
    devtool: isDevelopment ? 'cheap-source-map' : 'none'
};

function removal() {
    return del([
        `${prodPath.dest}/**/*`,
        `!${prodPath.dest}/.htaccess`
    ]);
}

function styles() {
    return gulp.src(`${devPath.dest}/scss/style.scss`)
        .pipe(plumber())
        .pipe(gulpif(isDevelopment, sourcemaps.init()))
        .pipe(sass({
            includePaths: require('node-normalize-scss').includePaths
        }))
        .pipe(ggcmq())
        .pipe(autoprefixer({
            overrideBrowserslist: ['> 0.1%'],
            cascade: false
        }))
        .pipe(gulpif(!isDevelopment/* isProduction */, cleanCSS({
            level: 2
        })))
        .pipe(gulpif(isDevelopment, sourcemaps.write()))
        .pipe(gulp.dest(`${prodPath.dest}/css`))
        .pipe(gulpif(isSync, browserSync.stream()));
}

function smartGrid(complete) {
    delete require.cache[require.resolve('./smartgrid.js')];
    let options = require('./smartgrid.js');
    smart_grid(`${devPath.dest}/scss`, options);
    complete();
}

function scripts() {
    return gulp.src(`${devPath.dest}/js/entry-point.js`)
        .pipe(plumber())
        .pipe(webpackStream(webConfig))
        .pipe(gulp.dest(`${prodPath.dest}/js`))
        .pipe(gulpif(isSync, browserSync.stream()));
}

function fonts() {
    return gulp.src(`${devPath.dest}/font/**/*`)
        .pipe(gulp.dest(`${prodPath.dest}/font`))
}

function images() {
    return gulp.src(`${devPath.dest}/image/**/*`)
        .pipe(gulp.dest(`${prodPath.dest}/image`))
}

function html() {
    return gulp.src([
        `${devPath.dest}/**/*.html`,
        `!${devPath.dest}/template/**/*`
    ])
        .pipe(rigger())
        .pipe(gulp.dest(prodPath.dest))
        .pipe(gulpif(isSync, browserSync.stream()));
}

function watch() {
    if (isSync) {
        browserSync.init(syncConfig);
    }
    gulp.watch(`${devPath.dest}/scss/**/*.scss`, styles);
    gulp.watch('./smartgrid.js', smartGrid);
    gulp.watch(`${devPath.dest}/js/**/*.js`, scripts);
    gulp.watch(`${devPath.dest}/**/*.html`, html);
}

let build = gulp.series(removal,
    gulp.parallel(styles, scripts, html, fonts, images)
);

gulp.task('del', removal);
gulp.task('grid', smartGrid);
gulp.task('watch', gulp.series(build, watch));
gulp.task('build', gulp.series(smartGrid, build));
