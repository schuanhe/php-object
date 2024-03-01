<?php
include 'Utils/TokenUtil.php';
$a = new TokenUtil();

$data = $a->generateToken("123aaa");

//echo $a->verifyToken($data);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Title</title>
    <!-- Import style -->
    <link rel="stylesheet" href="//cdn.jsdelivr.net/npm/element-plus/dist/index.css"/>
    <!-- Import Vue 3 -->
    <script src="//cdn.jsdelivr.net/npm/vue@3"></script>
    <!-- Import component library -->
    <script src="//cdn.jsdelivr.net/npm/element-plus"></script>
    <!-- Import axios -->
    <script src="//cdn.jsdelivr.net/npm/axios@1.6.7/dist/axios.min.js"></script>

</head>
<body>
<!--设置app铺满整个页面-->
<div id="app">
    <el-container>
        <el-header>
            <el-alert title="schuanhe 自用，其他人不能使用哦" type="success" :closable="false"/>
        </el-header>
        <el-main>
            <el-card class="box-card">
                <el-form
                        :label-position="labelPosition"
                        label-width="100px"
                        :model="form"
                        style="max-width: 460px"
                >

                    <el-tag type="primary">Tag 1</el-tag>

                    <el-form-item label="name">
                        <el-input v-model="form.name"/>
                    </el-form-item>
                    <el-form-item label="password">
                        <el-input v-model="form.password"/>
                    </el-form-item>
                    <el-button>Default</el-button>

                </el-form>
            </el-card>
        </el-main>
        <el-footer>Footer</el-footer>
    </el-container>
</div>
<script>
    /* global Vue, ElementPlus,axios */
    const {createApp, ref} = Vue;

    const App = {
        setup() {
            const form = ref({
                name: '',
                password: ''
            });
            return {form};

            // 使用登录方法
            const login = async () => {
            try {
                const response = await axios.post('./Controller/ControllerUser.php', {
                    method: 'login',
                    username: form.username,
                    password: form.password,
                });

                // 根据后端返回的数据进行处理
                if (response.data.success) {
                    ElMessage.success('登录成功');
                } else {
                    ElMessage.error('登录失败，用户名或密码错误');
                }
            } catch (error) {
                console.error('登录请求失败:', error);
                ElMessage.error('登录请求失败');
            }
        };


        }
    };

    const app = createApp(App);
    app.use(ElementPlus);
    app.mount('#app');
</script>
</body>
<style>
    body, html {
        height: 100%;
        margin: 0;
    }

    #app {
        height: 100%;
        width: 100%;
    }

    .box-card {
        max-width: 460px;
        margin: auto;
    }

    .el-main {
        /*    设置内部居中*/
        text-align: center;
        line-height: 60px;
    }
</style>
</html>
