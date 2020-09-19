/**
 * First, we will load all of this project's Javascript utilities and other
 * dependencies. Then, we will be ready to develop a robust and powerful
 * application frontend using useful Laravel and JavaScript libraries.
 */

require('./react');

require('./bootstrap');

require('./root');

if (document.getElementById('table_users')) {
    require('./users');
}


import './../sass/main.scss';
