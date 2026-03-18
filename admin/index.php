<?php include 'header.php'; ?>

<?php
$projectCount = $pdo->query("SELECT COUNT(*) FROM projects")->fetchColumn();
$messageCount = $pdo->query("SELECT COUNT(*) FROM messages")->fetchColumn();
$serviceCount = $pdo->query("SELECT COUNT(*) FROM services")->fetchColumn();
?>

<div class="mb-10">
    <h2
        class="text-3xl font-bold bg-clip-text text-transparent bg-gradient-to-r from-slate-800 to-slate-500 tracking-tight">
        Welcome back,
        <?= htmlspecialchars($_SESSION['admin_username'])?>!
    </h2>
    <p class="text-slate-500 mt-2 font-medium">Here's what's happening with your portfolio today.</p>
</div>

<div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-10">
    <!-- Stat Card 1 -->
    <div
        class="bg-white rounded-2xl shadow-sm border border-slate-100 p-6 relative overflow-hidden group hover:shadow-md transition-shadow">
        <div
            class="absolute -right-6 -top-6 w-24 h-24 bg-brand-50 rounded-full group-hover:scale-110 transition-transform duration-500">
        </div>
        <div class="relative z-10">
            <div class="flex items-center justify-between mb-6">
                <h3 class="text-slate-500 font-semibold text-sm uppercase tracking-wider">Total Projects</h3>
                <div
                    class="bg-brand-100 w-12 h-12 flex items-center justify-center rounded-xl text-brand-600 shadow-inner">
                    <i class="ph ph-folder text-2xl"></i>
                </div>
            </div>
            <div class="text-4xl font-bold text-slate-800 tracking-tight mb-2">
                <?= $projectCount?>
            </div>
            <a href="projects.php"
                class="inline-flex items-center gap-1 text-brand-600 hover:text-brand-700 text-sm font-semibold transition-colors mt-2">
                Manage Portfolio <i class="ph ph-arrow-right"></i>
            </a>
        </div>
    </div>

    <!-- Stat Card 2 -->
    <div
        class="bg-gradient-to-br from-indigo-500 to-indigo-700 rounded-2xl shadow-md border border-indigo-400 p-6 relative overflow-hidden group hover:shadow-lg transition-shadow text-white">
        <div
            class="absolute -right-6 -top-6 w-24 h-24 bg-white/10 rounded-full group-hover:scale-110 transition-transform duration-500 backdrop-blur-sm">
        </div>
        <div class="relative z-10">
            <div class="flex items-center justify-between mb-6">
                <h3 class="text-indigo-100 font-semibold text-sm uppercase tracking-wider">New Messages</h3>
                <div
                    class="bg-white/20 w-12 h-12 flex items-center justify-center rounded-xl text-white shadow-inner backdrop-blur-md">
                    <i class="ph ph-envelope-simple-open text-2xl"></i>
                </div>
            </div>
            <div class="text-4xl font-bold tracking-tight mb-2">
                <?= $messageCount?>
            </div>
            <a href="messages.php"
                class="inline-flex items-center gap-1 text-indigo-100 hover:text-white text-sm font-semibold transition-colors mt-2">
                Open Inbox <i class="ph ph-arrow-right"></i>
            </a>
        </div>
    </div>

    <!-- Stat Card 3 -->
    <div
        class="bg-white rounded-2xl shadow-sm border border-slate-100 p-6 relative overflow-hidden group hover:shadow-md transition-shadow">
        <div
            class="absolute -right-6 -top-6 w-24 h-24 bg-emerald-50 rounded-full group-hover:scale-110 transition-transform duration-500">
        </div>
        <div class="relative z-10">
            <div class="flex items-center justify-between mb-6">
                <h3 class="text-slate-500 font-semibold text-sm uppercase tracking-wider">Active Services</h3>
                <div
                    class="bg-emerald-100 w-12 h-12 flex items-center justify-center rounded-xl text-emerald-600 shadow-inner">
                    <i class="ph ph-briefcase text-2xl"></i>
                </div>
            </div>
            <div class="text-4xl font-bold text-slate-800 tracking-tight mb-2">
                <?= $serviceCount?>
            </div>
            <a href="services.php"
                class="inline-flex items-center gap-1 text-emerald-600 hover:text-emerald-700 text-sm font-semibold transition-colors mt-2">
                Manage Services <i class="ph ph-arrow-right"></i>
            </a>
        </div>
    </div>
</div>

<div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-8">
    <div class="flex items-center gap-3 mb-6">
        <div class="p-2 bg-amber-100 rounded-lg text-amber-600">
            <i class="ph ph-lightning text-xl"></i>
        </div>
        <h3 class="text-xl font-bold text-slate-800 tracking-tight">Quick Actions</h3>
    </div>
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
        <a href="settings.php"
            class="flex items-start gap-4 p-4 rounded-xl border border-slate-200 hover:border-brand-500 hover:shadow-md hover:-translate-y-1 transition-all bg-white group">
            <div
                class="p-3 bg-slate-50 rounded-lg group-hover:bg-brand-50 group-hover:text-brand-600 transition-colors text-slate-500">
                <i class="ph ph-user-circle-gear text-2xl"></i>
            </div>
            <div>
                <h4 class="font-semibold text-slate-800">Edit Profile Text</h4>
                <p class="text-xs text-slate-500 mt-1">Update hero & about me info</p>
            </div>
        </a>
        <a href="stats.php"
            class="flex items-start gap-4 p-4 rounded-xl border border-slate-200 hover:border-brand-500 hover:shadow-md hover:-translate-y-1 transition-all bg-white group">
            <div
                class="p-3 bg-slate-50 rounded-lg group-hover:bg-brand-50 group-hover:text-brand-600 transition-colors text-slate-500">
                <i class="ph ph-chart-line-up text-2xl"></i>
            </div>
            <div>
                <h4 class="font-semibold text-slate-800">Update Banner Stats</h4>
                <p class="text-xs text-slate-500 mt-1">Change visual statistics</p>
            </div>
        </a>
        <a href="faqs.php"
            class="flex items-start gap-4 p-4 rounded-xl border border-slate-200 hover:border-brand-500 hover:shadow-md hover:-translate-y-1 transition-all bg-white group">
            <div
                class="p-3 bg-slate-50 rounded-lg group-hover:bg-brand-50 group-hover:text-brand-600 transition-colors text-slate-500">
                <i class="ph ph-chat-circle-text text-2xl"></i>
            </div>
            <div>
                <h4 class="font-semibold text-slate-800">Edit FAQs</h4>
                <p class="text-xs text-slate-500 mt-1">Manage common questions</p>
            </div>
        </a>
    </div>
</div>

<div class="mt-8 text-center">
    <p class="text-sm text-slate-400 font-medium pb-8 border-b border-t-0 border-x-0 border-solid border-transparent">
        Powered by <span class="text-slate-600 font-semibold">Zainfolio Engine</span></p>
</div>

<?php include 'footer.php'; ?>