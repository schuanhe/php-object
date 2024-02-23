<?php
include 'utils/TokenUtil.php';
$a = new TokenUtil();

$data = $a->generateToken("123aaa");

echo $a->verifyToken($data);
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

</head>
<body>
<div id="app">
    <el-button>Default</el-button>
    <el-button type="primary">Primary</el-button>
    <el-button type="success">Success</el-button>
    <el-button type="info">Info</el-button>
    <el-button type="warning">Warning</el-button>
    <el-button type="danger">Danger</el-button>
        <el-container>
            <el-header>Header</el-header>
            <el-main>
                <el-card class="box-card">
                    <el-form
                            :label-position="labelPosition"
                            label-width="100px"
                            :model="formLabelAlign"
                            style="max-width: 460px"
                    >
                        <el-form-item label="Name">
                            <el-input v-model="formLabelAlign.name" />
                        </el-form-item>
                        <el-form-item label="Activity zone">
                            <el-input v-model="formLabelAlign.region" />
                        </el-form-item>
                        <el-form-item label="Activity form">
                            <el-input v-model="formLabelAlign.type" />
                        </el-form-item>
                    </el-form>
                </el-card>
            </el-main>
            <el-footer>Footer</el-footer>
        </el-container>
</div>

<script>
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
</script>
</body>
</html>
