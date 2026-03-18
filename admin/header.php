<?php
session_start();
if (!isset($_SESSION['admin_logged_in'])) {
    header('Location: login.php');
    exit;
}
require_once '../db.php';
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Admin Dashboard - Zainfolio</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://unpkg.com/@phosphor-icons/web"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
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

<body class="flex h-screen text-slate-800 antialiased selection:bg-brand-500 selection:text-white">

    <!-- Sidebar -->
    <aside class="w-64 bg-white border-r border-slate-200 flex flex-col h-screen fixed shadow-sm z-20">
        <div class="h-20 flex items-center px-8 border-b border-slate-100">
            <div class="bg-brand-600 text-white p-2 rounded-lg mr-3 shadow-md shadow-brand-500/30">
                <i class="ph ph-code text-xl relative top-[1px]"></i>
            </div>
            <h1
                class="text-xl font-bold bg-clip-text text-transparent bg-gradient-to-r from-slate-800 to-slate-500 tracking-tight">
                Zainfolio</h1>
        </div>

        <nav class="flex-1 px-4 py-6 space-y-1.5 overflow-y-auto font-medium text-sm">
            <p class="px-4 text-xs font-semibold text-slate-400 uppercase tracking-wider mb-4 mt-2">Menu</p>

            <?php
            $nav = [
                ['index.php', 'ph-squares-four', 'Dashboard'],
                ['settings.php', 'ph-gear', 'Site Settings'],
                ['projects.php', 'ph-folder', 'Projects'],
                ['education.php', 'ph-student', 'Education'],
                ['skills.php', 'ph-code', 'Skills'],
                ['stats.php', 'ph-chart-bar', 'Stats'],
                ['services.php', 'ph-briefcase', 'Services'],
                ['faqs.php', 'ph-question', 'FAQs'],
                ['messages.php', 'ph-envelope-simple', 'Messages']
            ];
            foreach ($nav as $item):
                $active = basename($_SERVER['PHP_SELF']) == $item[0];
                ?>
                <a href="<?= $item[0] ?>"
                    class="flex items-center gap-3 px-4 py-3 rounded-xl transition-all duration-200 <?= $active ? 'bg-brand-50 text-brand-600 shadow-sm shadow-brand-100/50' : 'text-slate-500 hover:bg-slate-50 hover:text-slate-900 group' ?>">
                    <i
                        class="ph <?= $item[1] ?> text-xl <?= $active ? 'text-brand-600' : 'text-slate-400 group-hover:text-slate-600' ?> transition-colors"></i>
                    <span>
                        <?= $item[2] ?>
                    </span>
                </a>
                <?php
            endforeach; ?>
        </nav>

        <div class="p-4 border-t border-slate-100 bg-slate-50/50">
            <div class="flex items-center gap-3 px-2 py-2 mb-3">
                <div
                    class="w-10 h-10 rounded-full bg-slate-200 flex items-center justify-center text-slate-600 font-bold border-2 border-white shadow-sm">
                    <?= strtoupper(substr($_SESSION['admin_username'] ?? 'A', 0, 1)) ?>
                </div>
                <div class="flex-1 min-w-0">
                    <p class="text-sm font-semibold text-slate-900 truncate">
                        <?= htmlspecialchars($_SESSION['admin_username']) ?>
                    </p>
                    <p class="text-xs text-slate-500 truncate">Administrator</p>
                </div>
                <button onclick="confirmLogout(event)"
                    class="text-slate-400 hover:text-red-500 p-2 rounded-lg hover:bg-red-50 transition-colors"
                    title="Logout">
                    <i class="ph ph-sign-out text-xl"></i>
                </button>
            </div>
            <a href="../index.php" target="_blank"
                class="flex items-center justify-center gap-2 w-full py-2.5 bg-white border border-slate-200 hover:border-slate-300 hover:bg-slate-50 text-slate-600 rounded-xl text-sm font-medium transition shadow-sm">
                <i class="ph ph-arrow-square-out text-lg"></i>
                <span>View Live Site</span>
            </a>
        </div>
    </aside>

    <!-- Main Content -->
    <main class="flex-1 ml-64 overflow-y-auto w-full relative">
        <div class="p-8 md:p-10 w-full max-w-7xl mx-auto">

            <script>
                function confirmLogout(e) {
                    e.preventDefault();
                    Swal.fire({
                        title: 'Ready to leave?',
                        text: 'You are about to securely log out of the admin panel.',
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#3b82f6',
                        cancelButtonColor: '#94a3b8',
                        confirmButtonText: 'Yes, log out',
                        customClass: {
                            popup: 'rounded-2xl',
                            confirmButton: 'rounded-lg px-6',
                            cancelButton: 'rounded-lg px-6'
                        }
                    }).then((result) => {
                        if (result.isConfirmed) {
                            window.location.href = 'logout.php';
                        }
                    })
                }
            </script>