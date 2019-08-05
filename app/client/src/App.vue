<template>
  <div id="app">
    <Chat ref="chat" name="hizumi" message="Welcome to Your Vue.js App" />
    <button v-on:click="sendMessage({name:'fugao',text:'hoge'})">send</button>
  </div>
</template>

<script>
import Chat from "./components/chat.vue";
var es;
export default {
  name: "app",
  components: {
    Chat
  },
  methods: {
    sendMessage(message) {
      this.$refs.chat.addMessage(message);
    }
  },
  created() {
    es = new EventSource("http://localhost:88/Broadcast.php");
    let vue = this;
    es.onmessage = function(event) {
    let jdata =  JSON.parse(event.data);
    vue.sendMessage(jdata);
  }

  },
};
</script>

<style>
#app {
  font-family: "Avenir", Helvetica, Arial, sans-serif;
  -webkit-font-smoothing: antialiased;
  -moz-osx-font-smoothing: grayscale;
  color: #2c3e50;
  margin-top: 60px;
}
</style>
