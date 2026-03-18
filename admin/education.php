<?php include 'header.php'; ?>

<?php
if (isset($_GET['delete'])) {
    $id = (int) $_GET['delete'];
    $pdo->prepare("DELETE FROM education WHERE id = ?")->execute([$id]);
    echo '<div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded">Education record deleted.</div>';
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'] ?? '';
    $year = $_POST['year'] ?? '';
    $title = $_POST['title'] ?? '';
    $school = $_POST['school'] ?? '';

    if ($id) {
        $stmt = $pdo->prepare("UPDATE education SET year=?, title=?, school=? WHERE id=?");
        $stmt->execute([$year, $title, $school, $id]);
        echo '<div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded">Education updated.</div>';
    } else {
        $stmt = $pdo->prepare("INSERT INTO education (year, title, school) VALUES (?, ?, ?)");
        $stmt->execute([$year, $title, $school]);
        echo '<div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded">Education added.</div>';
    }
}

$education = $pdo->query("SELECT * FROM education ORDER BY year DESC")->fetchAll();
?>

<div class="mb-6 flex items-center justify-between">
    <h2 class="text-3xl font-bold text-gray-800">Manage Education</h2>
</div>

<div class="grid grid-cols-1 md:grid-cols-2 gap-8">
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
        <h3 class="bg-gray-50 border-b border-gray-100 p-4 font-semibold text-gray-700">Education Timeline</h3>
        <ul class="divide-y divide-gray-100">
            <?php foreach ($education as $e): ?>
                <li class="p-4 flex items-center justify-between hover:bg-gray-50 transition">
                    <div>
                        <span class="inline-block px-2 py-1 bg-blue-50 text-blue-700 rounded text-xs font-bold mb-1">
                            <?= e($e['year']) ?>
                        </span>
                        <h4 class="font-bold text-gray-900">
                            <?= e($e['title']) ?>
                        </h4>
                        <p class="text-sm text-gray-500">
                            <?= e($e['school']) ?>
                        </p>
                    </div>
                    <div class="flex gap-2">
                        <button onclick='editEdu(<?= json_encode($e) ?>)'
                            class="p-2 text-blue-500 hover:bg-blue-50 rounded-lg transition border border-transparent hover:border-blue-100"><i
                                class="ph ph-pencil-simple text-lg"></i></button>
                        <a href="?delete=<?= $e['id'] ?>" onclick="return confirm('Delete this record?');"
                            class="p-2 text-red-500 hover:bg-red-50 rounded-lg transition border border-transparent hover:border-red-100"><i
                                class="ph ph-trash text-lg"></i></a>
                    </div>
                </li>
                <?php
            endforeach; ?>
        </ul>
    </div>

    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 h-max">
        <h3 class="font-semibold text-gray-700 mb-4 border-b border-gray-100 pb-2" id="formTitle">Add Education Record
        </h3>
        <form method="POST">
            <input type="hidden" name="id" id="eduId">
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-1">Year / Period</label>
                <input type="text" name="year" id="eduYear" required placeholder="e.g. 2023-2027"
                    class="w-full bg-gray-50 border border-gray-300 text-gray-900 rounded-lg py-2 px-3 focus:ring-blue-500">
            </div>
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-1">Degree / Course Title</label>
                <input type="text" name="title" id="eduTitle" required placeholder="e.g. BS Computer Science"
                    class="w-full bg-gray-50 border border-gray-300 text-gray-900 rounded-lg py-2 px-3 focus:ring-blue-500">
            </div>
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-1">School / University</label>
                <input type="text" name="school" id="eduSchool" required placeholder="e.g. COMSATS University"
                    class="w-full bg-gray-50 border border-gray-300 text-gray-900 rounded-lg py-2 px-3 focus:ring-blue-500">
            </div>
            <div class="flex items-center gap-3">
                <button type="submit"
                    class="bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 px-6 rounded-lg shadow-sm transition">Save
                    Education</button>
                <button type="button" onclick="resetForm()"
                    class="py-2 px-4 rounded-lg bg-gray-100 hover:bg-gray-200 text-gray-700 transition">Cancel</button>
            </div>
        </form>
    </div>
</div>

<script>
    function editEdu(edu) {
        document.getElementById('formTitle').textContent = 'Edit Education Record';
        document.getElementById('eduId').value = edu.id;
        document.getElementById('eduYear').value = edu.year;
        document.getElementById('eduTitle').value = edu.title;
        document.getElementById('eduSchool').value = edu.school;
    }
    function resetForm() {
        document.getElementById('formTitle').textContent = 'Add Education Record';
        document.getElementById('eduId').value = '';
        document.querySelector('form').reset();
    }
</script>

<?php include 'footer.php'; ?>