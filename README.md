Monero website forum
====================

This repo contains the code for forum.getmonero.org

It also contains site-wide CSS and JS code used for other parts of getmonero.org.

## JS / CSS Overview

### Requirements

Bootstrap / Gulp is used to minify the human-readable source JavaScript and CSS files for the entire getmonero.org website (including Moneropedia, homepage, Forum, etc).

You can install requirements via `npm`:

    npm install -g gulp-cli
    npm install gulp-concat gulp-minify-css gulp-uglify

You can then just type `gulp` to execute *all* tasks or take a look in `gulpfile.js` for granular options.

### CSS

* Source files are located here: `app/assets/css/*.css`
* Intermediary _minified_ files are stored here: `app/assets/css/min/*.css`
* Final 'compiled' version: `public/style.css`
* Final version served to users: https://static.getmonero.org/style.css

### JavaScript

* Source files are located here: `app/assets/js/*.js`
* Intermediary _minified_ files are stored here: `app/assets/js/min/*.js`
* Final 'compiled' version: `public/scripts.js`
* Final version served to users: https://static.getmonero.org/scripts.js

## Making CSS / Javascript changes to the website

1. Ensure your changes are in the _live_ css or js file listed above.
   * You can experiment with and test simple CSS changes in-browser using developer tools.
2. Fork this repo.
3. Locate the corresponding cede under `app/assets/`
   * Do a recursive search through this repo *AND* [monero-project/monero-site](https://github.com/monero-project/monero-site) to ensure that your changes will not have any unintended effects.
4. Make the required change, keeping it as focused and simple as possible.
5. Run the `gulp` task to generate new file(s) under `public/`.  You will also get an intermediary `min` file for each file changed.
6. Create a GitHub Pull Request, explaining:
   * What is the issue / enhancement being addressed.
   * Any related background info / discussion that helps to establish context.
   * Explain what research / testing was done (prove that you are not breaking the site with this change and that the change is a worthwhile improvement)

# PHP Backend code

TODO: Document this (Pull Requests welcome :-)
