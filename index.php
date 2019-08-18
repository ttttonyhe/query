<?php
if(!!$_GET['id']){ ?>
<!DOCTYPE html>
<html>

<head>
    <meta charset=utf-8>
    <meta name=viewport content="width=device-width,initial-scale=1">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <title>安徽工程大学团委查询系统</title>
    <script type="text/javascript" src="https://static.ouorz.com/vue.min.js"></script>
    <script type="text/javascript" src="https://static.ouorz.com/axios.min.js"></script>
    <script src="https://static.ouorz.com/popper.min.js"></script>
    <link rel="stylesheet" href="https://static.ouorz.com/bootstrap.min.css">
    <script src="https://static.ouorz.com/jquery-3.3.1.min.js"></script>
    <link rel="stylesheet" href="style.css">
    <script type="text/javascript">
    var useragent = navigator.userAgent;
    if (useragent.match(/MicroMessenger/i) != 'MicroMessenger') {
        alert('⚠ 请使用微信访问本页');
        var opened = window.open('about:blank', '_self');
        opened.opener = null;
        opened.close();
    }
       document.addEventListener('WeixinJSBridgeReady', function onBridgeReady() {
       		WeixinJSBridge.call('hideOptionMenu');
       });
</script>
</head>

<body>
    <div id="app" class="app">
        <div id="view" style="opacity: 0">
            <div class="div-1">
                <?php
                $name = $_GET['id'];
                //防止微信后缀
                if(!!explode('/?',$name)[0]){
                    $name = explode('/?',$name)[0];
                }
                $file = json_decode(file_get_contents('../data/' . $name . '.json'));
                ?>
                <div class="div-2">
                    <h3><?php echo $file->title ?></h3>
                </div>
                <?php
                $k = -1;
                for ($i = 0; $i < count($file->keys); $i++) {
                    if ($file->keys[$i]->type) {
                        $k += 1;
                        ?>
                <div class="div-3">
                    <div class="query-title"><p class="b-id" id="<?php echo $k; ?>"><?php echo $file->keys[$i]->name ?></p></div>
                    <div><input type="text" placeholder="请输入<?php echo $file->keys[$i]->name; ?>" name="input" class="input-id"></div>
                </div>
                <?php }
                } ?>

            </div>
            <div class="div-5">
                <button type="button" class="button-1" @click="start_query">查询</button>
            </div>

            <div v-if="display.status" class="result" v-for="(re,index_re) in display.data">
                <p v-for="(key,index) in display.key" v-if="key !== 'id'"><b v-html="key"></b> : {{ display.data[index_re][index] }}</p>
            </div>
            
            <div class="div-6" v-if="display.loading">
                <p>Loading...</p>
            </div>
            <div class="footer">
                <p>©2019 <?php echo $file->copyright ?> 版权所有</p>
            </div>
        </div>
    </div>
    <script type="text/javascript" src="statics/app.js?token=<?php echo rand(0,10000); ?>"></script>
</body>

</html>

<?php } ?>