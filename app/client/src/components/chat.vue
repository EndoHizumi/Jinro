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
        <button class="toolbar__actionbutton" type="button">
          <span class="actionbutton__name">action</span>
        </button>
      </div>
      <div class="inputarea">
        <input
          class="inputarea__text"
          type="text"
          ref="text"
          v-on:keyup.ctrl.exact.enter="submitMessage($refs.text.value)"
        />
        <button
          class="inputarea__submit"
          type="submit"
          v-on:click="submitMessage($refs.text.value)"
        >＞</button>
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
      var $this = this;
      this.$nextTick(function() {
        var container = $this.$el.querySelector(".messagearea");
        container.scrollTo(0,container.scrollHeight);
      });
    },
    submitMessage(text) {
      const message = { name: this.name, message: text };
      this.$emit("submit", message);
      var container = this.$el.querySelector(".inputarea__text");
      container.value = "";
    }
  }
};
</script>

<style>
.messagearea {
  width: 100vw;
  height: calc(100vh - 211px);
  overflow: scroll;
}
.message {
  position: relative;
  min-width: 250px;
  max-width: 95%;
  margin-top: 5px;
}
.head__icon {
  width: 32px;
  height: 32px;
  padding-top: 15px;
}
.head__name {
  font-weight: bold;
  color: white;
  font-size: 16px;
}
.body__text {
  margin: 0px;
  width: 99%;
  height: 100%;
  min-width: 350px;
  border-radius: 10px;
  padding: 5px;
  margin-left: 10px;
  background-color: whitesmoke;
}
.toolbar {
  position: relative;
}
.toolbar button {
  outline: 0;
  border: 0;
}
.toolbar button:hover {
  opacity: 0.8;
}
.toolbar button:active {
  opacity: 1;
}
.toolbar__actionbutton {
  width: 100vw;
  height: 47px;

  background: #4be651;
}
.actionbutton__name {
  font-size: 36px;
  line-height: 28px;
  text-align: center;
  font-weight: bold;
  color: #ffffff;
}
.inputarea {
  width: 100vw;
  height: 54px;
}
.inputarea * {
  vertical-align: middle;
  margin: 0;
  padding: 0;
}
.inputarea__submit {
  width: 54px;
  height: 54px;
  background: #232d31;
}
.inputarea__text {
  width: calc(100% - 54px);
  height: 53px;
  border: 0;
}
</style>