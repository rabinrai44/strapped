var gulp            = require('gulp'),
    watch           = require('gulp-watch'),
    uglify          = require('gulp-uglify'),
    rename          = require('gulp-rename'),
    notify          = require('gulp-notify'),
    sass            = require('gulp-sass'),
    bower           = require('gulp-bower'),
    zip             = require('gulp-zip'),
    plumber         = require('gulp-plumber'),
    jshint          = require('gulp-jshint'),
    include         = require('gulp-include'),
    imagemin        = require('gulp-imagemin'),
    stylish         = require('jshint-stylish'),
    autoprefixer    = require('gulp-autoprefixer'),
    livereload      = require('gulp-livereload');
    
    var config = {
        bowerDir: './bower_components'
    }

/**
 * Default ERROR Handler 
 */
var onError = function(err) {
    console.log('An ERROR occured:', err.message);
    this.emit('end');
}

/**
 * Zip file UP
 */
gulp.task('zip', function() {
    return gulp.src([
        '*',
        './fonts/*',
        './inc/*',
        './js/**/*',
        './languages/*',
        './sass/**/*',
        './template-pats/*',
        '!bower_components',
        '!node_modules',
    ], { base: "." })
    .pipe(zip('strapped.zip'))
    .pipe(gulp.dest('.'));
});

/**
 * Install all Bower Components 
 */
gulp.task('bower', function() {
    return bower()
        .pipe(gulp.dest(config.bowerDir))
});

//Fonts icons
gulp.task('icons', function() {
    return gulp.src(config.bowerDir + '/fontawesome/fonts/**.*')
        .pipe(gulp.dest('./fonts'));
});

/**
 * JShint outputs any kind of JavaScript problem you might have 
 * Only checks JavaScript file inside /src directory
 */
gulp.task('jshint', function() {
    return gulp.src('./js/src/*.js')
        .pipe(jshint())
        .pipe(jshint.reporter( stylish ))
        .pipe(jshint.reporter( 'fail' ));
});

/**
 * Concatenates all files that it finds in the manifest 
 * and creates two versions: normal and minified
 * It's dempendent on the jshint task to succeed
 */
gulp.task('scripts', ['jshint'], function() {
    return gulp.src('./js/minifest.js')
        .pipe( include())
        .pipe( rename({ basename: 'scripts' }))
        .pipe(gulp.dest('./js/dist'))
        //Normal done, time to create the minified js (scripts.min.js)
        // remove the following 3 lines if you don't want it
        .pip(uglify())
        .pipe(rename({ suffix: '.min' }))
        .pipe(gulp.dest('./js/dist'))
        .pipe(notify({ title: 'JavaScript', message: 'scripts task complete' }))
        //.pipe(livereload());
});

/**
 * Different options for the Sass tasks 
 */
var options = {};
options.sass = {
    errLogToConsole: true,
    precision: 8,
    noCache: true,
    //imagePath: 'assets/img',
    includePaths: [
        config.bowerDir + '/bootstrap-sass/assets/stylesheets',
        config.bowerDir + '/fontawesome/scss',
    ]
};

options.sassmin = {
    errLogToConsole: true,
    precision: 8,
    noCache: true,
    outputStyle: 'compressed',
    //imagePaths: 'assets/img',
    includePaths: [
        config.bowerDir + '/bootstrap-sass/assets/stylesheets',
        config.bowerDir + '/fontawesome/scss',
    ]
};


/**
 * Sass 
 */
gulp.task('sass', function() {
    return gulp.src('./sass/style.scss')
        .pipe(plumber())
        .pipe(sass(options.sass))
        .pipe(autoprefixer())
        .pipe(gulp.dest('.'))
        .pipe(notify({ title: 'sass', message: 'sass task complete' }));
});

/**
 * Sass-min 
 * Release build minifies CSS after compiling Sass.
 */
gulp.task('sassMin', function() {
    return gulp.src('./sass/style.scss')
        .pipe(plumber())
        .pipe(sass(options.sassmin))
        .pipe(autoprefixer())
        .pipe(rename({ suffix: '.min' }))
        .pipe(gulp.dest('.'))
        .pipe(notify({ title: 'Sass', message: 'sassMin task complete' }));
});

/**
 * Optimizes Images 
 */
gulp.task('images', function() {
    return gulp.src('./images/**/*')
        .pipe(imagemin({ progressive: true, svgoPlugins: [{ removeViewBox: false }]}))
        .pipe(gulp.dest('./images'))
        .pipe(notify({ title: 'Images', message: 'images task complete' }));
});


/**
 * Start the livereload server and Wath fiel for changes 
 */
gulp.task('watch', function() {
    livereload.listen();

    // do not listen to whole js folder, it'll create an infinite loop
    gulp.watch(['./js/**/*.js', '!./js/dist/*.js' ], ['scripts'])
    gulp.watch('./sass/**/*.scss', ['sass']);
    gulp.watch('./images/**/*', ['images']);
    gulp.watch('./**/*.php').on('change', function(file){
        // reload browser whenever any PHP file changes 
        // livereload.changed(file);
    });
});

/**
 * Gulp Default task 
 */
gulp.task('default', ['watch'], function() {
    //Does nothing in this task 
});