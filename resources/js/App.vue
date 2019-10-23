<template>
    <div>
        <h1>Hello, {{ msg }}!</h1>
        <router-view></router-view> <!--路由引入的组件将在这里被渲染-->
        <ol>
            <!-- 创建一个 todo-item 组件的实例 -->
            <todo-item></todo-item>
        </ol>
    </div>
</template>

<script>

    export default {
        data() {
            return {
                msg: 'Vue'
            }
        }
    }
</script>

<style>
</style>