// index.js
import React from 'react';
import { createRoot } from 'react-dom/client';
import App from './App';
import '@chatui/core/es/styles/index.less'
import "@chatui/core/dist/index.css";

const root = createRoot(document.getElementById('root'));
root.render(
  <React.StrictMode>
    <App />
  </React.StrictMode>
);
