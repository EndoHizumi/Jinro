<template>
  <div id="gameClient">
    <Header></Header>
    <playersview></playersview>
    <Chat ref="chat" name="hizumi" v-on:submit="sendMessage" />
  </div>
</template>

<script>
/* eslint-disable */
import Chat from "./chat.vue";
import Header from "./header.vue";
import Playersview from "./playersView.vue";
var es;
export default {
  name: "gameClient",
  components: {
    Header,
    Playersview,
    Chat
  },
  methods: {
    displayMessage(message) {
      this.$refs.chat.addMessage(message);
    },
    sendMessage(message) {
      const name = encodeURIComponent(message.name);
      const text = encodeURIComponent(message.message);
      var result = this.sendActivity(
        `name=${name}&message=${text}&category=message`
      );
      return result;
    },
    receiveEvent(message) {},
    sendActivity(requestBody) {
      const method = "POST";
      const body = requestBody;
      const headers = {
        Accept: "application/json",
        "Content-Type": "application/x-www-form-urlencoded; charset=utf-8"
      };
      return fetch("JinrouResponcer.php", { method, headers, body }).then(
        res => {
          return res;
        }
      );
    }
  },
  created() {
    var res = this.sendActivity("category=me");
    res.then(data => {
      if (data.status == "401") {
        fetch("login.html", { method: "GET" })
          .then(res => {
            return res;
          })
          .then(data => {
            console.log(data);
            var ele = document.getElementById("gameClient");
            ele.innerHTML = data;
          });
      }
    });
    es = new EventSource("Broadcast.php");
    let vue = this;
    es.onmessage = function(event) {
      let jdata = JSON.parse(event.data);
      console.log(jdata);
      if (jdata.Event == "message") {
        vue.displayMessage(jdata);
      } else {
        vue.receiveEvent(jdata);
      }
    };
  }
};
</script>

<style>
#gameClient {
  font-family: "Avenir", Helvetica, Arial, sans-serif;
  -webkit-font-smoothing: antialiased;
  -moz-osx-font-smoothing: grayscale;
  color: #2c3e50;
}
</style>
