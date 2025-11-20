# github-icon-pulse

```html
<a href="https://github.com/EsderJ10" target="_blank" rel="noopener" class="github-float" aria-label="View Github Profile">
    <svg viewBox="0 0 24 24" width="24" height="24" stroke="currentColor" stroke-width="2" fill="none" stroke-linecap="round" stroke-linejoin="round">
        <path d="M9 19c-5 1.5-5-2.5-7-3m14 6v-3.87a3.37 3.37 0 0 0-.94-2.61c3.14-.35 6.44-1.54 6.44-7A5.44 5.44 0 0 0 20 4.77 5.07 5.07 0 0 0 19.91 1S18.73.65 16 2.48a13.38 13.38 0 0 0-7 0C6.27.65 5.09 1 5.09 1A5.07 5.07 0 0 0 5 4.77a5.44 5.44 0 0 0-1.5 3.78c0 5.42 3.3 6.61 6.44 7A3.37 3.37 0 0 0 9 18.13V22"></path>
    </svg>
</a>
```

```css
.github-float {
    position: fixed;
    bottom: 30px;
    right: 30px;
    width: 50px;
    height: 50px;
    background: white;
    color: #667eea;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    box-shadow: 0 4px 15px rgba(102, 126, 234, 0.3);
    transition: all 0.3s ease;
    z-index: 100;
}

.github-float:hover {
    transform: translateY(-3px);
    background: #667eea;
    color: white;
    box-shadow: 0 8px 20px rgba(102, 126, 234, 0.5);
}

/* Pulse effect */
.github-float::after {
    content: '';
    position: absolute;
    width: 100%;
    height: 100%;
    border-radius: 50%;
    border: 1px solid #667eea;
    animation: pulse-ring 2s infinite;
    opacity: 0;
}

@keyframes pulse-ring {
    0% { transform: scale(1); opacity: 0.5; }
    100% { transform: scale(1.5); opacity: 0; }
}
``` 

```html
<div class="dev-signature">
    <a href="https://github.com/EsderJ10" target="_blank">
        <span class="brackets">&lt;</span>
        <span class="text">Github Profile</span>
        <span class="brackets">/&gt;</span>
    </a>
</div>
```

```css
.dev-signature {
    text-align: center;
    margin-top: 40px;
    margin-bottom: 20px;
}

.dev-signature a {
    display: inline-block;
    text-decoration: none;
    color: #a0aec0;
    font-family: monospace; 
    font-size: 14px;
    transition: 0.3s;
    padding: 8px 16px;
    border-radius: 20px;
    background: rgba(102, 126, 234, 0.05);
}

.dev-signature .brackets {
    color: #667eea; 
    font-weight: bold;
    opacity: 0.7;
    transition: 0.3s;
}

.dev-signature a:hover {
    background: rgba(102, 126, 234, 0.1);
    color: #667eea;
    transform: translateY(-2px);
}

.dev-signature a:hover .brackets {
    opacity: 1;
    margin: 0 3px;
}
```
