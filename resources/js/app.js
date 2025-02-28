import { createApp } from "vue/dist/vue.esm-bundler";

import RequestForm from './components/RequestForm.vue';
import RequestList from './components/RequestList.vue';

const app = createApp({});
app.component('request-form', RequestForm);
app.component('request-list', RequestList);
app.mount("#app");
