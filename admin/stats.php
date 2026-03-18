<?php include 'header.php'; ?>

<?php
if (isset($_GET['delete'])) {
    $id = (int)$_GET['delete'];
    $pdo->prepare("DELETE FROM stats WHERE id = ?")->execute([$id]);
    echo '<div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded">Stat deleted.</div>';
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'] ?? '';
    $label = $_POST['label'] ?? '';
    $target_number = $_POST['target_number'] ?? 0;

    if ($id) {
        $stmt = $pdo->prepare("UPDATE stats SET label=?, target_number=? WHERE id=?");
        $stmt->execute([$label, $target_number, $id]);
        echo '<div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded">Stat updated.</div>';
    }
    else {
        $stmt = $pdo->prepare("INSERT INTO stats (label, target_number) VALUES (?, ?)");
        $stmt->execute([$label, $target_number]);
        echo '<div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded">Stat added.</div>';
    }
}

$stats = $pdo->query("SELECT * FROM stats ORDER BY id ASC")->fetchAll();
?>

<div class="mb-6 flex items-center justify-between">
    <h2 class="text-3xl font-bold text-gray-800">Manage Hero Stats</h2>
</div>

<div class="grid grid-cols-1 md:grid-cols-2 gap-8">
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
        <h3 class="bg-gray-50 border-b border-gray-100 p-4 font-semibold text-gray-700">Current Stats List</h3>
        <ul class="divide-y divide-gray-100">
            <?php foreach ($stats as $s): ?>
            <li class="p-4 flex items-center justify-between hover:bg-gray-50 transition">
                <div>
                    <span class="text-2xl font-bold text-gray-900">
                        <?= e($s['target_number'])?>+
                    </span>
                    <p class="text-sm text-gray-500">
                        <?= e($s['label'])?>
                    </p>
                </div>
                <div class="flex gap-2">
                    <button onclick='editStat(<?= json_encode($s)?>)'
                        class="p-2 text-blue-500 hover:bg-blue-50 rounded-lg transition border border-transparent hover:border-blue-100"><i
                            class="ph ph-pencil-simple text-lg"></i></button>
                    <a href="?delete=<?= $s['id']?>" onclick="return confirm('Delete this stat?');"
                        class="p-2 text-red-500 hover:bg-red-50 rounded-lg transition border border-transparent hover:border-red-100"><i
                            class="ph ph-trash text-lg"></i></a>
                </div>
            </li>
            <?php
endforeach; ?>
        </ul>
    </div>

    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 h-max">
        <h3 class="font-semibold text-gray-700 mb-4 border-b border-gray-100 pb-2" id="formTitle">Add New Stat</h3>
        <form method="POST">
            <input type="hidden" name="id" id="statId">
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-1">Target Number / Count</label>
                <input type="number" name="target_number" id="statTargetNumber" required
                    class="w-full bg-gray-50 border border-gray-300 text-gray-900 rounded-lg py-2 px-3 focus:ring-blue-500">
            </div>
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-1">Label Text</label>
                <input type="text" name="label" id="statLabel" required
                    class="w-full bg-gray-50 border border-gray-300 text-gray-900 rounded-lg py-2 px-3 focus:ring-blue-500">
            </div>
            <div class="flex items-center gap-3">
                <button type="submit"
                    class="bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 px-6 rounded-lg shadow-sm transition">Save
                    Stat</button>
                <button type="button" onclick="resetForm()"
                    class="py-2 px-4 rounded-lg bg-gray-100 hover:bg-gray-200 text-gray-700 transition">Cancel</button>
            </div>
        </form>
    </div>
</div>

<script>
    function editStat(stat) {
        document.getElementById('formTitle').textContent = 'Edit Stat';
        document.getElementById('statId').value = stat.id;
        document.getElementById('statTargetNumber').value = stat.target_number;
        document.getElementById('statLabel').value = stat.label;
    }
    function resetForm() {
        document.getElementById('formTitle').textContent = 'Add New Stat';
        document.getElementById('statId').value = '';
        document.querySelector('form').reset();
    }
</script>

<?php include 'footer.php'; ?>