<?php include 'header.php'; ?>

<?php
if (isset($_GET['delete'])) {
    $id = (int)$_GET['delete'];
    $pdo->prepare("DELETE FROM faqs WHERE id = ?")->execute([$id]);
    echo '<div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded">FAQ deleted.</div>';
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'] ?? '';
    $question = $_POST['question'] ?? '';
    $answer = $_POST['answer'] ?? '';

    if ($id) {
        $stmt = $pdo->prepare("UPDATE faqs SET question=?, answer=? WHERE id=?");
        $stmt->execute([$question, $answer, $id]);
        echo '<div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded">FAQ updated.</div>';
    }
    else {
        $stmt = $pdo->prepare("INSERT INTO faqs (question, answer) VALUES (?, ?)");
        $stmt->execute([$question, $answer]);
        echo '<div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded">FAQ added.</div>';
    }
}

$faqs = $pdo->query("SELECT * FROM faqs ORDER BY id ASC")->fetchAll();
?>

<div class="mb-6 flex items-center justify-between">
    <h2 class="text-3xl font-bold text-gray-800">Manage FAQs</h2>
</div>

<div class="grid grid-cols-1 lg:grid-cols-2 gap-8">

    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 h-max order-last lg:order-first">
        <h3 class="font-semibold text-gray-700 mb-4 border-b border-gray-100 pb-2" id="formTitle">Add FAQ</h3>
        <form method="POST">
            <input type="hidden" name="id" id="faqId">
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-1">Question (e.g. 01. What is...)</label>
                <input type="text" name="question" id="faqQuestion" required
                    class="w-full bg-gray-50 border border-gray-300 text-gray-900 rounded-lg py-2 px-3 focus:ring-blue-500">
            </div>
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-1">Answer</label>
                <textarea rows="4" name="answer" id="faqAnswer" required
                    class="w-full bg-gray-50 border border-gray-300 text-gray-900 rounded-lg py-2 px-3 focus:ring-blue-500"></textarea>
            </div>
            <div class="flex items-center gap-3">
                <button type="submit"
                    class="bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 px-6 rounded-lg shadow-sm transition">Save
                    FAQ</button>
                <button type="button" onclick="resetForm()"
                    class="py-2 px-4 rounded-lg bg-gray-100 hover:bg-gray-200 text-gray-700 transition">Cancel</button>
            </div>
        </form>
    </div>

    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden order-first lg:order-last">
        <div class="bg-gray-50 border-b border-gray-100 p-4 font-semibold text-gray-700">All Questions</div>
        <div class="divide-y divide-gray-100">
            <?php foreach ($faqs as $f): ?>
            <div class="p-4 hover:bg-gray-50 transition">
                <div class="flex items-start justify-between">
                    <div class="pr-6">
                        <h4 class="font-bold text-gray-900 mb-1">
                            <?= e($f['question'])?>
                        </h4>
                        <p class="text-sm text-gray-600">
                            <?= e($f['answer'])?>
                        </p>
                    </div>
                    <div class="flex gap-2 shrink-0">
                        <button onclick='editFaq(<?= json_encode($f)?>)'
                            class="p-2 text-blue-500 hover:bg-blue-50 rounded-lg transition border border-transparent hover:border-blue-100"><i
                                class="ph ph-pencil-simple text-lg"></i></button>
                        <a href="?delete=<?= $f['id']?>" onclick="return confirm('Delete FAQ?');"
                            class="p-2 text-red-500 hover:bg-red-50 rounded-lg transition border border-transparent hover:border-red-100"><i
                                class="ph ph-trash text-lg"></i></a>
                    </div>
                </div>
            </div>
            <?php
endforeach; ?>
        </div>
    </div>
</div>

<script>
    function editFaq(f) {
        document.getElementById('formTitle').textContent = 'Edit FAQ';
        document.getElementById('faqId').value = f.id;
        document.getElementById('faqQuestion').value = f.question;
        document.getElementById('faqAnswer').value = f.answer;
    }
    function resetForm() {
        document.getElementById('formTitle').textContent = 'Add FAQ';
        document.getElementById('faqId').value = '';
        document.querySelector('form').reset();
    }
</script>

<?php include 'footer.php'; ?>