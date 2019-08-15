window.onload = function () { //避免爆代码


function GetQueryString(name)
{
     var reg = new RegExp("(^|&)"+ name +"=([^&]*)(&|$)");
     var r = window.location.search.substr(1).match(reg);//search,查询？后面的参数，并匹配正则
     if(r!=null)return  unescape(r[2]); return null;
}

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
                    data: null,
                    key: null
                }
            }
        },
        methods: {
            start_query: function () {
                this.display.status = false;
                this.display.loading = true;

                var string = '';
                var i = -1;
                $('input[name=input]').each(function () {
                    i += 1;
                    string += $('#' + i).text() + '|' + $(this).val() + '|';
                });

                string = string.substr(0, string.length - 1);

                //防止微信加 token
				var id_string = GetQueryString("id");
				if(!!id_string.split('/?')[0]){
					id_string = id_string.split('/?')[0];
                }
                
                axios.get('api?string=' + string + '&id=' + id_string)
                    .then(re => {
                        if (re.data.status) {
                            this.display.data = re.data.source_array;
                            this.display.key = re.data.key_array;
                            this.display.loading = false;
                            this.display.status = true;
                        } else {
                            this.display.loading = false;
                            alert(re.data.msg);
                        }
                    })
            },
        }
    });
}