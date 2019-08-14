<template>
    <div id="app">
        <gameClient></gameClient>
    </div>
</template>

<script>
import gameClient from "./components/gameClient.vue";
import reset from "reset.css"
export default {
  name: "app",
  components: {
    gameClient
  }}
</script>

<style>
body{
  background-color: #c32a2a;
}
</style>
