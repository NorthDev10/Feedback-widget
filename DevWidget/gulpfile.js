var gulp         = require('gulp'),
    scss         = require('gulp-sass'),
    concat       = require('gulp-concat'),
    uglify       = require('gulp-uglifyjs'),
    cssnano      = require('gulp-cssnano'),
    rename       = require('gulp-rename'),
    del          = require('del'),
    autoprefixer = require("gulp-autoprefixer"),
    args         = require('yargs').argv;
    
gulp.task('scss', function() {
    if(args.projectName) {
        return gulp.src([args.projectName+'/app/scss/**/*.scss'])
        .pipe(scss())
        .pipe(autoprefixer({browsers: ['> 1%'], cascade: true}))
        //.pipe(cssnano())
        .pipe(rename({suffix: '.min'}))
        .pipe(gulp.dest(args.projectName+'/dist/css'));
    }
});

gulp.task('clean', function() {
    if(args.projectName) {
        console.log(args.projectName);
        return del.sync(args.projectName+'/dist/css/');
    }
});

gulp.task('watch', ['clean'], function() {
    if(args.projectName) {
        gulp.watch(args.projectName+'/app/scss/**/*.scss', ['scss']);
    }
});