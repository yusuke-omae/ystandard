const gulp = require('gulp');
const zip = require('gulp-zip');
const sass = require('gulp-sass');
const postcss = require('gulp-postcss');
const autoprefixer = require('autoprefixer');
const mqpacker = require('css-mqpacker');
const cssnano = require('cssnano');
const packageImporter = require('node-sass-package-importer');
const babel = require('gulp-babel');


/**
 * PostCssで使うプラグイン
 */
const postcssPlugins = [
    autoprefixer({overrideBrowserslist: ['last 2 version, not ie < 11']}),
    mqpacker(),
    cssnano()
];

/**
 * sass
 */
gulp.task('sass', () => {
    return gulp.src('./src/sass/*.scss')
        .pipe(sass({
            importer: packageImporter({
                extensions: ['.scss', '.css']
            })
        }))
        .pipe(postcss(postcssPlugins))
        .pipe(gulp.dest('./css'))
});
/**
 * sass - parts
 */
gulp.task('sass:parts', () => {
    return gulp.src('./src/sass/inline-parts/*.scss')
        .pipe(sass())
        .pipe(postcss(postcssPlugins))
        .pipe(gulp.dest('./src/css'))
});

/**
 * JS
 */
gulp.task('js', () => {
    return gulp.src('./src/js/*.js')
        .pipe(babel({
            presets: ['@babel/preset-env','minify']
        }))
        .pipe(gulp.dest('./js'))
});

/**
 * create zip file
 */
gulp.task('zip', function () {
    return gulp.src(
        [
            '**',
            '!node_modules',
            '!node_modules/**',
            '!gulpfile.js',
            '!package.json',
            '!package-lock.json',
            '!webpack.config.js',
            '!ystandard-info.json',
            '!ystandard-info-beta.json',
            '!phpcs.ruleset.dist',
            '!phpcs.ruleset.xml',
            '!phpunit.xml.dist',
            '!tests',
            '!tests/**',
            '!bin',
            '!bin/**',
            '!src',
            '!src/**',
            '!docs',
            '!docs/**',
            '!temp',
            '!temp/**',
            '!*.zip',
        ],
        {base: './'}
    )
        .pipe(zip('ystandard.zip'))
        .pipe(gulp.dest('./'));
});


/**
 * watch
 */
gulp.task('watch', () => {
    gulp.watch('./src/sass/**/*.scss', gulp.task('sass'));
    gulp.watch('./src/sass/**/*.scss', gulp.task('sass:parts'));
    gulp.watch('./src/js/**/*.js', gulp.task('js'));
});

/**
 * default
 */
gulp.task('default', gulp.task('watch'));
