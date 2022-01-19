
import Vue from "vue";
require('./bootstrap');

const files = require.context("./", true, /\.vue$/i);
files.keys().map(key =>
    Vue.component(
        key
            .split("/")
            .pop()
            .split(".")[0],
        files(key).default
    )
);

// import axios from "axios";
Vue.config.productionTip = false;

import API from "./api/index.js";
import EventDispatcher from "./service/EventDispatcher.js";
import DateFormatter from "./service/DateFormatter";
import InputFormatter from './service/InputFormatter';
import VueHtmlToPaper from 'vue-html-to-paper';
import 'file-viewer';

Vue.prototype.$API = API;
Vue.prototype.$EventDispatcher = new EventDispatcher();
Vue.prototype.$df = new DateFormatter();
Vue.prototype.$IF = new InputFormatter();
Vue.prototype.$htmlToPaper = VueHtmlToPaper;


const options = {
    name: '_blank',
    specs: [
      'fullscreen=yes',
      'scrollbars=yes'
    ],
    styles: [
      'https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css',
      'https://unpkg.com/element-ui/lib/theme-chalk/index.css',
      'https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700',
      '/theme/admin/plugins/global/plugins.bundle.css',
      '/theme/admin/plugins/custom/prismjs/prismjs.bundle.css',
      '/theme/admin/css/style.bundle.css',
      '/theme/admin/css/themes/layout/header/base/light.css',
      '/theme/admin/css/themes/layout/header/menu/light.css',
      '/theme/admin/css/themes/layout/brand/dark.css',
      '/theme/admin/css/themes/layout/aside/dark.css',
      '/css/app.css',
    ],
    timeout: 1000, // default timeout before the print window appears
    autoClose: true, // if false, the window will not close after printing
    windowTitle: window.document.title, // override the window title
  }

import router from "./router";
import ElementUI from "element-ui";
import "element-ui/lib/theme-chalk/index.css";
import "element-ui/lib/theme-chalk/display.css";
import VueIframe from 'vue-iframes'

Vue.use(VueIframe)
Vue.use(VueHtmlToPaper, options);
import locale from "element-ui/lib/locale/lang/en";
Vue.use(ElementUI, { locale, size: "small" });


const app = new Vue({
    el: '#app',
    router,
});
