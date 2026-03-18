<?php include 'header.php'; ?>

<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Save settings
    $stmt = $pdo->prepare("INSERT INTO settings (key_name, key_value) VALUES (?, ?) ON DUPLICATE KEY UPDATE key_value = VALUES(key_value)");

    foreach ($_POST['settings'] as $key => $value) {
        $stmt->execute([$key, $value]);
    }

    // Handle specific file upload for hero image if provided
    if (isset($_FILES['hero_image_file']) && $_FILES['hero_image_file']['error'] == UPLOAD_ERR_OK) {
        $uploadDir = '../images/';
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0777, true);
        }
        $filename = uniqid() . '_hero_' . basename($_FILES['hero_image_file']['name']);
        $uploadFile = $uploadDir . $filename;
        if (move_uploaded_file($_FILES['hero_image_file']['tmp_name'], $uploadFile)) {
            $stmt->execute(['profile_image_hero', 'images/' . $filename]);
        }
    }

    // Handle specific file upload for about image if provided
    if (isset($_FILES['about_image_file']) && $_FILES['about_image_file']['error'] == UPLOAD_ERR_OK) {
        $uploadDir = '../images/';
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0777, true);
        }
        $filename = uniqid() . '_about_' . basename($_FILES['about_image_file']['name']);
        $uploadFile = $uploadDir . $filename;
        if (move_uploaded_file($_FILES['about_image_file']['tmp_name'], $uploadFile)) {
            $stmt->execute(['about_image', 'images/' . $filename]);
        }
    }

    echo '<div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">Settings updated successfully!</div>';
}

$settings = getSettings($pdo);
?>

<div class="mb-6 flex items-center justify-between">
    <h2 class="text-3xl font-bold text-gray-800">Site Settings</h2>
</div>

