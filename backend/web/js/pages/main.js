const vm = new Vue({
    el: '#main',
    data: {
        bymonth: {
            labels: [],
            sets: {
                new: [],
                cancelled: [],
                done: [],
                all: []
            },
        },
        users: {
            labels: [],
            set: []
        },
        experts: {
            labels: [],
            set: []
        },
        gangs: {
            labels: [],
            set: []
        },
        experts_period: null,
        gangs_period: null,
    },
    mounted() {
        axios.get('/site/load-orders?type=all').then((response) => {
            this.bymonth.labels = response.data.labels;
            this.bymonth.sets.all = response.data.set;
        });
        axios.get('/site/load-orders?type=new').then((response) => {
            this.bymonth.labels = response.data.labels;
            this.bymonth.sets.new = response.data.set;
        });
        axios.get('/site/load-orders?type=cancelled').then((response) => {
            this.bymonth.labels = response.data.labels;
            this.bymonth.sets.cancelled = response.data.set;
        });
        axios.get('/site/load-orders?type=done').then((response) => {
            this.bymonth.labels = response.data.labels;
            this.bymonth.sets.done = response.data.set;
        });
        axios.get('/site/load-activity').then((response) => {
            this.users.labels = response.data.labels;
            this.users.set = response.data.set;
        });
        axios.get('/site/load-experts-data').then((response) => {
            this.experts.labels = response.data.labels;
            this.experts.set = response.data.set;
            initChartExperts();
        });
        axios.get('/site/load-gang-data').then((response) => {
            this.gangs.labels = response.data.labels;
            this.gangs.set = response.data.set;
        });
    },
    watch: {
        bymonth: {
            handler: function (newVal, oldVal) {
                if (chart) {
                    chart.destroy();
                }
                initChart();
            },
            deep: true
        },
        users: {
            handler: function (newVal, oldVal) {
                if (chartUsers) {
                    chartUsers.destroy();
                }
                initUserActivity();
            },
            deep: true
        },
        experts: {
            handler: function (newVal, oldVal) {
                if (chartExperts) {
                    chartExperts.destroy();
                }
                if(oldVal.set){
                    initChartExperts();
                }
            },
            //deep: true
        },
        gangs: {
            handler: function (newVal, oldVal) {
                if (chartGangs) {
                    chartGangs.destroy();
                }
                if(oldVal.set){
                    initChartGangs();
                }
            },
            deep: true
        },
        experts_period:{
            handler: function (newVal, oldVal) {
                this.experts = {
                    labels: [],
                    set: []
                };
                axios.get('/site/load-experts-data?ordersMonth='+newVal).then((response) => {
                    this.experts.labels = response.data.labels;
                    this.experts.set = response.data.set;
                    initChartExperts();
                });
            }
        },
        gangs_period:{
            handler: function (newVal, oldVal) {
                this.gangs = {
                    labels: [],
                    set: []
                };
                axios.get('/site/load-gang-data?ordersMonth='+newVal).then((response) => {
                    this.gangs.labels = response.data.labels;
                    this.gangs.set = response.data.set;
                });
            }
        }
    },
    computed: {
        periods(){
            var resultList = [];
            var date = new Date("August 13, 2014");
            var endDate = (new Date()).setMonth((new Date()).getMonth() + 1);;
            var monthNameList = ["Январь", "Февраль", "Март", "Апрель", "Май", "Июнь", "Июль", "Август", "Сентябрь", "Октябрь", "Ноябрь", "Декабрь"];

            while (date <= endDate)
            {
                var monthNum = (date.getMonth() + 1).toString();
                if(monthNum.length === 1){
                    monthNum = "" + "0" + monthNum;
                }
                var stringDate = {label:monthNameList[date.getMonth()] + " " + date.getFullYear(), key: date.getFullYear()+'-'+monthNum};
                resultList.push(stringDate);
                date.setMonth(date.getMonth() + 1);
            }

            var  rev = resultList.reverse();
            this.experts_period = rev[0].key;
            return rev;
        },
        splitManagers()
        {
            var ar = {};
            if(!this.experts.set) return {};
            this.experts.set.forEach(function(element){
                ar[element.shop] = [];
            });

            this.experts.set.forEach(function(element, i){
                ar[element.shop].push({name:element.label, gang:element.gang, link:element, index: i});
            });


            return ar;
        }
    },
    methods: {
        updateChart(){
            chartExperts.update();
        },
        expertsGangUnchecked(gang){
            items = this.experts.set.filter(item => item.gang === gang);
            var unchecked = false;
            items.forEach(function(element){
                if(!element.hidden) unchecked = true;
            })
            return unchecked;
        },
        expertsCheckByGang(gang){
            items = this.experts.set.filter(item => item.gang === gang);
            if(this.expertsGangUnchecked(gang)){
                items.forEach(function(element){
                    element.hidden = true;
                })
            } else {
                items.forEach(function(element){
                    element.hidden = false;
                })
            }
            chartExperts.update();
        }
    }
});
var chart;

