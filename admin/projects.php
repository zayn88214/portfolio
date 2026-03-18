<?php include 'header.php'; ?>

<?php
// Handle Delete
if (isset($_GET['delete'])) {
    $id = (int)$_GET['delete'];
    $stmt = $pdo->prepare("SELECT image_path FROM projects WHERE id = ?");
    $stmt->execute([$id]);
    $project = $stmt->fetch();

    if ($project && $project['image_path'] && file_exists('../' . $project['image_path'])) {
        unlink('../' . $project['image_path']);
    }

    $pdo->prepare("DELETE FROM projects WHERE id = ?")->execute([$id]);
    echo '<div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded">Project deleted successfully!</div>';
}

// Handle Add / Edit
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'] ?? '';
    $title = $_POST['title'] ?? '';
    $description = $_POST['description'] ?? '';
    $link = $_POST['link'] ?? '';
    $category = $_POST['category'] ?? '';

    $imagePath = $_POST['existing_image'] ?? '';

    if (isset($_FILES['image']) && $_FILES['image']['error'] == UPLOAD_ERR_OK) {
        $uploadDir = '../images/projects/';
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0777, true);
        }
        $filename = uniqid() . '_' . basename($_FILES['image']['name']);
        if (move_uploaded_file($_FILES['image']['tmp_name'], $uploadDir . $filename)) {
            $imagePath = 'images/projects/' . $filename;
        }
    }

    if ($id) {
        $stmt = $pdo->prepare("UPDATE projects SET title=?, description=?, image_path=?, link=?, category=? WHERE id=?");
        $stmt->execute([$title, $description, $imagePath, $link, $category, $id]);
        echo '<div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded">Project updated successfully!</div>';
    }
    else {
        $stmt = $pdo->prepare("INSERT INTO projects (title, description, image_path, link, category) VALUES (?, ?, ?, ?, ?)");
        $stmt->execute([$title, $description, $imagePath, $link, $category]);
        echo '<div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded">Project added successfully!</div>';
    }
}

$projects = $pdo->query("SELECT * FROM projects ORDER BY created_at DESC")->fetchAll();
?>

<div class="mb-6 flex items-center justify-between">
    <h2 class="text-3xl font-bold text-gray-800">Manage Projects</h2>
    <button onclick="document.getElementById('projectModal').classList.remove('hidden')"
        class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 flex items-center gap-2 rounded-lg transition shadow-sm">
        <i class="ph ph-plus-circle text-lg"></i> Add New Project
    </button>
</div>

<div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
    <table class="w-full text-left border-collapse">
        <thead>
            <tr class="bg-gray-50 border-b border-gray-100">
                <th class="py-3 px-6 font-semibold text-sm text-gray-600">Image</th>
                <th class="py-3 px-6 font-semibold text-sm text-gray-600">Title</th>
                <th class="py-3 px-6 font-semibold text-sm text-gray-600">Category</th>
                <th class="py-3 px-6 font-semibold text-sm text-gray-600 text-right">Actions</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-100">
            <?php foreach ($projects as $p): ?>
            <tr class="hover:bg-gray-50/50 transition">
                <td class="py-3 px-6">
                    <?php if ($p['image_path']): ?>
                    <div class="w-16 h-12 rounded overflow-hidden bg-gray-100 border border-gray-200">
                        <img src="../<?= e($p['image_path'])?>" class="w-full h-full object-cover">
                    </div>
                    <?php
    else: ?>
                    <div
                        class="w-16 h-12 bg-gray-100 rounded flex items-center justify-center text-gray-400 border border-gray-200">
                        <i class="ph ph-image text-xl"></i></div>
                    <?php
    endif; ?>
                </td>
                <td class="py-3 px-6 text-gray-800 font-medium">
                    <?= e($p['title'])?>
                </td>
                <td class="py-3 px-6 text-gray-500">
                    <span
                        class="bg-blue-50 text-blue-600 text-xs px-2 py-1 rounded-md border border-blue-100 flex inline-block w-max">
                        <?= e($p['category'])?>
                    </span>
                </td>
                <td class="py-3 px-6 text-right">
                    <div class="flex justify-end gap-2">
                        <button onclick="editProject(<?= htmlspecialchars(json_encode($p), ENT_QUOTES, 'UTF-8')?>)"
                            class="p-2 text-blue-500 hover:bg-blue-50 rounded-lg transition border border-transparent hover:border-blue-100"><i
                                class="ph ph-pencil-simple text-lg"></i></button>
                        <a href="?delete=<?= $p['id']?>"
                            onclick="return confirm('Are you sure you want to delete this project?');"
                            class="p-2 text-red-500 hover:bg-red-50 rounded-lg transition border border-transparent hover:border-red-100"><i
                                class="ph ph-trash text-lg"></i></a>
                    </div>
                </td>
            </tr>
            <?php
