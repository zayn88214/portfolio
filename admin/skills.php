<?php include 'header.php'; ?>

<?php
if (isset($_GET['delete'])) {
    $id = (int) $_GET['delete'];
    $pdo->prepare("DELETE FROM skills WHERE id = ?")->execute([$id]);
    echo '<div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded">Skill deleted.</div>';
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'] ?? '';
    $name = $_POST['name'] ?? '';
    $icon = $_POST['icon'] ?? 'ph-code';

    if ($id) {
        $stmt = $pdo->prepare("UPDATE skills SET name=?, icon=? WHERE id=?");
        $stmt->execute([$name, $icon, $id]);
        echo '<div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded">Skill updated.</div>';
    } else {
        $stmt = $pdo->prepare("INSERT INTO skills (name, icon) VALUES (?, ?)");
        $stmt->execute([$name, $icon]);
        echo '<div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded">Skill added.</div>';
    }
}

$skills = $pdo->query("SELECT * FROM skills ORDER BY id ASC")->fetchAll();
?>

<div class="mb-6 flex items-center justify-between">
    <h2 class="text-3xl font-bold text-gray-800">Manage Technical Skills</h2>
</div>

<div class="grid grid-cols-1 md:grid-cols-2 gap-8">
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
        <h3 class="bg-gray-50 border-b border-gray-100 p-4 font-semibold text-gray-700">Current Skills</h3>
        <ul class="divide-y divide-gray-100">
            <?php foreach ($skills as $s): ?>
                <li class="p-4 flex items-center justify-between hover:bg-gray-50 transition">
                    <div class="flex items-center gap-4">
                        <div class="w-10 h-10 flex items-center justify-center bg-gray-100 rounded text-xl text-blue-600">
                            <script src="https://code.iconify.design/iconify-icon/2.1.0/iconify-icon.min.js"></script>
                            <iconify-icon icon="<?= e($s['icon']) ?>"></iconify-icon>
                        </div>
                        <div>
                            <span class="font-bold text-gray-900">
                                <?= e($s['name']) ?>
                            </span>
                            <p class="text-xs text-gray-400">Icon:
                                <?= e($s['icon']) ?>
                            </p>
                        </div>
                    </div>
                    <div class="flex gap-2">
                        <button onclick='editSkill(<?= json_encode($s) ?>)'
                            class="p-2 text-blue-500 hover:bg-blue-50 rounded-lg transition border border-transparent hover:border-blue-100"><i
                                class="ph ph-pencil-simple text-lg"></i></button>
                        <a href="?delete=<?= $s['id'] ?>" onclick="return confirm('Delete this skill?');"
                            class="p-2 text-red-500 hover:bg-red-50 rounded-lg transition border border-transparent hover:border-red-100"><i
                                class="ph ph-trash text-lg"></i></a>
                    </div>
                </li>
                <?php
            endforeach; ?>
        </ul>
    </div>

    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 h-max">
        <h3 class="font-semibold text-gray-700 mb-4 border-b border-gray-100 pb-2" id="formTitle">Add New Skill</h3>
        <form method="POST">
            <input type="hidden" name="id" id="skillId">
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-1">Skill Name</label>
                <input type="text" name="name" id="skillName" required placeholder="e.g. React"
                    class="w-full bg-gray-50 border border-gray-300 text-gray-900 rounded-lg py-2 px-3 focus:ring-blue-500">
            </div>
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-1">Iconify Name (e.g. devicon:react)</label>
                <input type="text" name="icon" id="skillIcon" required placeholder="devicon:react"
                    class="w-full bg-gray-50 border border-gray-300 text-gray-900 rounded-lg py-2 px-3 focus:ring-blue-500">
                <p class="text-xs text-gray-500 mt-1">Get icon names from <a href="https://icon-sets.iconify.design/"
                        target="_blank" class="text-blue-500 underline">Iconify</a>.</p>
            </div>
            <div class="flex items-center gap-3">
                <button type="submit"
                    class="bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 px-6 rounded-lg shadow-sm transition">Save
                    Skill</button>
                <button type="button" onclick="resetForm()"
                    class="py-2 px-4 rounded-lg bg-gray-100 hover:bg-gray-200 text-gray-700 transition">Cancel</button>
            </div>
        </form>
    </div>
</div>

<script>
    function editSkill(skill) {
        document.getElementById('formTitle').textContent = 'Edit Skill';
        document.getElementById('skillId').value = skill.id;
        document.getElementById('skillName').value = skill.name;
        document.getElementById('skillIcon').value = skill.icon;
    }
    function resetForm() {
        document.getElementById('formTitle').textContent = 'Add New Skill';
        document.getElementById('skillId').value = '';
        document.querySelector('form').reset();
    }
</script>

<?php include 'footer.php'; ?>