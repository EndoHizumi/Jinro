<template>
  <div class="chat">
    <div class="messagearea">
      <div class="message" v-for="message in messageDatas" v-bind:key="message.id">
        <div vclass="head">
          <span class="head__name">{{message.name}}</span>
        </div>
        <div class="body">
          <p class="body__text">{{message.text}}</p>
        </div>
      </div>
    </div>
    <div class="toolbar">
      <div class="toolbar__header">
        <button class="toolbar__actionbutton" type="button">action</button>
      </div>
      <div class="inputarea">
        <input class="inputarea__text" type="text" ref="text" />
        <button
          class="inputarea__submit"
          type="submit"
          v-on:click="submitMessage($refs.text.value)"
          v-on:click:enter="submitMessage($refs.text.value)"
        >send</button>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  /* eslint-disable */
  name: "Chat",
  props: {
    name: String
  },
  data() {
    return {
      lastid: 1,
      messageDatas: []
    };
  },
  methods: {
    addMessage(message) {
      this.messageDatas.push({
        id: this.lastid,
        name: message.Name,
        text: message.Message,
        icon: "gameMaster.png"
      });
      this.lastid += message.id;
    },
    submitMessage(text) {
      const message = { name: this.name, message: text };
      this.$emit("submit", message);
    }
  }
};
</script>

<style>
.message {
  position: relative;
  min-width: 250px;
  max-width: 95%;
}
.head__icon {
  width: 32px;
  height: 32px;
  padding-top: 15px;
}
.head_name {
  font-weight: bold;
}
.body__text {
  margin: 0px;
  width: 95vw;
  height: 100%;
  min-width: 350px;
  border: solid 1px black;
  border-radius: 10px;
  padding-left: 5px;
  margin-left: 10px;
}
.toolbar {
  position: absolute;
  left: 4px;
  right:4px;
  bottom: 0;
  width: 99vw;
  overflow: hidden;
}
.toolbar button {
  border: 0;
  color: #ffffff;
  font-weight: bold;
  font-size: 24px;
  outline: 0;
}
.toolbar__actionbutton {
  width: 360px;
  height: 47px;
  background: #4be651;
}
.toolbar button:hover {
  opacity: 0.8;
}
.toolbar button:active {
  padding: 5px gray;
}
.inputarea {
  width: 100%;
  height: 40px;
}
.inputarea button {
  width: 50px;
  height: 43px;
  background: #232d31;
  position: relative;
  bottom: 4px;
}
.toolbar__actionbutton {
  width: 100%;
  height: 35px;
}
.inputarea__text {
  width: calc(100% - 50px);
  height: 94%;
  font-size: 32px;
  outline: 0;
}
</style>