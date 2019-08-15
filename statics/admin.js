window.onload = function () { //避免爆代码

    $('#view').css('opacity', '1');

    var query = new Vue({
        el: '#app',
        data() {
            return {
                form: {
                    id: null,
                    name: null
                },
                display: {
                    loading: false,
                    status: false,
                    data: null
                },
                key_count: 1,
                sample: null,
                sample_name: null,
                sample_raw: null,
                end: false
            }
        },
        methods: {
            start_transfer: function () {
                this.display.status = false;
                this.display.loading = true;
                var k = -1;
                var string = '';
                $('select[name=type]').each(function () {
                    k++;
                    string += query.sample[k] + '|' + $(this).val() + '|';
                })

                var query_string = "string=" + string.substr(0, string.length - 1) + "&file=" + this.sample_name;
                axios.post(
                        'api/transfer.php',
                        query_string
                    )
                    .then(re => {
                        if (re.data.status) {
                            this.display.loading = false;
                            alert('录入成功');
                            this.sample = null;
                            this.sample_raw = null;
                            this.sample_name = null;
                            this.end = true;
                        } else {
                            alert(re.data.msg);
                            this.display.loading = false;
                        }
                    })

            },
            get_sample: function (name) {
                this.display.loading = true;
                axios.get('api/sample.php?name=' + name)
                    .then(re => {
                        if (re.data.status) {
                            this.sample = re.data.source;
                            this.sample_raw = re.data.raw;
                            this.sample_name = name;
                            this.display.loading = false;
                        } else {
                            alert('获取信息失败');
                            this.display.loading = false;
                        }
                    })
            },
        }
    });
}