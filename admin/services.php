<?php include 'header.php'; ?>

<?php
if (isset($_GET['delete'])) {
    $id = (int)$_GET['delete'];
    $pdo->prepare("DELETE FROM services WHERE id = ?")->execute([$id]);
    echo '<div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded">Service deleted.</div>';
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'] ?? '';
    $title = $_POST['title'] ?? '';
    $description = $_POST['description'] ?? '';

    if ($id) {
        $stmt = $pdo->prepare("UPDATE services SET title=?, description=? WHERE id=?");
        $stmt->execute([$title, $description, $id]);
        echo '<div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded">Service updated.</div>';
    }
    else {
        $stmt = $pdo->prepare("INSERT INTO services (title, description) VALUES (?, ?)");
        $stmt->execute([$title, $description]);
        echo '<div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded">Service added.</div>';
    }
}

$services = $pdo->query("SELECT * FROM services ORDER BY id ASC")->fetchAll();
?>

<div class="mb-6 flex items-center justify-between">
    <h2 class="text-3xl font-bold text-gray-800">Manage Services</h2>
    <p class="text-gray-500">Highlight cards showing what you offer.</p>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

    <!-- List -->
    <div class="col-span-1 lg:col-span-2 bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="divide-y divide-gray-100">
            <?php foreach ($services as $s): ?>
            <div class="p-6 flex items-start justify-between hover:bg-gray-50 transition group">
                <div>
                    <h4 class="text-lg font-bold text-gray-900 mb-1">
                        <?= e($s['title'])?>
                    </h4>
                    <p class="text-sm text-gray-600 max-w-xl">
                        <?= e($s['description'])?>
                    </p>
                </div>
                <div class="flex gap-2">
                    <button onclick='editService(<?= json_encode($s)?>)'
                        class="p-2 text-blue-500 hover:bg-blue-50 rounded-lg transition border border-transparent hover:border-blue-100"><i
                            class="ph ph-pencil-simple text-lg"></i></button>
                    <a href="?delete=<?= $s['id']?>" onclick="return confirm('Delete this service?');"
                        class="p-2 text-red-500 hover:bg-red-50 rounded-lg transition border border-transparent hover:border-red-100"><i
                            class="ph ph-trash text-lg"></i></a>
                </div>
            </div>
            <?php
endforeach; ?>
        </div>
    </div>

    <!-- Form -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 h-max">
        <h3 class="font-semibold text-gray-700 mb-4 border-b border-gray-100 pb-2" id="formTitle">Add Service Card</h3>
        <form method="POST">
            <input type="hidden" name="id" id="serviceId">
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-1">Service Title</label>
                <input type="text" name="title" id="serviceTitle" required
                    class="w-full bg-gray-50 border border-gray-300 text-gray-900 rounded-lg py-2 px-3 focus:ring-blue-500">
            </div>
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-1">Short Description</label>
                <textarea rows="3" name="description" id="serviceDescription" required
                    class="w-full bg-gray-50 border border-gray-300 text-gray-900 rounded-lg py-2 px-3 focus:ring-blue-500"></textarea>
            </div>
            <div class="flex items-center gap-3">
                <button type="submit"
                    class="bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 px-6 rounded-lg shadow-sm transition">Save
                    Data</button>
                <button type="button" onclick="resetForm()"
                    class="py-2 px-4 rounded-lg bg-gray-100 hover:bg-gray-200 text-gray-700 transition">Cancel</button>
            </div>
        </form>
    </div>
</div>

<script>
    function editService(s) {
        document.getElementById('formTitle').textContent = 'Edit Service Card';
        document.getElementById('serviceId').value = s.id;
        document.getElementById('serviceTitle').value = s.title;
        document.getElementById('serviceDescription').value = s.description;
    }
    function resetForm() {
        document.getElementById('formTitle').textContent = 'Add Service Card';
        document.getElementById('serviceId').value = '';
        document.querySelector('form').reset();
    }
</script>

<?php include 'footer.php'; ?>