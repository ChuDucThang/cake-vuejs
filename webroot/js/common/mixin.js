// const HTTP = axios.create({
//     baseURL: 'http://cakeukit.com/api/',
//     headers: {
//       Authorization: 'Bearer {token}'
//     }
//   })
//async-await: Xu ly bat dong bo trong javascript
//Mixin Local
const BASE_URL = 'http://cakeuikit.com/api/';
const mixin = {
    data: function() {
        return {
            isLoading: false,
            fullPage: true,
            currentPage: 0,
            totalPage: 0,
            record: 0,
        }
    },
    mixins: [
        // mixindash
    ],
    created() {

    },
    methods: {
        async API(method, url, data = null, params = null, headers = { Authorization: 'Bearer {token}' }) {
            try {
                // this.loader = this.$loading.show({
                //     color: '#d20505',
                //     loader: 'spinner',
                // });
                this.$root.isLoading = true;
                let response = await axios({
                    method: method,
                    url: BASE_URL + url,
                    data: data,
                    params: params,
                    headers: headers
                });
                return response.data;
            } catch (error) {
                return {
                    status_code: "9999",
                    message: error.message,
                    data: [],
                    datetime: new Date().getTime(),
                }
            } finally {
                // this.loader.hide();
                setTimeout(() => {
                    this.$root.isLoading = false
                }, 2000)
            }
        },
        showSuccessToast(message) {
            showMessageToast(message);
        },
        showWarringToast(message) {
            showMessageToast(message, 'warning', 'exclamation');
        },
        showErrorToast(message) {
            showMessageToast(message, 'error', 'question circle');
        }
    }
}

function showMessageToast(message, clazz = 'info', icon = 'check') {
    $(document).toast({
        displayTime: 5000,
        class: clazz,
        showIcon: icon,
        message: message,
        transition: {
            showMethod: 'zoom',
            showDuration: 1000,
            hideMethod: 'fade',
            hideDuration: 1000
        }
    });
};
//Mixin global
// Vue.mixin({
//     data(){
//         return{

//         }
//     },
//     methods:{

//     }
// });