// About.js
import React from 'react';
import '@chatui/core/es/styles/index.less'

import Chat, { Bubble,Progress,Card,Avatar, useMessages } from "@chatui/core";
import "@chatui/core/dist/index.css";
import { useImmer } from 'use-immer';
import Cards from './Cards';
import sendMessage from "../utlis/send";
const npcData = require('../utlis/data.json');

function About() {
  const { messages, appendMsg, setTyping } = useMessages([]);

  // 缓存对象
  const [npcAffinity, updateNpcAffinity] = useImmer(0);


  async function handleSend(type, val) {
    if (type === "text" && val.trim()) {
      if (val === "进度"){
        appendMsg({
          type: "card",
          content: {text: npcAffinity},
          position: "left"
        });
        console.log(npcAffinity)
        return;
      }

      appendMsg({
        type: "text",
        content: {text: val},
        position: "right"
      });
      setTyping(true);
      // 创建异步请求
      let res = await sendMessage(val)

      res =  JSON.parse(res)

      updateNpcAffinity(res.npcAffinity);

      console.log(res)

      appendMsg({
        type: "text",
        content: {text: res.message },
        position: "left",
        user:{
          name: npcData[0].npcName,
          avatar: npcData[0].avatar
        }
      });
      setTyping(false);
    }
  }

  function renderMessageContent(msg) {

    const { content } = msg;

    if (msg.type === "text") {
      return <Bubble content={content.text} />;
    }
    if (msg.type === "card") {
      return (
            <Cards user={{ name: npcData[0].name, avatar: npcData[0].avatar}} npcAffinity={content.text}/>
      );
    }

    return (
        <>
          <Bubble title={"我"} content={content.text}>
          </Bubble>
          {/*<Cards user={{ name: "张三", avatar: "https://avatars2.githubusercontent.com/u/15681693?s=460&v=4"}} npcAffinity={"1"}/>*/}
        </>
    );
  }

  return (
        <Chat
            navbar={{ title: "攻略xxx" }}
            messages={messages}
            renderMessageContent={renderMessageContent}
            onSend={handleSend}

        />
  );
}

export default About;


