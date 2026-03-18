<?php
session_start();
if (isset($_SESSION['admin_logged_in'])) {
    header('Location: index.php');
    exit;
}

require_once '../db.php';

$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username'] ?? '');
    $password = $_POST['password'] ?? '';

    if ($username && $password) {
        $stmt = $pdo->prepare("SELECT * FROM users WHERE username = ?");
        $stmt->execute([$username]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user && password_verify($password, $user['password'])) {
            $_SESSION['admin_logged_in'] = true;
            $_SESSION['admin_user_id'] = $user['id'];
            $_SESSION['admin_username'] = $user['username'];
            header('Location: index.php');
            exit;
        }
        else {
            $error = 'Invalid username or password.';
        }
    }
    else {
        $error = 'Please enter both fields.';
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Sign in - Zainfolio Admin</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://unpkg.com/@phosphor-icons/web"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap"
        rel="stylesheet">
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: { sans: ['"Plus Jakarta Sans"', 'sans-serif'] },
                    colors: { brand: { 50: '#eff6ff', 100: '#dbeafe', 500: '#3b82f6', 600: '#2563eb', 900: '#1e3a8a' } }
                }
            }
        }
    </script>
    <style>
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background-color: #f8fafc;
        }
    </style>
</head>

<body
    class="bg-gray-50 flex items-center justify-center min-h-screen relative overflow-hidden selection:bg-brand-500 selection:text-white">
    <!-- Decorative background elements -->
    <div
        class="absolute top-[-10%] left-[-10%] w-[500px] h-[500px] rounded-full bg-brand-200/50 blur-[100px] mix-blend-multiply">
    </div>
    <div
        class="absolute bottom-[-10%] right-[-10%] w-[500px] h-[500px] rounded-full bg-indigo-200/50 blur-[100px] mix-blend-multiply">
    </div>

    <div
        class="bg-white/80 backdrop-blur-xl p-10 rounded-3xl shadow-xl shadow-brand-900/5 border border-white w-full max-w-[420px] relative z-10 w-full mx-4">
        <div class="text-center mb-8">
            <div
                class="mx-auto bg-brand-600 text-white w-14 h-14 flex items-center justify-center rounded-2xl shadow-lg shadow-brand-500/30 mb-5 relative top-[1px]">
                <i class="ph ph-code text-3xl"></i>
            </div>
            <h2 class="text-2xl font-bold text-slate-800 tracking-tight">Welcome back</h2>
            <p class="text-sm text-slate-500 mt-2 font-medium">Please enter your details to sign in.</p>
        </div>

        <?php if ($error): ?>
        <div
            class="bg-red-50 border border-red-200 text-red-600 px-4 py-3 rounded-xl mb-6 text-sm flex items-center gap-2">
            <i class="ph ph-warning-circle text-lg"></i>
            <?= htmlspecialchars($error)?>
        </div>
        <?php
endif; ?>

        <form method="POST" action="">
            <div class="mb-5">
                <label class="block text-slate-700 text-sm font-semibold mb-2" for="username">Username</label>
                <div class="relative">
                    <div
                        class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-slate-400 text-lg">
                        <i class="ph ph-user"></i>
                    </div>
                    <input
                        class="w-full bg-white text-slate-800 border-2 border-slate-200 rounded-xl py-3 pl-10 pr-4 focus:outline-none focus:border-brand-500 focus:ring-4 focus:ring-brand-500/10 transition-all font-medium placeholder:font-normal placeholder:text-slate-400"
                        type="text" id="username" name="username" placeholder="e.g. admin" required>
                </div>
            </div>

            <div class="mb-8">
                <label class="block text-slate-700 text-sm font-semibold mb-2" for="password">Password</label>
                <div class="relative">
                    <div
                        class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-slate-400 text-lg">
                        <i class="ph ph-lock-key"></i>
                    </div>
                    <input
                        class="w-full bg-white text-slate-800 border-2 border-slate-200 rounded-xl py-3 pl-10 pr-4 focus:outline-none focus:border-brand-500 focus:ring-4 focus:ring-brand-500/10 transition-all font-medium placeholder:font-normal placeholder:text-slate-400"
                        type="password" id="password" name="password" placeholder="••••••••" required>
                </div>
            </div>

            <button
                class="w-full bg-slate-900 hover:bg-brand-600 focus:ring-4 focus:ring-brand-500/30 text-white font-semibold py-3.5 px-4 rounded-xl transition-all duration-300 shadow-md shadow-brand-500/20 flex items-center justify-center gap-2"
                type="submit">
                <span>Sign in securely</span>
                <i class="ph ph-arrow-right"></i>
            </button>
        </form>
    </div>
</body>

</html>