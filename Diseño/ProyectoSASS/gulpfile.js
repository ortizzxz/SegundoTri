const gulp = require("gulp");
const sass = require("gulp-sass")(require("sass"));
const browserSync = require("browser-sync").create();
const cssmin = require("gulp-cssmin");
const rename = require("gulp-rename");
const {src, dest} = require('gulp');

// Compilar SCSS a CSS y recargar el navegador
gulp.task("sass", function () {
  return gulp
    .src("./scss/**/*.scss")
    .pipe(
      sass({
        outputStyle: "compressed",
        includePaths: ["node_modules"],
        quietDeps: true,
      }).on("error", sass.logError)
    )
    .pipe(gulp.dest("./css"))
    .pipe(browserSync.stream()); //  CSS sin recargar la página
});

// Servidor de desarrollo y observador de cambios
gulp.task("serve", function () {
  browserSync.init({
    server: "./",
  });

  gulp.watch("./scss/**/*.scss", gulp.series("sass"));
  gulp.watch("./*.html").on("change", browserSync.reload);
  gulp.watch("./js/**/*.js").on("change", browserSync.reload); 
});

// Minificar CSS
function minimize(){
  return gulp.src('./css/main.css')
  .pipe(cssmin())
  .pipe(rename({suffix: '.min', extname: '.css'}))
  .pipe(dest('./dist/css'));
}

// Tarea por defecto
gulp.task("default", gulp.series("sass", "serve"));

// Exportar, tercera parte
exports.minimize=minimize;