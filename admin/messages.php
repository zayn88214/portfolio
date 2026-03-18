<?php include 'header.php'; ?>

<?php
if (isset($_GET['delete'])) {
    $id = (int)$_GET['delete'];
    $pdo->prepare("DELETE FROM messages WHERE id = ?")->execute([$id]);
    echo '<div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded">Message deleted.</div>';
}

$messages = $pdo->query("SELECT * FROM messages ORDER BY created_at DESC")->fetchAll();
?>

<div class="mb-6 flex items-center justify-between">
    <h2 class="text-3xl font-bold text-gray-800">Inbox Messages</h2>
</div>

<div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
    <?php if (empty($messages)): ?>
    <div class="p-8 text-center text-gray-500 flex flex-col items-center">
        <i class="ph ph-envelope-simple-open text-4xl mb-2 text-gray-300"></i>
        <p>Your inbox is entirely empty.</p>
    </div>
    <?php
else: ?>
    <div class="divide-y divide-gray-100">
        <?php foreach ($messages as $m): ?>
        <div class="p-6 hover:bg-gray-50/50 transition relative group">
            <div class="flex items-start justify-between">
                <div>
                    <h4 class="text-lg font-semibold text-gray-900">
                        <?= e($m['first_name'] . ' ' . $m['last_name'])?>
                        </h3>
                        <div class="text-sm text-gray-500 mb-3 space-x-2">
                            <span class="inline-flex items-center gap-1"><i class="ph ph-envelope"></i>
                                <?= e($m['email'])?>
                            </span>
                            <?php if ($m['phone']): ?>
                            <span class="inline-flex items-center gap-1"><i class="ph ph-phone"></i>
                                <?= e($m['phone'])?>
                            </span>
                            <?php
        endif; ?>
                            <span class="inline-flex items-center gap-1 bg-gray-100 px-2 py-0.5 rounded ml-2"><i
                                    class="ph ph-calendar"></i>
                                <?= date('M j, Y g:i A', strtotime($m['created_at']))?>
                            </span>
                        </div>
                        <p
                            class="text-gray-700 whitespace-pre-wrap bg-gray-50 p-4 border border-gray-100 rounded-lg text-sm">
                            <?= e($m['message'])?>
                        </p>
                </div>
                <div>
                    <a href="?delete=<?= $m['id']?>" onclick="return confirm('Delete this message?');"
                        class="text-red-400 hover:text-red-600 bg-red-50 hover:bg-red-100 p-2 rounded-lg transition inline-block">
                        <i class="ph ph-trash text-lg"></i>
                    </a>
                </div>
            </div>
        </div>
        <?php
    endforeach; ?>
    </div>
    <?php
endif; ?>
</div>

<?php include 'footer.php'; ?>