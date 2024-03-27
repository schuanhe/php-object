import React from 'react';

import {Avatar, Card, Image, Popup, Progress} from "@chatui/core";
import "@chatui/core/dist/index.css";
// 用户和好感进度
function Cards({ user, npcAffinity }) {

    let progressStatus;

    if (npcAffinity < 30) {
        progressStatus = 'error';
    } else if (npcAffinity < 70) {
        progressStatus = 'active';
    } else {
        progressStatus = 'success';
    }

    return (
        <Card fluid={true}>
            <div style={{padding:'15px 15px'}}>
                <div style={{display:'flex',alignItems:'center'}}>
                    <Avatar src={user.avatar}/>
                    <h3 style={{marginLeft:'10px'}}><a style={{color:'red'}}>{user.name}</a> 对你的好感度：{npcAffinity}</h3>
                </div>
                <Progress value={npcAffinity} status={progressStatus} />
            </div>
        </Card>
    );
}

export default Cards;
