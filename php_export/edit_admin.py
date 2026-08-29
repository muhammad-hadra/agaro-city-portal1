import sys

with open('admin.php', 'r', encoding='utf-8') as f:
    lines = f.readlines()

new_backend = """    $pdo = getDB();
    $adminTab = isset($_GET['admin_tab']) ? $_GET['admin_tab'] : 'news';
    
    // Create events table if not exists
    if ($pdo) {
        try {
            $pdo->exec("CREATE TABLE IF NOT EXISTS events (
                id VARCHAR(255) PRIMARY KEY,
                category VARCHAR(255),
                date DATE,
                image VARCHAR(255),
                title_en TEXT, title_om TEXT, title_am TEXT,
                excerpt_en TEXT, excerpt_om TEXT, excerpt_am TEXT,
                content_en TEXT, content_om TEXT, content_am TEXT
            )");
        } catch (Exception $e) {}
    }

    // 1. Save or Update News Article
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['save_article'])) {
        $id = $_POST['article_id'] ?: 'news-' . time();
        $category = $_POST['category'];
        
        $image = $_POST['image'] ?? '';
        if (isset($_FILES['image_file']) && $_FILES['image_file']['error'] === UPLOAD_ERR_OK) {
            $uploadDir = 'uploads/';
            if (!is_dir($uploadDir)) mkdir($uploadDir, 0777, true);
            $fileName = time() . '_' . basename($_FILES['image_file']['name']);
            $targetPath = $uploadDir . $fileName;
            if (move_uploaded_file($_FILES['image_file']['tmp_name'], $targetPath)) {
                $image = $targetPath;
            }
        }
        
        $date = date('Y-m-d');
        
        $title_en = $_POST['title_en'] ?? ''; $title_om = $_POST['title_om'] ?? ''; $title_am = $_POST['title_am'] ?? '';
        $excerpt_en = $_POST['excerpt_en'] ?? ''; $excerpt_om = $_POST['excerpt_om'] ?? ''; $excerpt_am = $_POST['excerpt_am'] ?? '';
        $content_en = $_POST['content_en'] ?? ''; $content_om = $_POST['content_om'] ?? ''; $content_am = $_POST['content_am'] ?? '';
        
        if ($pdo) {
            try {
                if ($_POST['article_id']) {
                    $stmt = $pdo->prepare("UPDATE news SET category=?, image=?, title_en=?, title_om=?, title_am=?, excerpt_en=?, excerpt_om=?, excerpt_am=?, content_en=?, content_om=?, content_am=? WHERE id=?");
                    $stmt->execute([$category, $image, $title_en, $title_om, $title_am, $excerpt_en, $excerpt_om, $excerpt_am, $content_en, $content_om, $content_am, $id]);
                } else {
                    $stmt = $pdo->prepare("INSERT INTO news (id, category, date, image, title_en, title_om, title_am, excerpt_en, excerpt_om, excerpt_am, content_en, content_om, content_am) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
                    $stmt->execute([$id, $category, $date, $image, $title_en, $title_om, $title_am, $excerpt_en, $excerpt_om, $excerpt_am, $content_en, $content_om, $content_am]);
                }
                $toastMessage = "News article stored in database.";
            } catch (Exception $e) { $toastMessage = "Save failed: " . $e->getMessage(); }
        }
    }
    
    // 2. Remove News Article
    if (isset($_GET['delete_news'])) {
        $delId = $_GET['delete_news'];
        if ($pdo) {
            try {
                $stmt = $pdo->prepare("DELETE FROM news WHERE id = ?");
                $stmt->execute([$delId]);
                $toastMessage = "News removed from registries.";
            } catch (Exception $e) { }
        }
        header("Location: admin.php?admin_tab=news&toast=" . urlencode($toastMessage));
        exit();
    }

    // 3. Save or Update Event
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['save_event'])) {
        $id = $_POST['event_id'] ?: 'event-' . time();
        $category = $_POST['category'];
        
        $image = $_POST['image'] ?? '';
        if (isset($_FILES['image_file']) && $_FILES['image_file']['error'] === UPLOAD_ERR_OK) {
            $uploadDir = 'uploads/';
            if (!is_dir($uploadDir)) mkdir($uploadDir, 0777, true);
            $fileName = time() . '_' . basename($_FILES['image_file']['name']);
            $targetPath = $uploadDir . $fileName;
            if (move_uploaded_file($_FILES['image_file']['tmp_name'], $targetPath)) {
                $image = $targetPath;
            }
        }
        
        $date = $_POST['date'] ?: date('Y-m-d');
        
        $title_en = $_POST['title_en'] ?? ''; $title_om = $_POST['title_om'] ?? ''; $title_am = $_POST['title_am'] ?? '';
        $excerpt_en = $_POST['excerpt_en'] ?? ''; $excerpt_om = $_POST['excerpt_om'] ?? ''; $excerpt_am = $_POST['excerpt_am'] ?? '';
        $content_en = $_POST['content_en'] ?? ''; $content_om = $_POST['content_om'] ?? ''; $content_am = $_POST['content_am'] ?? '';
        
        if ($pdo) {
            try {
                if ($_POST['event_id']) {
                    $stmt = $pdo->prepare("UPDATE events SET category=?, image=?, title_en=?, title_om=?, title_am=?, excerpt_en=?, excerpt_om=?, excerpt_am=?, content_en=?, content_om=?, content_am=?, date=? WHERE id=?");
                    $stmt->execute([$category, $image, $title_en, $title_om, $title_am, $excerpt_en, $excerpt_om, $excerpt_am, $content_en, $content_om, $content_am, $date, $id]);
                } else {
                    $stmt = $pdo->prepare("INSERT INTO events (id, category, date, image, title_en, title_om, title_am, excerpt_en, excerpt_om, excerpt_am, content_en, content_om, content_am) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
                    $stmt->execute([$id, $category, $date, $image, $title_en, $title_om, $title_am, $excerpt_en, $excerpt_om, $excerpt_am, $content_en, $content_om, $content_am]);
                }
                $toastMessage = "Event stored in database.";
            } catch (Exception $e) { $toastMessage = "Save failed: " . $e->getMessage(); }
        }
    }
    
    // 4. Remove Event
    if (isset($_GET['delete_event'])) {
        $delId = $_GET['delete_event'];
        if ($pdo) {
            try {
                $stmt = $pdo->prepare("DELETE FROM events WHERE id = ?");
                $stmt->execute([$delId]);
                $toastMessage = "Event removed from registries.";
            } catch (Exception $e) { }
        }
        header("Location: admin.php?admin_tab=events&toast=" . urlencode($toastMessage));
        exit();
    }

    // --- FETCH DATA FOR DISPLAYS ---
    $newsList = []; $eventsList = [];
    if ($pdo) {
        try {
            $newsList = $pdo->query("SELECT * FROM news ORDER BY date DESC")->fetchAll();
            try {
                $eventsList = $pdo->query("SELECT * FROM events ORDER BY date DESC")->fetchAll();
            } catch (Exception $e) {}
        } catch (Exception $e) {}
    }
}
"""

