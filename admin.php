<?php
if (!!explode('/?', $_GET['auth'])[0]) {
    $auth = explode('/?', $_GET['auth'])[0];
} else {
    $auth = $_GET['auth'];
}
if ($auth == 'xxxxxxx') { ?>
<!DOCTYPE html>
<html>

<head>
    <meta charset=utf-8>
    <meta name=viewport content="width=device-width,initial-scale=1">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <title>安徽工程大学团委数据录入系统</title>
    <script type="text/javascript" src="https://static.ouorz.com/vue.min.js"></script>
    <script>
        Vue.config.devtools = true
    </script>
    <script type="text/javascript" src="https://static.ouorz.com/axios.min.js"></script>
    <script src="https://static.ouorz.com/popper.min.js"></script>
    <link rel="stylesheet" href="https://static.ouorz.com/bootstrap.min.css">
    <script src="https://static.ouorz.com/jquery-3.3.1.min.js"></script>
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <div id="app" class="app">
        <div id="view" style="opacity: 0">
            <div class="div-1">
                <div class="div-2">
                    <h3>安徽工程大学团委数据录入系统</h3>
                </div>

                <div class="admin-file">

                    <?php

                        $hostdir = dirname(dirname(__FILE__)) . '/ahpu/data/'; //要读取的文件夹
                        $filesnames = scandir($hostdir); //得到所有的文件
                        $i = 0;

                        foreach ($filesnames as $name) {
                            ++$i;
                            if ($i > 2) { ?>
                    <p @click="get_sample('<?php echo $name; ?>')"><?php echo $name; ?></p>
                    <?php
                            }
                        } ?>

                </div>

                <div v-if="!!sample_raw" class="admin-raw">
                    <p>{{ sample_raw }}</p>
                </div>

                <div v-if="end" class="admin-raw">
                    <p>访问地址: <a :href="'http://q.ahpuccit.cn/query/?id='+sample_name.split('.')[0]">{{ 'http://q.ahpuccit.cn/query/?id='+sample_name.split('.')[0] }}</a></p>
                </div>

                <div class="div-3 admin-div" v-if="!!sample" v-for="i in sample">
                    <p class="input-id admin-input" v-html="i"></p>
                    <select class="admin-select" name="type">
                        <option value="integer">Integer</option>
                        <option value="string">String</option>
                    </select>
                </div>

                <div class="div-5 admin-submit">
                    <button type="button" class="button-1 button-admin" style="width:50vh;border-radius:4px" @click="start_transfer">提交</button>
                </div>

                <div class="div-6" v-if="display.loading">
                    <p>Loading...</p>
                </div>
            </div>
        </div>
        <script type="text/javascript" src="statics/admin.js?token=<?php echo rand(0,10000); ?>"></script>
</body>

</html>

<?php } ?>