<form method="POST" action="" enctype="multipart/form-data"
    class="bg-white rounded-xl shadow-sm border border-gray-100 p-8 space-y-8">

    <!-- Hero Section Group -->
    <div>
        <h3 class="text-xl font-bold text-gray-900 border-b pb-2 mb-4">Hero Section</h3>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Eyebrow Text (e.g. Hello I'm)</label>
                <input type="text" name="settings[hero_eyebrow]" value="<?= e($settings['hero_eyebrow'] ?? '') ?>"
                    class="w-full bg-gray-50 border border-gray-300 text-gray-900 rounded-lg py-2.5 px-4 focus:ring-blue-500 focus:border-blue-500 transition">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">First Name (e.g. Zain)</label>
                <input type="text" name="settings[hero_title_1]" value="<?= e($settings['hero_title_1'] ?? '') ?>"
                    class="w-full bg-gray-50 border border-gray-300 text-gray-900 rounded-lg py-2.5 px-4 focus:ring-blue-500 focus:border-blue-500 transition">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Last Name (e.g. Ul Abideen)</label>
                <input type="text" name="settings[hero_title_2]" value="<?= e($settings['hero_title_2'] ?? '') ?>"
                    class="w-full bg-gray-50 border border-gray-300 text-gray-900 rounded-lg py-2.5 px-4 focus:ring-blue-500 focus:border-blue-500 transition">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Accent / Role</label>
                <input type="text" name="settings[hero_accent]" value="<?= e($settings['hero_accent'] ?? '') ?>"
                    class="w-full bg-gray-50 border border-gray-300 text-gray-900 rounded-lg py-2.5 px-4 focus:ring-blue-500 focus:border-blue-500 transition">
            </div>
            <div class="col-span-1 md:col-span-2">
                <label class="block text-sm font-medium text-gray-700 mb-2">Subheading</label>
                <input type="text" name="settings[hero_subhead]" value="<?= e($settings['hero_subhead'] ?? '') ?>"
                    class="w-full bg-gray-50 border border-gray-300 text-gray-900 rounded-lg py-2.5 px-4 focus:ring-blue-500 focus:border-blue-500 transition">
            </div>
            <div class="col-span-1 md:col-span-2">
                <label class="block text-sm font-medium text-gray-700 mb-2">Lead Text</label>
                <textarea rows="3" name="settings[hero_lead]"
                    class="w-full bg-gray-50 border border-gray-300 text-gray-900 rounded-lg py-2.5 px-4 focus:ring-blue-500 focus:border-blue-500 transition"><?= e($settings['hero_lead'] ?? '') ?></textarea>
            </div>
        </div>
    </div>

    <!-- About Section Group -->
    <div>
        <h3 class="text-xl font-bold text-gray-900 border-b pb-2 mb-4">About Me</h3>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div class="col-span-1 md:col-span-2">
                <label class="block text-sm font-medium text-gray-700 mb-2">Upload Profile Image (Hero Section)</label>
                <div class="flex items-center gap-4">
                    <img src="../<?= e($settings['profile_image_hero'] ?? 'images/profileimg.png') ?>" alt="Preview"
                        class="w-16 h-16 rounded-full object-cover border-2 shadow">
                    <input type="file" name="hero_image_file" accept="image/*"
                        class="w-full bg-gray-50 border border-gray-300 text-gray-900 rounded-lg py-2 px-4 focus:ring-blue-500">
                </div>
            </div>
            <div class="col-span-1 md:col-span-2">
                <label class="block text-sm font-medium text-gray-700 mb-2">Upload Profile Image (About Section)</label>
                <div class="flex items-center gap-4">
                    <img src="../<?= e($settings['about_image'] ?? 'images/profileimg.png') ?>" alt="Preview"
                        class="w-16 h-16 rounded-full object-cover border-2 shadow">
                    <input type="file" name="about_image_file" accept="image/*"
                        class="w-full bg-gray-50 border border-gray-300 text-gray-900 rounded-lg py-2 px-4 focus:ring-blue-500">
                </div>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Eyebrow</label>
                <input type="text" name="settings[about_eyebrow]" value="<?= e($settings['about_eyebrow'] ?? '') ?>"
                    class="w-full bg-gray-50 border border-gray-300 text-gray-900 rounded-lg py-2.5 px-4 focus:ring-blue-500 focus:border-blue-500 transition">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Heading</label>
                <input type="text" name="settings[about_heading]" value="<?= e($settings['about_heading'] ?? '') ?>"
                    class="w-full bg-gray-50 border border-gray-300 text-gray-900 rounded-lg py-2.5 px-4 focus:ring-blue-500 focus:border-blue-500 transition">
            </div>
            <div class="col-span-1 md:col-span-2">
                <label class="block text-sm font-medium text-gray-700 mb-2">Short About Bio (Homepage)</label>
                <textarea rows="3" name="settings[about_text]"
                    class="w-full bg-gray-50 border border-gray-300 text-gray-900 rounded-lg py-2.5 px-4 focus:ring-blue-500 focus:border-blue-500 transition"><?= e($settings['about_text'] ?? '') ?></textarea>
            </div>
            <div class="col-span-1 md:col-span-2">
                <label class="block text-sm font-medium text-gray-700 mb-2">Long Profile Description (Who I am)</label>
                <textarea rows="5" name="settings[profile_text]"
                    class="w-full bg-gray-50 border border-gray-300 text-gray-900 rounded-lg py-2.5 px-4 focus:ring-blue-500 focus:border-blue-500 transition"><?= e($settings['profile_text'] ?? '') ?></textarea>
            </div>
        </div>
    </div>

    <!-- Social Links Group -->
    <div>
        <h3 class="text-xl font-bold text-gray-900 border-b pb-2 mb-4">Social & Contact Links</h3>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">GitHub URL</label>
                <input type="url" name="settings[github_link]" value="<?= e($settings['github_link'] ?? '') ?>"
                    class="w-full bg-gray-50 border border-gray-300 text-gray-900 rounded-lg py-2.5 px-4 focus:ring-blue-500 focus:border-blue-500 transition">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">LinkedIn URL</label>
                <input type="url" name="settings[linkedin_link]" value="<?= e($settings['linkedin_link'] ?? '') ?>"
                    class="w-full bg-gray-50 border border-gray-300 text-gray-900 rounded-lg py-2.5 px-4 focus:ring-blue-500 focus:border-blue-500 transition">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Email Link</label>
                <input type="text" name="settings[email_link]" value="<?= e($settings['email_link'] ?? '') ?>"
                    class="w-full bg-gray-50 border border-gray-300 text-gray-900 rounded-lg py-2.5 px-4 focus:ring-blue-500 focus:border-blue-500 transition">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Phone Number</label>
                <input type="text" name="settings[phone_number]" value="<?= e($settings['phone_number'] ?? '') ?>"
                    class="w-full bg-gray-50 border border-gray-300 text-gray-900 rounded-lg py-2.5 px-4 focus:ring-blue-500 focus:border-blue-500 transition">
            </div>
        </div>
    </div>

    <!-- Footer Settings -->
    <div>
        <h3 class="text-xl font-bold text-gray-900 border-b pb-2 mb-4">Bottom CTA & Footer</h3>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">CTA Eyebrow</label>
                <input type="text" name="settings[cta_eyebrow]" value="<?= e($settings['cta_eyebrow'] ?? '') ?>"
                    class="w-full bg-gray-50 border border-gray-300 text-gray-900 rounded-lg py-2.5 px-4 focus:ring-blue-500">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">CTA Heading</label>
                <input type="text" name="settings[cta_heading]" value="<?= e($settings['cta_heading'] ?? '') ?>"
                    class="w-full bg-gray-50 border border-gray-300 text-gray-900 rounded-lg py-2.5 px-4 focus:ring-blue-500">
            </div>
            <div class="col-span-1 md:col-span-2">
                <label class="block text-sm font-medium text-gray-700 mb-2">Footer Copyright Notice</label>
                <input type="text" name="settings[footer_copyright]"
                    value="<?= e($settings['footer_copyright'] ?? '') ?>"
                    class="w-full bg-gray-50 border border-gray-300 text-gray-900 rounded-lg py-2.5 px-4 focus:ring-blue-500">
            </div>
        </div>
    </div>

    <div class="pt-6 border-t flex justify-end">
        <button type="submit"
            class="bg-blue-600 hover:bg-blue-700 text-white font-semibold py-3 px-8 rounded-lg shadow-sm transition flex items-center gap-2">
            <i class="ph ph-floppy-disk text-lg"></i>
            Save Content
        </button>
    </div>
</form>

<?php include 'footer.php'; ?>