function initChart() {
    if (vm) {
        chart = new Chart(document.getElementById("monthChart").getContext('2d'), {
            type: 'line',
            data: {
                labels: vm.$data.bymonth.labels,
                datasets: [
                    {
                        label: 'Не обработанные',
                        data: vm.$data.bymonth.sets.new,
                        backgroundColor: 'rgba(196, 196, 196,0.4)',
                        borderColor: 'rgba(196, 196, 196,1)',
                        borderWidth: 1,
                        fill: true
                    },
                    {
                        label: 'Отмененные',
                        data: vm.$data.bymonth.sets.cancelled,
                        backgroundColor: 'rgba(178,34,34,0.6)',
                        borderColor: 'rgba(178,34,34,1)',
                        borderWidth: 1,
                        fill: true
                    },
                    {
                        label: 'Закрытые',
                        data: vm.$data.bymonth.sets.done,
                        backgroundColor: 'rgba(0, 170, 255, 0.5)',
                        borderColor: 'rgb(0, 170, 255)',
                        borderWidth: 1,
                        fill: true
                    },
                    {
                        label: 'Все заказы',
                        data: vm.$data.bymonth.sets.all,
                        backgroundColor: 'rgba(255, 161, 69, 1)',
                        borderColor: '#ffa145',
                        borderWidth: 1,
                        fill: true
                    },
                ]
            },
            options: {
                responsive: true,
                showTooltips :true,
                tooltips: {
                    enabled: true
                },
                maintainAspectRatio: false
            }
        });
    }

}

var chartUsers;

function initUserActivity()
{
    if (vm) {
        chartUsers = new Chart(document.getElementById("activityChart").getContext('2d'), {
            type: 'line',
            data: {
                labels: vm.$data.users.labels,
                datasets: [
                    {
                        label: 'Количество уникальных посетителей',
                        data: vm.$data.users.set,
                        backgroundColor: 'rgba(245, 97, 255, 0.7)',
                        borderColor: 'rgba(245, 97, 255, 1)',
                        borderWidth: 1,
                        fill: true
                    }
                ]
            },
            options: {
                responsive: true,
                showTooltips :true,
                tooltips: {
                    enabled: true
                },
                maintainAspectRatio: false
            }
        });
    }
}

var chartExperts;

function initChartExperts()
{
    if (vm) {
        chartExperts = new Chart(document.getElementById("expertsChart").getContext('2d'), {
            type: 'line',
            data: {
                labels: vm.$data.experts.labels,
                datasets: vm.$data.experts.set
            },
            options: {
                responsive: true,
                showTooltips :true,
                tooltips: {
                    enabled: true
                },
                maintainAspectRatio: false,
                legend: {
                    display: false
                },
            },
        });
    }
}

var chartGangs;

function initChartGangs()
{
    if (vm) {
        chartGangs = new Chart(document.getElementById("gangsChart").getContext('2d'), {
            type: 'line',
            data: {
                labels: vm.$data.gangs.labels,
                datasets: vm.$data.gangs.set
            },
            options: {
                responsive: true,
                showTooltips :true,
                tooltips: {
                    enabled: true
                },

            }
        });
    }
}