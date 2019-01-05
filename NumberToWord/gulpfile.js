var gulp    = require('gulp'),
    gutil   = require('gulp-util'),
    uglify  = require('gulp-uglify'),
    concat  = require('gulp-concat'),
    notify  = require('gulp-notify'),
    compass = require('gulp-compass'),
    strip   = require('gulp-strip-comments'),
    minifyCSS = require('gulp-minify-css'),
    autoprefix = require('gulp-autoprefixer'),
    autoprefixer = require('gulp-autoprefixer'),
    stripCssComments = require('gulp-strip-css-comments');


var paths = {
    pathsCSS: [
        'public/vendor/bootstrap-3.3.4-dist/css/bootstrap.min.css',
        'public/vendor/font-awesome/css/font-awesome.min.css',
        'public/vendor/select2/select2.min.css',
        'public/vendor/select2/select2-bootstrap.min.css',
        'public/vendor/bootstrap-datepicker/datepicker3.css',
        'public/vendor/flexslider/css/flexslider.min.css',
        'public/vendor/webui-popover/dist/jquery.webui-popover.min.css',
        'public/vendor/perfect-scrollbar/css/perfect-scrollbar.min.css',
        'public/css/sass/app.css'
    ]
    , pathsJS: [
        'public/vendor/jquery/jquery-1.11.3.min.js',
        'public/vendor/bootstrap-3.3.4-dist/js/bootstrap.min.js',
        'public/vendor/jquery/jquery-1.11.4.ui.min.js',
        'public/vendor/flexslider/js/jquery.flexslider-min.js',
        'public/vendor/jquery-validate/jquery.validate.min.js',
        'public/vendor/select2/select2.min.js',
        'public/vendor/bootstrap-datepicker/bootstrap-datepicker.min.js',
        'public/vendor/truncate/truncate.min.js',
        'public/vendor/jquery-timeago/jquery.timeago.min.js',
        'public/vendor/momentjs/moment.min.js',
        'public/vendor/momentjs/moment-timezone-with-data.min.js',
        'public/vendor/webui-popover/dist/jquery.webui-popover.min.js',
        'public/vendor/perfect-scrollbar/js/min/perfect-scrollbar.jquery.min.js',
        'public/js/app.js'
    ]
};

//Task CSS
gulp.task('pathsCSSTask', function () {
    gulp.src(paths.pathsCSS)
        .pipe(minifyCSS())
        .pipe(concat('frontend.min.css'))
        .pipe(gulp.dest('public/static/css'));
});

//Task JS
gulp.task('pathsJSTask', function () {
    gulp.src(paths.pathsJS)
        .pipe(uglify())
        .pipe(concat('frontend.min.js'))
        .pipe(gulp.dest('public/static/js'));
});

gulp.task('copySourceTask', function () {
    //public/front/
    gulp.src('public/fonts/**/*')
        .pipe(gulp.dest('public/static/fonts'));
    //public/images/
    gulp.src('public/images/**/*')
        .pipe(gulp.dest('public/static/images'));
    //select2 image
    gulp.src('public/vendor/select2/select2.png')
        .pipe(gulp.dest('public/static/css'));
    //ZeroClipboard.swf
    gulp.src('public/js/ZeroClipboard.swf')
        .pipe(gulp.dest('public/static/js'));
    //vendor/font-awesome/front
    gulp.src('public/vendor/font-awesome/fonts/**/*')
        .pipe(gulp.dest('public/static/fonts'));
});

gulp.task('default', [
    'pathsCSSTask',
    'pathsJSTask',
    'copySourceTask'
]);
