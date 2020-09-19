var path = require('path');
var webpack = require('webpack');
const CopyPlugin = require('copy-webpack-plugin');

var isProduction =
    process.argv.indexOf('-p') >= 0 || process.env.NODE_ENV === 'production';
// var sourcePath = path.join(__dirname, './src');
// var outPath = path.join(__dirname, './public/js');

module.exports = {
    devtool: 'eval',
    mode: isProduction ? 'production' : 'development',
    entry: [
        // 'webpack-dev-server/client?http://localhost:3000',
        './resources/js/app.ts'
    ],
    output: {
        path: path.join(__dirname, 'public/js'),
        filename: 'app.js',
    },
    resolve: {
        extensions: ['.js', '.ts', '.tsx'],
        alias: {
            '@react': path.resolve(__dirname, 'resources/js/react'),
            '@core': path.resolve(__dirname, 'resources/js/react/core'),
            '@img': path.resolve(__dirname, 'resources/img'),
        },
    },
    module: {
        rules: [
            {
                test: /\.tsx?$/,
                use: [
                    !isProduction && {
                        loader: 'babel-loader'
                    },
                    'ts-loader'
                ].filter(Boolean)
            },
            {
                test: /\.(css|scss)$/,
                use: ['style-loader', 'css-loader'],
            },
            {
                test: /\.(png|svg|jpe?g|gif)$/i,
                loader: 'file-loader',
                options: {
                    name: '[name].[ext]',
                    outputPath: '../images'
                },

            },
        ]
    },
    // TODO remove this block plugins if do not use before 01.01.2021 (this copy files generated extjs watch script)
    // plugins: [
    //     new CopyPlugin({
    //         patterns: [
    //             {
    //                 from: path.join(__dirname,'./resources/js/statistic/bootstrap.js'),
    //                 to: path.join(__dirname, 'public/statistic')
    //             },
    //             {
    //                 from: path.join(__dirname,'./resources/js/statistic/index.html'),
    //                 to: path.join(__dirname, 'public/statistic')
    //             },
    //             {
    //                 from: path.join(__dirname,'./resources/js/statistic/classic.json'),
    //                 to: path.join(__dirname, 'public/statistic')
    //             },
    //             {
    //                 from: path.join(__dirname,'./resources/js/statistic/app.js'),
    //                 to: path.join(__dirname, 'public/statistic')
    //             },
    //             {
    //                 from: path.join(__dirname,'./resources/js/statistic/ext/classic/'),
    //                 to: path.join(__dirname, 'public/statistic/ext/classic/')
    //             },
    //             {
    //                 from: path.join(__dirname,'./resources/js/statistic/build/development/'),
    //                 to: path.join(__dirname, 'public/statistic/build/development/')
    //             },
    //             {
    //                 from: path.join(__dirname,'./resources/js/statistic/ext/build/ext-all-rtl-debug.js'),
    //                 to: path.join(__dirname, 'public/statistic/ext/build/')
    //             },
    //             {
    //                 from: path.join(__dirname,'./resources/js/statistic/app/'),
    //                 to: path.join(__dirname, 'public/statistic/app/')
    //             },
    //             {
    //                 from: path.join(__dirname,'./resources/js/statistic/classic/'),
    //                 to: path.join(__dirname, 'public/statistic/classic/')
    //             },
    //         ],
    //     }),
    // ],
};