endforeach; ?>

            <?php if (empty($projects)): ?>
            <tr>
                <td colspan="4" class="py-8 text-center text-gray-500">No projects found. Create one.</td>
            </tr>
            <?php
endif; ?>
        </tbody>
    </table>
</div>

<!-- Add/Edit Modal -->
<div id="projectModal" class="hidden fixed inset-0 bg-black/50 z-50 flex items-center justify-center p-4">
    <div class="bg-white rounded-xl shadow-2xl w-full max-w-2xl max-h-[90vh] overflow-y-auto">
        <div class="flex items-center justify-between p-6 border-b border-gray-100">
            <h3 class="text-xl font-bold text-gray-900" id="modalTitle">Add Project</h3>
            <button onclick="closeModal()" class="text-gray-400 hover:text-gray-600 transition"><i
                    class="ph ph-x text-xl"></i></button>
        </div>
        <form method="POST" enctype="multipart/form-data" class="p-6">
            <input type="hidden" name="id" id="projectId">
            <input type="hidden" name="existing_image" id="projectExistingImage">

            <div class="space-y-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Title</label>
                    <input type="text" name="title" id="projectTitle" required
                        class="w-full bg-gray-50 border border-gray-300 text-gray-900 rounded-lg py-2 px-3 focus:ring-blue-500">
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Category (e.g. web, UI)</label>
                        <input type="text" name="category" id="projectCategory"
                            class="w-full bg-gray-50 border border-gray-300 text-gray-900 rounded-lg py-2 px-3 focus:ring-blue-500">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Live/Repo Link</label>
                        <input type="url" name="link" id="projectLink"
                            class="w-full bg-gray-50 border border-gray-300 text-gray-900 rounded-lg py-2 px-3 focus:ring-blue-500">
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Image Upload</label>
                    <input type="file" name="image" accept="image/*"
                        class="w-full bg-gray-50 border border-gray-300 text-gray-900 rounded-lg py-2 px-3 focus:ring-blue-500">
                    <p class="text-xs text-gray-500 mt-1">Leave blank to keep existing image</p>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Description</label>
                    <textarea name="description" id="projectDescription" rows="3"
                        class="w-full bg-gray-50 border border-gray-300 text-gray-900 rounded-lg py-2 px-3 focus:ring-blue-500"></textarea>
                </div>
            </div>

            <div class="mt-6 flex justify-end gap-3">
                <button type="button" onclick="closeModal()"
                    class="px-4 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 transition">Cancel</button>
                <button type="submit"
                    class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition">Save
                    Project</button>
            </div>
        </form>
    </div>
</div>

<script>
    function editProject(project) {
        document.getElementById('modalTitle').textContent = 'Edit Project';
        document.getElementById('projectId').value = project.id;
        document.getElementById('projectTitle').value = project.title;
        document.getElementById('projectCategory').value = project.category;
        document.getElementById('projectLink').value = project.link;
        document.getElementById('projectDescription').value = project.description;
        document.getElementById('projectExistingImage').value = project.image_path;
        document.getElementById('projectModal').classList.remove('hidden');
    }

    function closeModal() {
        document.getElementById('modalTitle').textContent = 'Add Project';
        document.getElementById('projectId').value = '';
        document.getElementById('projectExistingImage').value = '';
        document.querySelector('form').reset();
        document.getElementById('projectModal').classList.add('hidden');
    }
</script>

<?php include 'footer.php'; ?>