const tailwindcss = require('tailwindcss')
const purgecss = require('@fullhuman/postcss-purgecss')
const autoprefixer = require('autoprefixer')
const postcssImport = require('postcss-import')

module.exports = {
    plugins: [
        postcssImport,
        tailwindcss,
        purgecss({
            content: ['./resources/js/**/*.vue'],
            whitelist: ["html", "body"],
            extractors: [
                {
                    extractor: class TailwindExtractor {
                        static extract(content) {
                            return content.match(/[A-z0-9-:\/]+/g) || [];
                        }
                    },
                    extensions: ["html", "vue"]
                }
            ]
        }),
        autoprefixer
    ]
}
