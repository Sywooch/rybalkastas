const vm = new Vue({
    el: '#main',
    data: {
        shop_data: {},
        period: null
    },
    computed: {
        periods() {
            var resultList = [];
            var date = new Date("August 13, 2014");
            var endDate = (new Date()).setMonth((new Date()).getMonth() + 1);
            ;
            var monthNameList = ["Январь", "Февраль", "Март", "Апрель", "Май", "Июнь", "Июль", "Август", "Сентябрь", "Октябрь", "Ноябрь", "Декабрь"];

            while (date <= endDate) {
                var monthNum = (date.getMonth() + 1).toString();
                if (monthNum.length === 1) {
                    monthNum = "" + "0" + monthNum;
                }
                var stringDate = {
                    label: monthNameList[date.getMonth()] + " " + date.getFullYear(),
                    key: date.getFullYear() + '-' + monthNum
                };
                resultList.push(stringDate);
                date.setMonth(date.getMonth() + 1);
            }

            var rev = resultList.reverse();
            this.experts_period = rev[0].key;
            return rev;
        },
    },
    mounted()
    {
        this.loadCharts();
    },
    watch: {
        period: {
            handler: function(newv,oldv){
                this.loadCharts();
            }
        }
    },
    methods: {
        loadCharts(){
            var that = this;
            window.shops.forEach(function(element){
                if(window.charts[element.shopID]){
                    window.charts[element.shopID].destroy();
                }


                that.$set(that.shop_data, element.shopID, {});
                that.$set(that.shop_data[element.shopID], 'shop', element);
                axios.get('/reports/experts/load?shop='+element.shopID+'&month='+that.period).then((response) => {
                    that.shop_data[element.shopID].labels = response.data.labels;
                    that.shop_data[element.shopID].set = response.data.set;
                    window.charts[element.shopID] = new Chart(document.getElementById("expertsChart"+element.shopID).getContext('2d'), {
                        type: 'line',
                        data: {
                            labels: vm.$data.shop_data[element.shopID].labels,
                            datasets: vm.$data.shop_data[element.shopID].set
                        },
                        options: {
                            responsive: true,
                            showTooltips :true,
                            tooltips: {
                                enabled: true
                            },
                        }
                    });
                    window.charts[element.shopID].update();
                });
            });
        }
    }
});