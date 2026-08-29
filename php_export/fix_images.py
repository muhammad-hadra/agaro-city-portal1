import re
import os

# Fix admin.php
with open('admin.php', 'r', encoding='utf-8') as f:
    admin_content = f.read()

old_upload_block = """        if (isset($_FILES['image_file']) && $_FILES['image_file']['error'] === UPLOAD_ERR_OK) {
            $uploadDir = 'uploads/';
            if (!is_dir($uploadDir)) mkdir($uploadDir, 0777, true);
            $fileName = time() . '_' . basename($_FILES['image_file']['name']);
            $targetPath = $uploadDir . $fileName;"""

new_upload_block = """        if (isset($_FILES['image_file']) && $_FILES['image_file']['error'] === UPLOAD_ERR_OK) {
            $uploadDir = 'uploads/';
            if (!is_dir($uploadDir)) mkdir($uploadDir, 0777, true);
            $extension = pathinfo($_FILES['image_file']['name'], PATHINFO_EXTENSION);
            $fileName = time() . '_' . substr(md5(uniqid()), 0, 8) . '.' . $extension;
            $targetPath = $uploadDir . $fileName;"""

admin_content = admin_content.replace(old_upload_block, new_upload_block)

with open('admin.php', 'w', encoding='utf-8') as f:
    f.write(admin_content)

# Fix config.php
with open('config.php', 'r', encoding='utf-8') as f:
    config_content = f.read()

config_content = config_content.replace(
    "'nav_news' => ['en' => 'News Feed', 'om' => 'Oduu', 'am' => 'የከተማው ዜና']",
    "'nav_news' => ['en' => 'News & Events', 'om' => 'Oduu fi Taateewwan', 'am' => 'ዜና እና ዝግጅቶች']"
)

with open('config.php', 'w', encoding='utf-8') as f:
    f.write(config_content)

# Fix index.php
with open('index.php', 'r', encoding='utf-8') as f:
    index_content = f.read()

# 1. Fetch events
events_fetch_code = """
// Fetch events from Database
$events = [];
if ($pdo) {
    try {
        $stmt = $pdo->query("SELECT * FROM events ORDER BY date DESC");
        $events = $stmt->fetchAll();
    } catch (Exception $e) { }
}
"""

# Find where to insert events fetch (after news block)
insert_pos = index_content.find('// Fetch Cabinet listings from Database (with fallback defaults)')
if insert_pos != -1:
    index_content = index_content[:insert_pos] + events_fetch_code + index_content[insert_pos:]

# 2. Update News tab render
old_news_render = """                    <div class="flex justify-between items-center border-b border-slate-150 pb-3">
                        <h3 class="font-display font-extrabold text-[#ca8a04] text-lg tracking-tight">Municipal Announcements & Bulletins</h3>
                        <span class="text-slate-450 text-[10px] font-mono font-bold"><?php echo count($news); ?> Releases Active</span>
                    </div>

                    <div class="grid gap-8 md:grid-cols-2">
                        <?php foreach ($news as $article): ?>
                            <article class="bg-white border border-slate-200/80 rounded-3xl overflow-hidden shadow-subtle flex flex-col justify-between hover:scale-[1.01] transition-transform duration-300">
                                <div class="space-y-4">
                                    <div class="h-48 w-full bg-slate-100 overflow-hidden relative">
                                        <img src="<?php echo htmlspecialchars($article['image'] ?: 'https://images.unsplash.com/photo-1501339847302-ac426a4a7cbb?auto=format&fit=crop&q=80&w=600'); ?>" alt="Press" class="h-full w-full object-cover" />"""

new_news_render = """                    <div class="flex justify-between items-center border-b border-slate-150 pb-3">
                        <h3 class="font-display font-extrabold text-[#ca8a04] text-lg tracking-tight">Municipal Announcements & Bulletins</h3>
                        <span class="text-slate-450 text-[10px] font-mono font-bold"><?php echo count($news) + count($events); ?> Releases Active</span>
                    </div>

                    <div class="grid gap-8 md:grid-cols-2">
                        <?php 
                        $all_items = array_merge($news, $events);
                        usort($all_items, function($a, $b) {
                            return strtotime($b['date']) - strtotime($a['date']);
                        });
                        foreach ($all_items as $article): 
                            $raw_img = $article['image'] ?: 'https://images.unsplash.com/photo-1501339847302-ac426a4a7cbb?auto=format&fit=crop&q=80&w=600';
                            $img_encoded = strpos($raw_img, 'http') === 0 ? $raw_img : implode('/', array_map('rawurlencode', explode('/', $raw_img)));
                        ?>
                            <article class="bg-white border border-slate-200/80 rounded-3xl overflow-hidden shadow-subtle flex flex-col justify-between hover:scale-[1.01] transition-transform duration-300">
                                <div class="space-y-4">
                                    <div class="h-48 w-full bg-slate-100 overflow-hidden relative">
                                        <img src="<?php echo htmlspecialchars($img_encoded); ?>" alt="Press" class="h-full w-full object-cover" />"""

index_content = index_content.replace(old_news_render, new_news_render)

with open('index.php', 'w', encoding='utf-8') as f:
    f.write(index_content)

print("Updates applied successfully.")
