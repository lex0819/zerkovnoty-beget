const gulp = require('gulp');
const del = require('del');
const autoprefixer = require('gulp-autoprefixer');
const cleanCSS = require('gulp-clean-css');
const sourcemaps = require('gulp-sourcemaps');
const gulpIf = require('gulp-if');
const gcmq = require('gulp-group-css-media-queries');
const webp = require('gulp-webp');
const less = require('gulp-less');
const fileinclude = require('gulp-file-include');
const browserSync = require('browser-sync').create();
const smartGrid = require('smart-grid');
const path = require('path');

let isMap = process.argv.includes('--map');
let isMinify = process.argv.includes('--clean');
let isSync = process.argv.includes('--sync');

function clean() {
   return del('./build/*');
}

function html() {
   return gulp.src('./src/*.html')
      .pipe(fileinclude({
         prefix: '@@',
         basepath: './src/htmls'
      }))
      .pipe(gulp.dest('./build'))
      .pipe(gulpIf(isSync, browserSync.stream()));
}

function styles() {
   return gulp.src('./src/css/style.less')
      .pipe(gulpIf(isMap, sourcemaps.init()))
      .pipe(less())
      .pipe(gcmq())
      .pipe(autoprefixer())
      .pipe(gulpIf(isMinify, cleanCSS({
         level: 2
      })))
      .pipe(gulpIf(isMap, sourcemaps.write()))
      .pipe(gulp.dest('./build/css'))
      .pipe(gulpIf(isSync, browserSync.stream()));
}

function images() {
   return gulp.src('./src/img/**/*')
      .pipe(gulp.dest('./build/img'));
}

function imagesWebp() {
   return gulp.src('./src/img/**/*')
      .pipe(webp())
      .pipe(gulp.dest('./build/img'));
}

function fonts() {
   return gulp.src('./src/fonts/*.*')
      .pipe(gulp.dest('./build/fonts'));
}

function jsJquery() {
   return gulp.src('./src/js/*.js')
      // silense
      .pipe(gulp.dest('./build/js'))
      .pipe(gulpIf(isSync, browserSync.stream()));
}

function grid(done) {
   delete require.cache[path.resolve('./smartgrid.js')];
   let options = require('./smartgrid.js');
   smartGrid('./src/css', options);
   done();
}

function watch() {
   if (isSync) {
      browserSync.init({
         server: {
            baseDir: "./build/"
         }
      });
   }

   gulp.watch('./src/css/**/*.less', styles);
   gulp.watch('./src/**/*.html', html);
   gulp.watch('./src/img/*.*', images);
   gulp.watch('./src/img/*.*', imagesWebp);
   gulp.watch('./src/fonts/*.*', fonts);
   gulp.watch('./src/js/*.js', jsJquery);
   gulp.watch('./smartgrid.js', grid);
}

let build = gulp.parallel(html, styles, images, imagesWebp, fonts, jsJquery);
let buildWithClean = gulp.series(clean, build);
let dev = gulp.series(buildWithClean, watch);

gulp.task('build', buildWithClean);
gulp.task('watch', dev);

gulp.task('grid', grid);