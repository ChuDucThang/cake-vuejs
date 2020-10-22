<script type="text/x-template" id="calendar-template">
     <div class="ui calendar" :id="id_calendar">
        <div class="ui input left icon">
            <i class="calendar icon"></i>
            <input type="text" v-model="calendar" :placeholder="[placeholder ? placeholder : '']">
        </div>
    </div>
</script>
<script>
    Vue.component('calendar', {
        template: '#calendar-template',
        props: {
            type:{
                type: String
            },
            formater:{
                type: String
            },
            id:{
                type: String
            },
            placeholder: {
                type: String
            }
        },
        data() {
            return {
               id_calendar: `calendar_${this._uid}`,
               calendar: ''
            }
        },
        model: {
            prop: "val",
            event: "change"
        },
        mounted() {
            let self = this;
            let calendarOpts = {
                type: 'date',
                formatter: {
                    date: function (date, settings) {
                        if (!date) return '';
                        var day = date.getDate();
                        var month = date.getMonth() + 1;
                        var year = date.getFullYear();
                        return day + '/' + month + '/' + year;
                    }
                },
                onChange: function(date, text, mode) {
                    if(date == undefined) {
                        self.$emit('change', '');
                    } else {
                        self.$emit('change', moment(date).format('DD/MM/YYYY'));
                    }
                },
                popupOptions: {
                    observeChanges: false
                }
            };
            let calendar = `#${self.id_calendar}`;
            $(calendar).calendar(calendarOpts);
        }
    })
</script>
