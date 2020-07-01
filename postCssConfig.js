const mix = require("laravel-mix");

class LaravelMixPostCssConfigPlugin {

    name() {
        return "postCssConfig";
    }

    dependencies() {
        return ["postcss-loader"];
    }

    register(options = {}) {
        this.options = options;
    }

    webpackRules() {
        return {
            rules: [
                {
                    test: /\.css/,
                    use: [{loader: "postcss-loader", options: this.options}]
                }
            ]
        };
    }
}

mix.extend("postCssConfig", new LaravelMixPostCssConfigPlugin());