new_header = """                <div class="flex items-center gap-4">
                    <a href="?logout=1" class="bg-slate-800 border border-slate-700 text-rose-450 hover:bg-rose-950 px-4 py-2.5 rounded-xl text-xs font-bold transition-colors">Sign Out Desk</a>
                </div>
"""

new_tabs = """            <!-- Navigation Tabs -->
            <div class="flex bg-white border border-slate-205 p-1 rounded-2xl gap-2 overflow-x-auto select-none shadow-subtle shrink-0">
                <a href="?admin_tab=news" class="flex-1 text-center py-3 text-xs font-bold rounded-xl whitespace-nowrap <?php echo ($adminTab === 'news' || $adminTab === 'metrics') ? 'bg-brand-green-700 text-white font-black' : 'text-slate-600 hover:bg-slate-100'; ?>">📰 News</a>
                <a href="?admin_tab=events" class="flex-1 text-center py-3 text-xs font-bold rounded-xl whitespace-nowrap <?php echo $adminTab === 'events' ? 'bg-brand-green-700 text-white font-black' : 'text-slate-600 hover:bg-slate-100'; ?>">📅 Events</a>
            </div>
"""

new_ui = """            <!-- VIEWSTAGE ROUTING -->

            <!-- TAB: NEWS -->
            <?php if ($adminTab === 'news' || $adminTab === 'metrics'): ?>
                <div class="space-y-8 animate-fade-in">
                    <!-- Publisher form -->
                    <div class="bg-white border border-slate-200 rounded-3xl p-6 sm:p-8 shadow-sm space-y-6">
                        <h3 class="font-display font-extrabold text-xl text-[#ca8a04]">Publish News Release</h3>
                        
                        <form method="POST" enctype="multipart/form-data" class="space-y-4">
                            <input type="hidden" name="save_article" value="1" />
                            <input type="hidden" name="article_id" id="article_id" value="" />
                            
                            <div class="grid gap-4 sm:grid-cols-2">
                                <div class="space-y-1">
                                    <label class="block text-[10px] font-bold text-slate-600 uppercase">Sector Category</label>
                                    <select required name="category" class="w-full text-xs.5 bg-slate-50 border border-slate-200 rounded-xl px-3.5 py-2.5 focus:bg-white focus:outline-none">
                                        <option value="Infrastructure">Infrastructure Development</option>
                                        <option value="Health">Health & Sanitaiton</option>
                                        <option value="Agriculture">Agriculture & Coffee cooperative</option>
                                        <option value="Municipal">Municipal Service Upgrade</option>
                                    </select>
                                </div>
                                <div class="space-y-1">
                                    <label class="block text-[10px] font-bold text-slate-600 uppercase">Upload Image</label>
                                    <input type="file" name="image_file" accept="image/*" class="w-full text-xs.5 bg-slate-50 border border-slate-200 rounded-xl px-3.5 py-2 focus:bg-white focus:outline-none" />
                                    <input type="hidden" name="image" value="" />
                                </div>
                            </div>

                            <div class="grid gap-4 sm:grid-cols-3">
                                <div class="space-y-1">
                                    <label class="block text-[10px] font-bold text-slate-600 uppercase">Title (English)*</label>
                                    <input type="text" required name="title_en" placeholder="English Title" class="w-full text-xs.5 bg-slate-50 border border-slate-200 rounded-xl px-3.5 py-2.5 focus:bg-white focus:outline-none" />
                                </div>
                                <div class="space-y-1">
                                    <label class="block text-[10px] font-bold text-slate-600 uppercase">Title (Afan Oromo)*</label>
                                    <input type="text" required name="title_om" placeholder="Afaan Oromoo Title" class="w-full text-xs.5 bg-slate-50 border border-slate-200 rounded-xl px-3.5 py-2.5 focus:bg-white focus:outline-none" />
                                </div>
                                <div class="space-y-1">
                                    <label class="block text-[10px] font-bold text-slate-600 uppercase">Title (Amharic)*</label>
                                    <input type="text" required name="title_am" placeholder="الأمهرية Title" class="w-full text-xs.5 bg-slate-50 border border-slate-200 rounded-xl px-3.5 py-2.5 focus:bg-white focus:outline-none" />
                                </div>
                            </div>

                            <div class="grid gap-4 sm:grid-cols-3">
                                <div class="space-y-1">
                                    <label class="block text-[10px] font-bold text-slate-600 uppercase font-mono">Excerpt (English)*</label>
                                    <textarea required rows="2" name="excerpt_en" class="w-full text-xs.5 bg-slate-50 border border-slate-200 rounded-xl p-3 focus:bg-white focus:outline-none"></textarea>
                                </div>
                                <div class="space-y-1">
                                    <label class="block text-[10px] font-bold text-slate-600 uppercase font-mono">Excerpt (Afan Oromo)*</label>
                                    <textarea required rows="2" name="excerpt_om" class="w-full text-xs.5 bg-slate-50 border border-slate-200 rounded-xl p-3 focus:bg-white focus:outline-none"></textarea>
                                </div>
                                <div class="space-y-1">
                                    <label class="block text-[10px] font-bold text-slate-600 uppercase font-mono">Excerpt (Amharic)*</label>
                                    <textarea required rows="2" name="excerpt_am" class="w-full text-xs.5 bg-slate-50 border border-slate-200 rounded-xl p-3 focus:bg-white focus:outline-none"></textarea>
                                </div>
                            </div>

                            <div class="grid gap-4 sm:grid-cols-3">
                                <div class="space-y-1">
                                    <label class="block text-[10px] font-bold text-slate-600 uppercase font-mono">Story (English)*</label>
                                    <textarea required rows="4" name="content_en" class="w-full text-xs.5 bg-slate-50 border border-slate-200 rounded-xl p-3 focus:bg-white focus:outline-none"></textarea>
                                </div>
                                <div class="space-y-1">
                                    <label class="block text-[10px] font-bold text-slate-600 uppercase font-mono">Story (Afan Oromo)*</label>
                                    <textarea required rows="4" name="content_om" class="w-full text-xs.5 bg-slate-50 border border-slate-200 rounded-xl p-3 focus:bg-white focus:outline-none"></textarea>
                                </div>
                                <div class="space-y-1">
                                    <label class="block text-[10px] font-bold text-slate-600 uppercase font-mono">Story (Amharic)*</label>
                                    <textarea required rows="4" name="content_am" class="w-full text-xs.5 bg-slate-50 border border-slate-200 rounded-xl p-3 focus:bg-white focus:outline-none"></textarea>
                                </div>
                            </div>

                            <div class="flex justify-end pt-2">
                                <button type="submit" class="bg-brand-green-700 hover:bg-brand-green-800 text-white font-bold py-3.5 px-6 rounded-xl text-xs shadow cursor-pointer">
                                    Publish News
                                </button>
                            </div>
                        </form>
                    </div>

                    <!-- News Table list -->
                    <div class="bg-white border border-slate-200 rounded-3xl overflow-hidden shadow-sm">
                        <table class="w-full text-left">
                            <thead class="bg-slate-50 text-[10px] uppercase font-bold text-slate-400 tracking-wider border-b border-slate-200">
                                <tr>
                                    <th class="p-4 pl-6">Title</th>
                                    <th class="p-4">Category</th>
                                    <th class="p-4">Publish Date</th>
                                    <th class="p-4 text-right pr-6">Action</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-100 text-xs.5 font-medium">
                                <?php foreach ($newsList as $item): ?>
                                    <tr class="hover:bg-slate-50">
                                        <td class="p-4 pl-6 font-bold text-slate-800"><?php echo htmlspecialchars($item['title_en'] ?? ''); ?></td>
                                        <td class="p-4"><span class="bg-brand-green-50 text-brand-green-700 px-2.5 py-0.5 rounded-full text-[10px] font-bold"><?php echo htmlspecialchars($item['category'] ?? ''); ?></span></td>
                                        <td class="p-4 font-mono text-slate-500"><?php echo htmlspecialchars($item['date'] ?? ''); ?></td>
                                        <td class="p-4 text-right pr-6">
                                            <a href="?admin_tab=news&delete_news=<?php echo urlencode($item['id'] ?? ''); ?>" onclick="return confirm('Remove news?')" class="text-rose-600 hover:underline">Remove</a>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            <?php endif; ?>

            <!-- TAB: EVENTS -->
            <?php if ($adminTab === 'events'): ?>
                <div class="space-y-8 animate-fade-in">
                    <!-- Publisher form -->
                    <div class="bg-white border border-slate-200 rounded-3xl p-6 sm:p-8 shadow-sm space-y-6">
                        <h3 class="font-display font-extrabold text-xl text-[#ca8a04]">Create Event</h3>
                        
                        <form method="POST" enctype="multipart/form-data" class="space-y-4">
                            <input type="hidden" name="save_event" value="1" />
                            <input type="hidden" name="event_id" id="event_id" value="" />
                            
                            <div class="grid gap-4 sm:grid-cols-3">
                                <div class="space-y-1">
                                    <label class="block text-[10px] font-bold text-slate-600 uppercase">Event Date</label>
                                    <input type="date" required name="date" class="w-full text-xs.5 bg-slate-50 border border-slate-200 rounded-xl px-3.5 py-2.5 focus:bg-white focus:outline-none" />
                                </div>
                                <div class="space-y-1">
                                    <label class="block text-[10px] font-bold text-slate-600 uppercase">Category</label>
                                    <select required name="category" class="w-full text-xs.5 bg-slate-50 border border-slate-200 rounded-xl px-3.5 py-2.5 focus:bg-white focus:outline-none">
                                        <option value="Community">Community Event</option>
                                        <option value="Festival">Festival</option>
                                        <option value="Meeting">Public Meeting</option>
                                        <option value="Other">Other</option>
                                    </select>
                                </div>
                                <div class="space-y-1">
                                    <label class="block text-[10px] font-bold text-slate-600 uppercase">Upload Image</label>
                                    <input type="file" name="image_file" accept="image/*" class="w-full text-xs.5 bg-slate-50 border border-slate-200 rounded-xl px-3.5 py-2 focus:bg-white focus:outline-none" />
                                    <input type="hidden" name="image" value="" />
                                </div>
                            </div>

                            <div class="grid gap-4 sm:grid-cols-3">
                                <div class="space-y-1">
                                    <label class="block text-[10px] font-bold text-slate-600 uppercase">Title (English)*</label>
                                    <input type="text" required name="title_en" placeholder="English Title" class="w-full text-xs.5 bg-slate-50 border border-slate-200 rounded-xl px-3.5 py-2.5 focus:bg-white focus:outline-none" />
                                </div>
                                <div class="space-y-1">
                                    <label class="block text-[10px] font-bold text-slate-600 uppercase">Title (Afan Oromo)*</label>
                                    <input type="text" required name="title_om" placeholder="Afaan Oromoo Title" class="w-full text-xs.5 bg-slate-50 border border-slate-200 rounded-xl px-3.5 py-2.5 focus:bg-white focus:outline-none" />
                                </div>
                                <div class="space-y-1">
                                    <label class="block text-[10px] font-bold text-slate-600 uppercase">Title (Amharic)*</label>
                                    <input type="text" required name="title_am" placeholder="الأمهرية Title" class="w-full text-xs.5 bg-slate-50 border border-slate-200 rounded-xl px-3.5 py-2.5 focus:bg-white focus:outline-none" />
                                </div>
                            </div>

                            <div class="grid gap-4 sm:grid-cols-3">
                                <div class="space-y-1">
                                    <label class="block text-[10px] font-bold text-slate-600 uppercase font-mono">Excerpt (English)*</label>
                                    <textarea required rows="2" name="excerpt_en" class="w-full text-xs.5 bg-slate-50 border border-slate-200 rounded-xl p-3 focus:bg-white focus:outline-none"></textarea>
                                </div>
                                <div class="space-y-1">
                                    <label class="block text-[10px] font-bold text-slate-600 uppercase font-mono">Excerpt (Afan Oromo)*</label>
                                    <textarea required rows="2" name="excerpt_om" class="w-full text-xs.5 bg-slate-50 border border-slate-200 rounded-xl p-3 focus:bg-white focus:outline-none"></textarea>
                                </div>
                                <div class="space-y-1">
                                    <label class="block text-[10px] font-bold text-slate-600 uppercase font-mono">Excerpt (Amharic)*</label>
                                    <textarea required rows="2" name="excerpt_am" class="w-full text-xs.5 bg-slate-50 border border-slate-200 rounded-xl p-3 focus:bg-white focus:outline-none"></textarea>
                                </div>
                            </div>

                            <div class="grid gap-4 sm:grid-cols-3">
                                <div class="space-y-1">
                                    <label class="block text-[10px] font-bold text-slate-600 uppercase font-mono">Details (English)*</label>
                                    <textarea required rows="4" name="content_en" class="w-full text-xs.5 bg-slate-50 border border-slate-200 rounded-xl p-3 focus:bg-white focus:outline-none"></textarea>
                                </div>
                                <div class="space-y-1">
                                    <label class="block text-[10px] font-bold text-slate-600 uppercase font-mono">Details (Afan Oromo)*</label>
                                    <textarea required rows="4" name="content_om" class="w-full text-xs.5 bg-slate-50 border border-slate-200 rounded-xl p-3 focus:bg-white focus:outline-none"></textarea>
                                </div>
                                <div class="space-y-1">
                                    <label class="block text-[10px] font-bold text-slate-600 uppercase font-mono">Details (Amharic)*</label>
                                    <textarea required rows="4" name="content_am" class="w-full text-xs.5 bg-slate-50 border border-slate-200 rounded-xl p-3 focus:bg-white focus:outline-none"></textarea>
                                </div>
                            </div>

                            <div class="flex justify-end pt-2">
                                <button type="submit" class="bg-brand-green-700 hover:bg-brand-green-800 text-white font-bold py-3.5 px-6 rounded-xl text-xs shadow cursor-pointer">
                                    Publish Event
                                </button>
                            </div>
                        </form>
                    </div>

                    <!-- Events Table list -->
                    <div class="bg-white border border-slate-200 rounded-3xl overflow-hidden shadow-sm">
                        <table class="w-full text-left">
                            <thead class="bg-slate-50 text-[10px] uppercase font-bold text-slate-400 tracking-wider border-b border-slate-200">
                                <tr>
                                    <th class="p-4 pl-6">Title</th>
                                    <th class="p-4">Category</th>
                                    <th class="p-4">Event Date</th>
                                    <th class="p-4 text-right pr-6">Action</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-100 text-xs.5 font-medium">
                                <?php foreach ($eventsList as $item): ?>
                                    <tr class="hover:bg-slate-50">
                                        <td class="p-4 pl-6 font-bold text-slate-800"><?php echo htmlspecialchars($item['title_en'] ?? ''); ?></td>
                                        <td class="p-4"><span class="bg-brand-green-50 text-brand-green-700 px-2.5 py-0.5 rounded-full text-[10px] font-bold"><?php echo htmlspecialchars($item['category'] ?? ''); ?></span></td>
                                        <td class="p-4 font-mono text-slate-500"><?php echo htmlspecialchars($item['date'] ?? ''); ?></td>
                                        <td class="p-4 text-right pr-6">
                                            <a href="?admin_tab=events&delete_event=<?php echo urlencode($item['id'] ?? ''); ?>" onclick="return confirm('Remove event?')" class="text-rose-600 hover:underline">Remove</a>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            <?php endif; ?>
"""

new_lines = lines[:40] + [new_backend] + lines[164:249] + [new_header] + lines[253:266] + [new_tabs] + lines[273:274] + [new_ui] + lines[646:]

with open('admin.php', 'w', encoding='utf-8') as f:
    f.writelines(new_lines)

print("Replaced content successfully.")
