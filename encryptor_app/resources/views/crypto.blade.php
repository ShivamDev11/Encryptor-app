<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Secure Encryptor</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

<style>
* { box-sizing: border-box; }

body {
    margin: 0;
    min-height: 100vh;
    font-family: 'Segoe UI', sans-serif;
    overflow-x: hidden;
}

/* ====== WRAPPER ====== */
.app {
    width: 100%;
    min-height: 100vh;
    display: flex;
    transition: background 1s ease;
}

/* ====== PANELS ====== */
.panel {
    width: 50%;
    min-height: 100vh;
    padding: 60px;
    display: flex;
    align-items: center;
    justify-content: center;
    transition: transform 0.8s ease, opacity 0.6s ease;
}

/* LEFT – ENCRYPT */
.encrypt-panel {
    color: #fff;
    backdrop-filter: blur(14px);
}

/* RIGHT – DECRYPT */
.decrypt-panel {
    background: #fff;
}

/* ===== SLIDE STATES ===== */
.show-encrypt .encrypt-panel {
    transform: translateX(0);
    opacity: 1;
}
.show-encrypt .decrypt-panel {
    transform: translateX(100%);
    opacity: 0;
}

.show-decrypt .encrypt-panel {
    transform: translateX(-100%);
    opacity: 0;
}
.show-decrypt .decrypt-panel {
    transform: translateX(0);
    opacity: 1;
}

/* ===== CONTENT ===== */
.card-box {
    width: 100%;
    max-width: 420px;
}

textarea { resize: none; }

/* ===== OUTPUT BOX ===== */
.result {
    background: rgba(0,0,0,0.25);
    color: #fff;
    padding: 14px;
    border-radius: 12px;
    margin-top: 12px;
    backdrop-filter: blur(8px);
    animation: reveal 0.6s ease forwards;
}

.result pre {
    white-space: pre-wrap;
    word-break: break-all;
}

/* ===== BRAND ===== */
.brand {
    margin-bottom: 25px;
}
.brand h1 {
    font-weight: 700;
}
.brand p {
    opacity: 0.85;
}

/* ===== ANIMATIONS ===== */
@keyframes reveal {
    from {
        opacity: 0;
        transform: translateY(15px) scale(0.97);
    }
    to {
        opacity: 1;
        transform: translateY(0) scale(1);
    }
}

button {
    transition: transform 0.2s ease, box-shadow 0.2s ease;
}
button:hover {
    transform: translateY(-2px);
    box-shadow: 0 6px 18px rgba(0,0,0,0.25);
}

/* ===== GRADIENTS ===== */
.grad1 { background: linear-gradient(135deg,#667eea,#764ba2); }
.grad2 { background: linear-gradient(135deg,#43cea2,#185a9d); }
.grad3 { background: linear-gradient(135deg,#ff758c,#ff7eb3); }
.grad4 { background: linear-gradient(135deg,#f7971e,#ffd200); }
.grad5 { background: linear-gradient(135deg,#ee0979,#ff6a00); }

/* ===== RESPONSIVE ===== */
@media (max-width: 992px) {
    .app {
        flex-direction: column;
    }
    .panel {
        width: 100%;
        min-height: auto;
        padding: 40px 20px;
    }

    .show-encrypt .decrypt-panel,
    .show-decrypt .encrypt-panel {
        display: none;
    }
}

</style>
</head>
<body>

<div id="app"
     class="app grad1 {{ session('decrypted') ? 'show-decrypt' : 'show-encrypt' }}">

<!-- 🔐 ENCRYPT -->
<div class="panel encrypt-panel">
    <div class="card-box">

        <div class="brand">
            <h1>🔐 Encrypt</h1>
            <p>Protect your message using secure encryption</p>
        </div>

        <form method="POST" action="/encrypt">
            @csrf
            <textarea name="message" class="form-control mb-3"
                      rows="4" placeholder="Enter message..." required></textarea>
            <button class="btn btn-light w-100 mb-3">Encrypt</button>
        </form>

        @if(session('encrypted'))
            <div class="result">
                <small>Encrypted Output</small>
                <pre>{{ session('encrypted') }}</pre>
            </div>
        @endif

        <button type="button"
                class="btn btn-outline-light mt-4 w-100"
                onclick="goDecrypt()">➡ Go to Decrypt</button>
    </div>
</div>

<!-- 🔓 DECRYPT -->
<div class="panel decrypt-panel">
    <div class="card-box">

        <h2 class="mb-2">🔓 Decrypt</h2>
        <p class="text-muted mb-3">Reveal original message</p>

        <form method="POST" action="/decrypt">
            @csrf
            <textarea name="encrypted_message" class="form-control mb-3"
                      rows="4" placeholder="Paste encrypted text..." required></textarea>
            <button class="btn btn-success w-100 mb-3">Decrypt</button>
        </form>

        @if(session('decrypted'))
            <div class="result">
                <small>Decrypted Output</small>
                <pre>{{ session('decrypted') }}</pre>
            </div>
        @endif

        <button type="button"
                class="btn btn-outline-secondary mt-4 w-100"
                onclick="goEncrypt()">⬅ Go to Encrypt</button>
    </div>
</div>

</div>

<script>
const gradients = ['grad1','grad2','grad3','grad4','grad5'];
let g = 0;

function changeGradient() {
    g = (g + 1) % gradients.length;
    const app = document.getElementById('app');
    app.className = app.className.replace(/grad\d/, gradients[g]);
}

function goDecrypt() {
    const app = document.getElementById('app');
    app.classList.remove('show-encrypt');
    app.classList.add('show-decrypt');
    changeGradient();
}

function goEncrypt() {
    const app = document.getElementById('app');
    app.classList.remove('show-decrypt');
    app.classList.add('show-encrypt');
    changeGradient();
}
</script>

</body>
</html>
