import axios from "axios";


// 读取同目录下的data.json
const npcData = require('./data.json');



export default async function sendMessage(msg){
    const url = 'https://api.chatanywhere.com.cn/v1/chat/completions';
    const apiKey = 'sk-puJJKlGeRrCIHCDY4df3cf0kh7NtCPXMHYF38Vgt5atzcHuS'; // 请替换为实际的 API 密钥

    // 储存对话到缓存
    let messages = localStorage.getItem('messages');
    messages = JSON.parse(messages);
    if (messages) {
        messages.push({
            role: 'user',
            content: msg // 请确保在此之前定义了 msg 变量
        });
    }else {
        messages = [
            {
                role: 'system',
                content: npcData[0].npcConfig + npcData[0].gameConfig
            },
            {
                role: 'user',
                content: msg // 请确保在此之前定义了 msg 变量
            }
        ];
    }
    // 请求的数据
    const data = {
        model: 'gpt-3.5-turbo',
        messages: messages,
        temperature: 0.7,
        type: 'json_object',
        max_tokens: 100,
    };
    return await axios.post(url, data, {
       headers: {
           'Content-Type': 'application/json',
           'Authorization': 'Bearer ' + apiKey
       }
   }).then(response => {
       console.log(response.data);
       // 处理响应数据
       if (response.data.choices[0].message.content) {
           const resMessage = response.data.choices[0].message.content;

           messages.push({
               role: 'assistant',
               content: resMessage
           });
           messages = useMessages(messages)
           localStorage.setItem('messages', JSON.stringify(messages));
           return resMessage;
       }

   }).catch(error => {
           console.error(error);
       });
}

// messages缓存优化
function useMessages(messages){
    // 判断缓存中是否存在数据
    if (messages) {
        // 判断数组大小
        if (messages.length > 10) {

            // 获取最后一条assistant消息
            const lastAssistantMessage = messages[messages.length - 1];

            console.log(lastAssistantMessage)
            messages = [{
                role: 'system',
                content: npcData[0].npcConfig + npcData[0].gameConfig + "并且你现在的初始信任度为" + JSON.parse(lastAssistantMessage.content)["npcAffinity"]
            }]
        }
    }else {
        messages = [
            {
                role: 'system',
                content: npcData[0].npcConfig + npcData[0].gameConfig
            }
        ];
    }

    return messages;

}

//
// const ms = {
//     "id": "chatcmpl-96xjyaU6Hd5q5TJgEG6gv9bNxAEXA",
//     "object": "chat.completion",
//     "created": 1711446638,
//     "model": "gpt-3.5-turbo-0125",
//     "choices": [
//         {
//             "index": 0,
//             "message": {
//                 "role": "assistant",
//                 "content": "我是一个语言模型AI助手，我不会感觉或拥有情绪。如果你有任何问题或需要帮助，请随时告诉我。"
//             },
//             "logprobs": null,
//             "finish_reason": "stop"
//         }
//     ],
//     "usage": {
//         "prompt_tokens": 20,
//         "completion_tokens": 47,
//         "total_tokens": 67
//     },
//     "system_fingerprint": "fp_3bc1b5746c"
// }