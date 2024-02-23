const { createApp } = Vue;
const app = createApp({
    data() {
        return {
            formLabelAlign: {
                name: '',
                region: '',
                type: ''
            }
        };
    }
});
app.use(ElementPlus);
app.mount('#app');