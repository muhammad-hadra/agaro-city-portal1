<?php
// index.php
// Master front-end gateway for Agaro City Administration Portal in PHP
require_once 'config.php';

$activeTab = isset($_GET['active_tab']) ? $_GET['active_tab'] : 'home';
$pdo = getDB();

// Fetch news announcements from Database (with fallback defaults)
$news = [];
if ($pdo) {
    try {
        $stmt = $pdo->query("SELECT * FROM news ORDER BY date DESC");
        $news = $stmt->fetchAll();
    } catch (Exception $e) { }
}
if (empty($news)) {
    // Fail-safe fallbacks if DB is offline/unset
    $news = [
        [
            'id' => 'news-1',
            'category' => 'Infrastructure',
            'date' => '2026-06-08',
            'image' => 'https://images.unsplash.com/photo-1541888946425-d81bb19240f5?auto=format&fit=crop&q=80&w=600',
            'title_en' => 'Agaro Urban Highway Upgrade Project Commences',
            'title_om' => 'Projektiin Kiriipii Daandii Magaalaa Aggaaroo Jalqabameera',
            'title_am' => 'የአጋሮ ከተማ አስፋልት ማሻሻያ ፕሮጀክት በይፋ ተጀመረ',
            'excerpt_en' => 'Contractors have broken ground on the 4.8km high-traffic artery linking Kebele 02 to central coffee loading hubs.',
            'excerpt_om' => 'Kondraakteroonni hojii daandii km 4.8 kan walitti fidu Goxoota 02 fi giddu-gala bunaa gidduutti jalqabuuf socho\'aa jiru.',
            'excerpt_am' => 'ከቀበሌ 02 እስከ ማዕከላዊ የቡና መጫኛ ማዕከላት የሚያገናኘውን 4.8 ኪሎ ሜትር የከተማ መንገድ ለማሻሻል ስራ ተጀመረ።',
            'content_en' => 'This modern highway project includes proper storm-water drainage canals and solar streetlights to ensure safety, reduce logistics costs, and speed up transportation.',
            'content_om' => 'Projektiin kun hifannaa lola weelduu, karaa bishaanii fi hulaa ibsaa aduu of keessatti hammata.',
            'content_am' => 'ይህ ዘመናዊ የጎዳና ልማት ፕሮጀክት የተሟላ የጎርፍ ማፍሰሻ ቦዮች እና የፀሐይ ኃይል የጎዳና መብራቶችን ያካተተ ሲሆን የቡና መጫኛ መኪኖችን ጉዞ ያቀልጣል።'
        ],
        [
            'id' => 'news-2',
            'category' => 'Agriculture',
            'date' => '2026-06-05',
            'image' => 'https://images.unsplash.com/photo-1501339847302-ac426a4a7cbb?auto=format&fit=crop&q=80&w=600',
            'title_en' => 'New Coffee Processing Cooperative Union Launched',
            'title_om' => 'Gamtaa Hojii Babal\'ina Bunaa Haaraa Hundeeffame',
            'title_am' => 'አዲስ የቡና ማቀነባበሪያ ልማት ህብረት ስራ ማህበር ተመሠረተ',
            'excerpt_en' => 'The strategic cooperative aims to optimize coffee washing facilities across 3 bordering rural kebeles.',
            'excerpt_om' => 'Gamtaan kun buufataale bishaan buna qulqulleessuu fi dachaasuu goxoota rural sadii keessatti babal\'isuuf kaayyeeffata.',
            'excerpt_am' => 'ይህ ስትራቴጂካዊ ህብረት ስራ ማህበር 3 የገጠር ቀበሌዎች ውስጥ የሚገኙ የቡና እጥበት ማዕከላትን ለማሳደግ ያለመ ነው።',
            'content_en' => 'With investment from the Regional Administration, local farmers will gain direct access to wet mills and dry graders, maximizing export revenue.',
            'content_om' => 'Buna qulqullina olaana qabu gara gabaa addunyaatti erguuf, tekinooloojii wet-mill fi dachaasuu hammayyaa kenna.',
            'content_am' => 'የክልሉ አስተዳደር ባደረገው የገንዘብ ድጋፍ፣ የአካባቢው አርሶ አደሮች ሥነ-ምህዳርን የማይጎዱ የእጥበት ማቀነባበሪያዎችን በመጠቀም ምርታቸውን በቀጥታ ለውጭ ገበያ ማቅረብ ይችላሉ።'
        ]
    ];
}


// Fetch events from Database
$events = [];
if ($pdo) {
    try {
        $stmt = $pdo->query("SELECT * FROM events ORDER BY date DESC");
        $events = $stmt->fetchAll();
    } catch (Exception $e) { }
}
// Fetch Cabinet listings from Database (with fallback defaults)
$cabinet = [];
if ($pdo) {
    try {
        $stmt = $pdo->query("SELECT * FROM cabinet");
        $cabinet = $stmt->fetchAll();
    } catch (Exception $e) { }
}
if (empty($cabinet)) {
    $cabinet = [
        [
            'name' => 'Hon. Jemal Abasimel',
            'image' => 'https://images.unsplash.com/photo-1560250097-0b93528c311a?auto=format&fit=crop&q=80&w=256',
            'email' => 'mayor@agarocity.gov.et',
            'role_en' => 'City Administrator / Mayor', 'role_om' => 'Kantiibaa Magaalaa', 'role_am' => 'የከተማው አስተዳዳሪ / ከንቲባ',
            'desk_en' => 'Executive Cabinet & Strategy', 'desk_om' => 'Koree Hojii Raawwachiiftuu', 'desk_am' => 'ስራ አስፈጻሚ ካቢኔ እና ስትራቴጂ'
        ],
        [
            'name' => 'Ato Muktar Kedir',
            'image' => 'https://images.unsplash.com/photo-1519085360753-af0119f7cbe7?auto=format&fit=crop&q=80&w=256',
            'email' => 'finance@agarocity.gov.et',
            'role_en' => 'Cabinet Member / Secretary', 'role_om' => 'Miseensa Kaabineefi Barreessaa', 'role_am' => 'የካቢኔ አባል እና ፀሃፊ',
            'desk_en' => 'Revenue, Finance & Public Procurement', 'desk_om' => 'Kutaa Galii fi Finaansii', 'desk_am' => 'ገቢዎች፣ ፋይናንስ እና ግዢ'
        ],
        [
            'name' => 'W/ro Chaltu Gemeda',
            'image' => 'https://images.unsplash.com/photo-1573496359142-b8d87734a5a2?auto=format&fit=crop&q=80&w=256',
            'email' => 'land@agarocity.gov.et',
            'role_en' => 'Cabinet Member', 'role_om' => 'Miseensa Kaabinee', 'role_am' => 'የካቢኔ አባል',
            'desk_en' => 'Land Development & Zoning Masterplan', 'desk_om' => 'Ijaarama Lafaa fi Pilaanii', 'desk_am' => 'የመሬት ልማት እና ፕላን'
        ]
    ];
}

// Fetch Mayor Bio data (with fallback defaults)
$mayor = null;
if ($pdo) {
    try {
        $stmt = $pdo->query("SELECT * FROM mayor_profile LIMIT 1");
        $mayor = $stmt->fetch();
    } catch (Exception $e) { }
}
if (!$mayor) {
    $mayor = [
        'name' => 'Hon. Jemal Abasimel',
        'image' => 'https://images.unsplash.com/photo-1560250097-0b93528c311a?auto=format&fit=crop&q=80&w=256',
        'email' => 'mayor@agarocity.gov.et',
        'role_en' => 'Honorary Regional Mayor', 'role_om' => 'Kantiibaa Kabajaa Magaalaa', 'role_am' => 'የክብር ከንቲባ',
        'desk_en' => 'Agaro Strategic Executive Council', 'desk_om' => 'Marii Hojii Raawwachiiftuu Tarsiimoo', 'desk_am' => 'የአጋሮ ስትራቴጂክ ስራ አስፈፃሚ ምክር ቤት',
        'term_en' => '2022 - present', 'term_om' => '2022 - Amma', 'term_am' => 'ከ2014 - አሁን',
        'priority1_en' => 'Expand high-yield coffee export value chains.', 'priority1_om' => 'Valdaalee gurgurtaa buna guddina kennuufi jabeessuu.', 'priority1_am' => 'የላቀ የቡና ምርት ወጪ ንግድን እና እሴት ሰንሰለትን ማስፋፋት።',
        'priority2_en' => 'Decentralize municipal support desks into 9 robust Kebeles.', 'priority2_om' => 'Tajaajila bulchiinsa magaalaa goxoota 9tti fiduu.', 'priority2_am' => 'የማዘጋጃ ቤት አገልግሎት መስኮቶችን ወደ 9 ጠንካራ ቀበሌዎች ማሰራጨት።',
        'priority3_en' => 'Achieve 100% electronic billing and rapid public works response.', 'priority3_om' => 'Nageenya kaffaltii elektirooniksii 100% fi daandii ijaaruu.', 'priority3_am' => '100% ኤሌክትሮኒክ የክፍያ ሥርዓት መዘርጋት እና ፈጣን ምላሽ ማረጋገጥ።'
    ];
}

// Handle tracker queries
$searchedApp = null;
$trackerError = '';
if (isset($_GET['track_id'])) {
    $trackId = intval($_GET['track_id']);
    if ($pdo) {
        try {
            $stmt = $pdo->prepare("SELECT * FROM applications WHERE id = ?");
            $stmt->execute([$trackId]);
            $searchedApp = $stmt->fetch();
            if (!$searchedApp) {
                $trackerError = 'No dynamic application matching ID #' . $trackId . ' was located.';
            }
        } catch (Exception $e) {
            $trackerError = 'Application search query failed.';
        }
    } else {
        // Fallback demo lookup for testing
        if ($trackId === 105) {
            $searchedApp = [
                'id' => 105,
                'first_name' => 'Ato Chala',
                'last_name' => 'Girma',
                'service_type' => 'Business Trade License',
                'kebele' => 'Kebele 01',
                'status' => 'approved',
                'history_json' => json_encode([
                    ['status' => 'Cabinet Officer Approved', 'date' => '2026-06-10', 'comments' => 'Signature finalized.'],
                    ['status' => 'Submitted', 'date' => '2026-06-08', 'comments' => 'Initial upload.']
                ])
            ];
        } else {
            $trackerError = 'Offline Demo: Enter ID 105 to test local index lookup.';
        }
    }
}
?>
<!DOCTYPE html>
<html lang="<?php echo $currentLang; ?>">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo t('hero_title', $currentLang); ?> - Official Portal</title>
    <!-- Google Fonts Inter, Space Grotesk -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800;900&family=Space+Grotesk:wght@500;600;700&family=JetBrains+Mono:wght@400;500&display=swap" rel="stylesheet">
    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        brand: {
                            gold: {
                                50: '#fdfdf6',
                                100: '#fbf9eb',
                                150: '#f5efc8',
                                500: '#ca8a04',
                                600: '#b47b01',
                                750: '#854d0e'
                            },
                            green: {
                                50: '#f5fbf7',
                                700: '#15803d',
                                750: '#166534',
                                800: '#14532d'
                            }
                        }
                    },
                    fontFamily: {
                        sans: ['Inter', 'sans-serif'],
                        display: ['Space Grotesk', 'sans-serif'],
                        mono: ['JetBrains Mono', 'monospace_retro']
                    }
                }
            }
        }
    </script>
    <style>
        .custom-scrollbar::-webkit-scrollbar {
            width: 5px;
            height: 5px;
        }
        .custom-scrollbar::-webkit-scrollbar-track {
            background: #0f172a;
        }
        .custom-scrollbar::-webkit-scrollbar-thumb {
            background: #ca8a04;
            border-radius: 9px;
        }
    </style>
</head>
<body class="bg-[#fafafa] text-slate-800 font-sans min-h-screen flex flex-col md:flex-row antialiased">

    <!-- DESKTOP NAV SIDEBAR -->
    <aside class="hidden md:flex md:w-80 bg-slate-900 border-r border-slate-850 px-6 py-8 flex-col justify-between shrink-0 select-none text-white">
        <div class="space-y-8">
            <!-- Municipal Emblem Card -->
            <div id="sidebar-brand-card" class="flex items-center gap-3 bg-slate-800/40 p-4 border.5 border-slate-800 rounded-2xl">
                <div class="h-10 w-10 rounded-xl bg-brand-gold-500 flex items-center justify-center font-display font-black text-slate-950 text-xl.5 shadow shadow-brand-gold-500/20">
                    A
                </div>
                <div>
                    <h1 class="font-display font-extrabold text-[#ca8a04] tracking-tight leading-tight">Agaro Gov</h1>
                    <p class="text-[9.5px] text-slate-400 font-medium tracking-wide uppercase">Oromia, Ethiopia</p>
                </div>
            </div>

            <!-- Tab Links -->
            <nav class="space-y-2.5">
                <p class="text-[9px] uppercase font-bold text-slate-500 tracking-widest pl-3 mb-1">MUNICIPAL DEPARTMENTS</p>
                
                <a id="lnk-nav-home" href="?active_tab=home" class="flex items-center gap-3 px-4 py-3 text-xs.5 font-bold rounded-xl transition-all <?php echo $activeTab === 'home' ? 'bg-brand-green-700 text-white shadow shadow-brand-green-700/20' : 'text-slate-350 hover:bg-slate-800/50 hover:text-white'; ?>">
                    📁 Home Dashboard
                </a>

                <a id="lnk-nav-services" href="?active_tab=services" class="flex items-center gap-3 px-4 py-3 text-xs.5 font-bold rounded-xl transition-all <?php echo $activeTab === 'services' ? 'bg-brand-green-700 text-white shadow shadow-brand-green-700/20' : 'text-slate-350 hover:bg-slate-800/50 hover:text-white'; ?>">
                    📂 <?php echo t('nav_services', $currentLang); ?>
                </a>

                <a id="lnk-nav-news" href="?active_tab=news" class="flex items-center gap-3 px-4 py-3 text-xs.5 font-bold rounded-xl transition-all <?php echo $activeTab === 'news' ? 'bg-brand-green-700 text-white shadow shadow-brand-green-700/20' : 'text-slate-350 hover:bg-slate-800/50 hover:text-white'; ?>">
                    📢 <?php echo t('nav_news', $currentLang); ?>
                </a>

                <a id="lnk-nav-departments" href="?active_tab=departments" class="flex items-center gap-3 px-4 py-3 text-xs.5 font-bold rounded-xl transition-all <?php echo $activeTab === 'departments' ? 'bg-brand-green-700 text-white shadow shadow-brand-green-700/20' : 'text-slate-350 hover:bg-slate-800/50 hover:text-white'; ?>">
                    🏛️ Mayor & Cabinet
                </a>

                <a id="lnk-nav-contact" href="?active_tab=contact" class="flex items-center gap-3 px-4 py-3 text-xs.5 font-bold rounded-xl transition-all <?php echo $activeTab === 'contact' ? 'bg-brand-green-700 text-white shadow shadow-brand-green-700/20' : 'text-slate-350 hover:bg-slate-800/50 hover:text-white'; ?>">
                    ✉️ Support & Tickets
                </a>
            </nav>
        </div>

        <!-- Language toggle and admin panel buttons -->
        <div class="space-y-4">
            <!-- Secure Admin Panel Entry Link -->
            <a href="admin_manage.php" class="w-full inline-flex items-center justify-center gap-2 px-3.5 py-3 text-[11px] font-black tracking-wide bg-slate-800 text-brand-gold-500 border border-slate-700 rounded-xl hover:bg-brand-gold-500 hover:text-slate-950 hover:border-brand-gold-600 transition-all font-sans">
                🛡️ SYSTEM ADMINISTRATIVE DESK
            </a>

            <div class="h-px bg-slate-800"></div>

            <div class="flex items-center justify-between">
                <span class="text-[10px] font-bold text-slate-500 uppercase">LANG</span>
                <div class="inline-flex bg-slate-850 p-0.5 rounded-lg border border-slate-805">
                    <a href="?active_tab=<?php echo $activeTab; ?>&lang=en" class="px-2 py-1 text-[10px] font-bold rounded-md <?php echo $currentLang === 'en' ? 'bg-[#ca8a04] text-slate-950 font-black' : 'text-slate-400 hover:text-white'; ?>">EN</a>
                    <a href="?active_tab=<?php echo $activeTab; ?>&lang=om" class="px-2 py-1 text-[10px] font-bold rounded-md <?php echo $currentLang === 'om' ? 'bg-[#ca8a04] text-slate-950 font-black' : 'text-slate-400 hover:text-white'; ?>">OM</a>
                    <a href="?active_tab=<?php echo $activeTab; ?>&lang=am" class="px-2 py-1 text-[10px] font-bold rounded-md <?php echo $currentLang === 'am' ? 'bg-[#ca8a04] text-slate-950 font-black' : 'text-slate-400 hover:text-white'; ?>">AM</a>
                </div>
            </div>
        </div>
    </aside>

    <!-- MOBILE NAV HEADER BAR -->
    <header class="md:hidden w-full bg-slate-900 px-4 py-3 flex flex-col gap-3 select-none text-white border-b border-slate-800 shrink-0">
        <div class="flex items-center justify-between">
            <div class="flex items-center gap-2.5">
                <div class="h-8 w-8 rounded-lg bg-brand-gold-500 flex items-center justify-center font-display font-black text-slate-950 text-md">
                    A
                </div>
                <div>
                    <h1 class="font-display font-extrabold text-sm text-brand-gold-500 tracking-tight leading-none">Agaro Portal</h1>
                </div>
            </div>

            <!-- Mobile Active Language -->
            <div class="inline-flex bg-slate-800 p-0.5 border.5 border-slate-755 rounded-lg">
                <a href="?active_tab=<?php echo $activeTab; ?>&lang=en" class="px-1.5 py-0.5 text-[9.5px] font-bold <?php echo $currentLang === 'en' ? 'bg-[#ca8a04] text-[#0f172a]' : 'text-slate-400'; ?>">EN</a>
                <a href="?active_tab=<?php echo $activeTab; ?>&lang=om" class="px-1.5 py-0.5 text-[9.5px] font-bold <?php echo $currentLang === 'om' ? 'bg-[#ca8a04] text-[#0f172a]' : 'text-slate-400'; ?>">OM</a>
                <a href="?active_tab=<?php echo $activeTab; ?>&lang=am" class="px-1.5 py-0.5 text-[9.5px] font-bold <?php echo $currentLang === 'am' ? 'bg-[#ca8a04] text-[#0f172a]' : 'text-slate-400'; ?>">AM</a>
            </div>
        </div>

        <!-- Horizontal scrollbar navigation menu -->
        <div class="flex gap-2.5 overflow-x-auto pb-1 custom-scrollbar shrink-0 text-xs">
            <a href="?active_tab=home" class="px-3.5 py-1.5 font-bold rounded-lg whitespace-nowrap border <?php echo $activeTab === 'home' ? 'bg-brand-green-700 text-white border-brand-green-700/10' : 'bg-slate-800/40 text-slate-350 border-slate-800'; ?>">Home</a>
            <a href="?active_tab=services" class="px-3.5 py-1.5 font-bold rounded-lg whitespace-nowrap border <?php echo $activeTab === 'services' ? 'bg-brand-green-700 text-white border-brand-green-700/10' : 'bg-slate-800/40 text-slate-350 border-slate-800'; ?>"><?php echo t('nav_services', $currentLang); ?></a>
            <a href="?active_tab=news" class="px-3.5 py-1.5 font-bold rounded-lg whitespace-nowrap border <?php echo $activeTab === 'news' ? 'bg-brand-green-700 text-white border-brand-green-700/10' : 'bg-slate-800/40 text-slate-350 border-slate-800'; ?>"><?php echo t('nav_news', $currentLang); ?></a>
            <a href="?active_tab=departments" class="px-3.5 py-1.5 font-bold rounded-lg whitespace-nowrap border <?php echo $activeTab === 'departments' ? 'bg-brand-green-700 text-white border-brand-green-700/10' : 'bg-slate-800/40 text-slate-350 border-slate-800'; ?>">Mayor & Cabinet</a>
            <a href="?active_tab=contact" class="px-3.5 py-1.5 font-bold rounded-lg whitespace-nowrap border <?php echo $activeTab === 'contact' ? 'bg-brand-green-700 text-white border-brand-green-700/10' : 'bg-slate-800/40 text-slate-350 border-slate-800'; ?>">Support</a>
            <a href="admin_manage.php" class="px-3.5 py-1.5 font-bold rounded-lg bg-amber-950 text-brand-gold-500 border border-amber-900 whitespace-nowrap">🛡️ Admin</a>
        </div>
    </header>


    <!-- MAIN CONTENT VIEWSTAGE -->
    <main class="flex-1 max-w-7xl mx-auto px-4 sm:px-8 py-8 md:py-12 flex flex-col gap-8 w-full overflow-hidden">
        
        <!-- SECTION BANNER HEADER -->
        <section id="banner-section" class="bg-gradient-to-br from-slate-900 to-slate-950 rounded-3xl p-8 border border-slate-800 flex flex-col md:flex-row justify-between items-start md:items-center gap-6 shadow-md text-white select-none">
            <div class="space-y-2">
                <span class="text-[9px] uppercase font-extrabold tracking-widest text-[#ca8a04]">
                    <?php echo ($currentLang === 'en' ? 'Official Government Portal' : ($currentLang === 'om' ? 'Mootummaa Magaalaa' : 'ኦፊሴላዊ የመንግስት ድህረ ገጽ')); ?>
                </span>
                <h2 class="font-display font-extrabold text-2.5xl leading-tight text-white"><?php echo t('hero_title', $currentLang); ?></h2>
                <p class="text-xs text-slate-400 font-medium max-w-lg leading-relaxed"><?php echo t('hero_subtitle', $currentLang); ?></p>
            </div>
            
            <div class="grid grid-cols-2 gap-4 border border-slate-800 bg-slate-900/50 p-4.5 rounded-2xl">
                <div>
                    <span class="block text-[9px] font-bold text-slate-500 uppercase"><?php echo t('population', $currentLang); ?></span>
                    <span class="block text-sm font-bold font-mono text-brand-gold-500">~140,000+</span>
                </div>
                <div>
                    <span class="block text-[9px] font-bold text-slate-500 uppercase"><?php echo t('kebeles', $currentLang); ?></span>
                    <span class="block text-sm font-bold font-mono text-brand-gold-500">09 Admin zones</span>
                </div>
            </div>
        </section>

        <!-- VIEWSTAGE SWITCHER COMPONENT ROUTING -->

        <!-- TAB 1: HOME DEPT STATS & SUMMARY -->
        <?php if ($activeTab === 'home'): ?>
            <section id="view-home" class="space-y-8 animate-fade-in">
                <!-- Strategic Card Deck -->
                <div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-4">
                    <div class="bg-white border border-slate-200/80 p-5 rounded-2xl shadow-subtle flex gap-4 items-center">
                        <div class="h-10 w-10 bg-brand-gold-100 text-brand-gold-700 font-bold border border-brand-gold-150 rounded-xl flex items-center justify-center text-md select-none">☕</div>
                        <div>
                            <span class="block text-[9.5px] font-bold text-slate-400 uppercase tracking-wider">Top Export</span>
                            <span class="block text-xs.5 font-bold text-slate-850">Specialty Forest Coffee</span>
                        </div>
                    </div>
                    <div class="bg-white border border-slate-200/80 p-5 rounded-2xl shadow-subtle flex gap-4 items-center">
                        <div class="h-10 w-10 bg-brand-gold-100 text-brand-gold-700 font-bold border border-brand-gold-150 rounded-xl flex items-center justify-center text-md select-none">🏔️</div>
                        <div>
                            <span class="block text-[9.5px] font-bold text-slate-400 uppercase tracking-wider">Elevation</span>
                            <span class="block text-xs.5 font-bold text-slate-850">1,820 meters AMSL</span>
                        </div>
                    </div>
                    <div class="bg-white border border-slate-200/80 p-5 rounded-2xl shadow-subtle flex gap-4 items-center">
                        <div class="h-10 w-10 bg-brand-gold-100 text-brand-gold-700 font-bold border border-brand-gold-150 rounded-xl flex items-center justify-center text-md select-none">⚙️</div>
                        <div>
                            <span class="block text-[9.5px] font-bold text-slate-400 uppercase tracking-wider">Regional Hub</span>
                            <span class="block text-xs.5 font-bold text-slate-850">Jimma Zone Core Corridor</span>
                        </div>
                    </div>
                    <div class="bg-white border border-slate-200/80 p-5 rounded-2xl shadow-subtle flex gap-4 items-center">
                        <div class="h-10 w-10 bg-brand-gold-100 text-brand-gold-700 font-bold border border-brand-gold-150 rounded-xl flex items-center justify-center text-md select-none">🏛️</div>
                        <div>
                            <span class="block text-[9.5px] font-bold text-slate-400 uppercase tracking-wider">Kebeles</span>
                            <span class="block text-xs.5 font-bold text-slate-850">9 Municipal Segments</span>
                        </div>
                    </div>
                </div>

                <div class="grid md:grid-cols-12 gap-8">
                    <!-- Mayor's priorities -->
                    <div class="md:col-span-8 bg-white border border-slate-200/80 rounded-3xl p-6.5 p-8 shadow-sm space-y-6">
                        <h3 class="font-display font-extrabold text-[#ca8a04] text-lg tracking-tight">Executive Strategic Mandates</h3>
                        <p class="text-xs text-slate-500 leading-relaxed">
                            Under the central direction of Hon. Jemal Abasimel, the Agaro City strategic council ensures that the municipal administrative apparatus is transparent, decentralized, and highly integrated to support regional agricultural export value chains while rendering rapid services directly into the hands of local citizens.
                        </p>
                        
                        <div class="space-y-4">
                            <div class="border border-slate-150/70 rounded-2xl p-4.5 flex gap-4 items-start bg-slate-50/20">
                                <span class="text-brand-green-700 font-display font-black text-lg p-1 bg-brand-green-50 rounded-lg">01</span>
                                <div class="space-y-0.5">
                                    <h4 class="text-xs font-bold text-slate-850">Maximize Specialty Coffee Dry Wash logistics</h4>
                                    <p class="text-[11px] text-slate-450 leading-relaxed">Integrating Kebele highway structures with regional dry coffee grading silos.</p>
                                </div>
                            </div>
                            <div class="border border-slate-150/70 rounded-2xl p-4.5 flex gap-4 items-start bg-slate-50/20">
                                <span class="text-brand-green-700 font-display font-black text-lg p-1 bg-brand-green-50 rounded-lg">02</span>
                                <div class="space-y-0.5">
                                    <h4 class="text-xs font-bold text-slate-850">Decide Electronic Kebele support desks</h4>
                                    <p class="text-[11px] text-slate-450 leading-relaxed">Establishing standalone electronic support registries in the Kebele administration centers.</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Side Stats Information Panel -->
                    <div class="md:col-span-4 bg-slate-900 border border-slate-800 rounded-3xl p-6.5 p-7 text-white shadow-md flex flex-col justify-between">
                        <div class="space-y-4.5">
                            <span class="text-[9.5px] uppercase font-bold text-brand-gold-500 tracking-wider">Fast-links bulletin</span>
                            <h4 class="font-display font-bold text-md leading-relaxed text-white">Need an official license or Certificate?</h4>
                            <p class="text-[11px] text-slate-400 leading-relaxed">
                                Avoid physically commuting to the executive administration lobbies. Deploy an electronic service registry application dynamically on our Services section.
                            </p>
                        </div>
                        <div class="pt-6 border-t border-slate-800 mt-6">
                            <a href="?active_tab=services" class="w-full inline-flex items-center justify-center p-3 rounded-xl bg-brand-gold-500 hover:bg-brand-gold-600 text-slate-950 font-bold text-xs shadow transition-colors">
                                Open Digital Services
                            </a>
                        </div>
                    </div>
                </div>
            </section>
        <?php endif; ?>


        <!-- TAB 2: PORTAL SERVICES APP & TRACKER -->
        <?php if ($activeTab === 'services'): ?>
            <section id="view-services" class="space-y-8 animate-fade-in flex flex-col items-center">
                
                <!-- Feedback success notice -->
                <?php if (isset($_GET['app_success'])): ?>
                    <div class="w-full max-w-4xl bg-brand-green-50 border border-brand-green-700/20 text-brand-green-800 rounded-2xl p-6 flex gap-4 items-start shadow-sm mb-2 select-none animate-fade-in uppercase-title">
                        <span class="text-xl">✅</span>
                        <div class="space-y-1">
                            <h4 class="text-xs font-bold text-brand-green-800">Dynamic Citizen Application Submitted Successfully</h4>
                            <p class="text-[11px] text-slate-650 leading-relaxed">Your request was logged. Keep record of your tracking ID: <span class="font-mono bg-white border border-brand-green-700/15 text-brand-green-800 px-1.5 py-0.5 rounded font-black">#<?php echo htmlspecialchars($_GET['id']); ?></span>. Log in with this code on the status tracker below to follow Kebele coordinator reviews.</p>
                        </div>
                    </div>
                <?php endif; ?>

                <div class="grid md:grid-cols-12 gap-8 w-full max-w-5xl">
                    <!-- Status Tracker Panel -->
                    <div class="md:col-span-4 bg-white border border-slate-200/80 rounded-3xl p-6 shadow-sm space-y-6">
                        <div class="border-b border-slate-100 pb-3">
                            <span class="text-[9.5px] uppercase font-mono tracking-wider font-bold text-slate-450">E-Status Check</span>
                            <h3 class="font-display font-extrabold text-[#ca8a04] text-md.5">Track Citizen Request</h3>
                        </div>

                        <form method="GET" class="space-y-4">
                            <input type="hidden" name="active_tab" value="services" />
                            <div class="space-y-1">
                                <label class="block text-[9.5px] font-bold text-slate-500 uppercase">Application Reference ID #</label>
                                <input type="number" required name="track_id" value="<?php echo isset($_GET['track_id']) ? htmlspecialchars($_GET['track_id']) : ''; ?>" placeholder="e.g. 105" class="w-full text-xs.5 bg-slate-50 border border-slate-205 rounded-xl px-3.5 py-2.5 focus:bg-white focus:outline-none focus:border-brand-green-700" />
                            </div>
                            <button type="submit" class="w-full bg-brand-green-700 hover:bg-brand-green-800 text-white font-bold py-2.5 px-4 text-xs.5 rounded-xl shadow-xs transition-colors cursor-pointer">
                                Audit Status
                            </button>
                        </form>

                        <!-- Tracker Results stage -->
                        <?php if ($searchedApp): ?>
                            <div class="bg-brand-green-50/40 border border-brand-green-700/10 rounded-2xl p-4.5 space-y-3.5 animate-fade-in text-xs.5">
                                <span class="block text-[9px] uppercase font-black tracking-wider text-slate-450">TICKET MATCHED REGISTER</span>
                                <div>
                                    <h4 class="font-extrabold text-slate-800"><?php echo htmlspecialchars($searchedApp['first_name'] . ' ' . $searchedApp['last_name']); ?></h4>
                                    <p class="text-[10px] text-slate-500"><?php echo htmlspecialchars($searchedApp['service_type']); ?></p>
                                </div>
                                <div class="flex items-center gap-1.5 pt-1.5 border-t border-slate-200/60">
                                    <span class="text-[10px] font-bold">Priority Status:</span>
                                    <span class="inline-block bg-[#ca8a04]/25 text-slate-800 border.5 border-[#ca8a04]/40 text-[9.5px] px-2 py-0.5 rounded-full font-black uppercase">
                                        <?php echo htmlspecialchars($searchedApp['status']); ?>
                                    </span>
                                </div>
                                
                                <?php if ($searchedApp['history_json']): ?>
                                    <div class="space-y-3.5 pt-3 border-t border-slate-200/60 font-sans text-[10.5px]">
                                        <p class="font-bold text-slate-650 uppercase text-[9px]">Worfklow History</p>
                                        <?php foreach (json_decode($searchedApp['history_json'], true) as $history): ?>
                                            <div class="pl-3 border-l-2 border-[#ca8a04]/50 relative space-y-0.5">
                                                <span class="block h-1.5 w-1.5 bg-brand-gold-500 rounded-full absolute -left-1.5 top-1"></span>
                                                <span class="block font-bold text-slate-800"><?php echo htmlspecialchars($history['status']); ?></span>
                                                <span class="block text-[8.5px] text-slate-400 font-mono"><?php echo htmlspecialchars($history['date']); ?></span>
                                                <p class="text-[9.5px] text-slate-500 leading-relaxed"><?php echo htmlspecialchars($history['comments']); ?></p>
                                            </div>
                                        <?php endforeach; ?>
                                    </div>
                                <?php endif; ?>
                            </div>
                        <?php elseif ($trackerError): ?>
                            <div class="bg-rose-50 border border-rose-150 rounded-2xl p-4 flex gap-2.5 text-xs text-rose-700 font-bold animate-fade-in">
                                <span>⚠️</span>
                                <p><?php echo htmlspecialchars($trackerError); ?></p>
                            </div>
                        <?php endif; ?>
                    </div>

                    <!-- Interactive Application Form -->
                    <div class="md:col-span-8 bg-white border border-slate-200/80 rounded-3xl p-6 sm:p-8 shadow-sm space-y-6">
                        <div class="border-b border-slate-100 pb-3">
                            <span class="text-[9.5px] uppercase font-mono tracking-wider font-bold text-slate-450">Online Submission Desk</span>
                            <h3 class="font-display font-extrabold text-[#ca8a04] text-xl">Citizen Service Application Desk</h3>
                        </div>

                        <form action="submit_application.php" method="POST" class="space-y-5">
                            <div class="grid gap-5 sm:grid-cols-2">
                                <div class="space-y-1">
                                    <label class="block text-[10px] font-bold text-slate-600 uppercase tracking-wider">Given First Name*</label>
                                    <input type="text" required name="first_name" placeholder="Ato Mohammed" class="w-full text-xs.5 bg-slate-50 border border-slate-202 rounded-xl px-3.5 py-2.5 focus:bg-white focus:outline-none focus:border-brand-green-700" />
                                </div>
                                <div class="space-y-1">
                                    <label class="block text-[10px] font-bold text-slate-600 uppercase tracking-wider">Father's Surname*</label>
                                    <input type="text" required name="last_name" placeholder="Chala" class="w-full text-xs.5 bg-slate-50 border border-slate-202 rounded-xl px-3.5 py-2.5 focus:bg-white focus:outline-none focus:border-brand-green-700" />
                                </div>
                            </div>

                            <div class="grid gap-5 sm:grid-cols-2">
                                <div class="space-y-1">
                                    <label class="block text-[10px] font-bold text-slate-600 uppercase tracking-wider">Email Communication Address*</label>
                                    <input type="email" required name="email" placeholder="mohammed@mail.com" class="w-full text-xs.5 bg-slate-50 border border-slate-202 rounded-xl px-3.5 py-2.5 focus:bg-white focus:outline-none focus:border-brand-green-700" />
                                </div>
                                <div class="space-y-1">
                                    <label class="block text-[10px] font-bold text-slate-600 uppercase tracking-wider">Active Phone Number (+251...)*</label>
                                    <input type="text" required name="phone" placeholder="+251 911 234 567" class="w-full text-xs.5 bg-slate-50 border border-slate-202 rounded-xl px-3.5 py-2.5 focus:bg-white focus:outline-none focus:border-brand-green-700" />
                                </div>
                            </div>

                            <div class="grid gap-5 sm:grid-cols-2">
                                <div class="space-y-1">
                                    <label class="block text-[10px] font-bold text-slate-600 uppercase tracking-wider">Assigned Kebele Sector*</label>
                                    <select required name="kebele" class="w-full text-xs.5 bg-slate-50 border border-slate-202 rounded-xl px-3.5 py-2.5 focus:bg-white focus:outline-none focus:border-brand-green-700">
                                        <option value="Kebele 01">Kebele 01 (Central Administration)</option>
                                        <option value="Kebele 02">Kebele 02 (Trade Hub)</option>
                                        <option value="Kebele 03">Kebele 03 (Agaro High Exit)</option>
                                        <option value="Kebele 04">Kebele 04 (Agricultural Border)</option>
                                        <option value="Kebele 05">Kebele 05 (Woreda West)</option>
                                        <option value="Kebele 06">Kebele 06 (Woreda East)</option>
                                        <option value="Kebele 07">Kebele 07</option>
                                        <option value="Kebele 08">Kebele 08</option>
                                        <option value="Kebele 09">Kebele 09</option>
                                    </select>
                                </div>
                                <div class="space-y-1">
                                    <label class="block text-[10px] font-bold text-slate-600 uppercase tracking-wider">Citizen Service Request Desk*</label>
                                    <select required name="service_type" class="w-full text-xs.5 bg-slate-50 border border-slate-202 rounded-xl px-3.5 py-2.5 focus:bg-white focus:outline-none focus:border-brand-green-700">
                                        <option value="Business Registration Trade License">Business Trade & Agricultural Cooperative License</option>
                                        <option value="New Building Permit ID Approval">New Building Permit & Civil Construction Approval</option>
                                        <option value="Kebele Resident Residency Card Certificate">Resident ID Certificate Card Registration</option>
                                        <option value="Sanitation Utility & Water Main tap In">Water Main Plumbing Tap-In Permit</option>
                                    </select>
                                </div>
                            </div>

                            <div class="space-y-1">
                                <label class="block text-[10px] font-bold text-slate-600 uppercase tracking-wider">Explain Application details & contextual arguments*</label>
                                <textarea required name="details" rows="5" placeholder="Explain details of your construction plans or trade license requirements..." class="w-full text-xs.5 bg-slate-50 border border-slate-202 rounded-xl px-3.5 py-2.5 focus:bg-white focus:outline-none focus:border-brand-green-700"></textarea>
                            </div>

                            <div class="pt-2 flex justify-end">
                                <button type="submit" class="bg-brand-green-700 hover:bg-brand-green-800 text-white font-bold py-3.5 px-6.5 text-xs.5 rounded-xl shadow transition-all cursor-pointer">
                                    Register Secure Application File
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </section>
        <?php endif; ?>


        <!-- TAB 3: PUBLIC NEWS BULLETIN GRID -->
        <?php if ($activeTab === 'news'): ?>
            <section id="view-news" class="space-y-8 animate-fade-in flex flex-col items-center">
                <div class="w-full max-w-5xl space-y-6">
                    <div class="flex justify-between items-center border-b border-slate-150 pb-3">
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
                                        <img src="<?php echo htmlspecialchars($img_encoded); ?>" alt="Press" class="h-full w-full object-cover" />
                                        <span class="absolute top-4 left-4 bg-slate-900/90 text-brand-gold-500 font-mono tracking-wider uppercase text-[8.5px] font-bold px-2.5 py-1 rounded-md">
                                            <?php echo htmlspecialchars($article['category']); ?>
                                        </span>
                                    </div>
                                    <div class="px-6 space-y-2">
                                        <span class="text-[9.5px] font-semibold font-mono text-slate-450"><?php echo htmlspecialchars($article['date']); ?></span>
                                        <h4 class="font-display font-extrabold text-[#ca8a04] text-md.5 leading-snug">
                                            <?php echo htmlspecialchars($article['title_' . $currentLang] ?: $article['title_en']); ?>
                                        </h4>
                                        <p class="text-xs text-slate-500 leading-relaxed">
                                            <?php echo htmlspecialchars($article['excerpt_' . $currentLang] ?: $article['excerpt_en']); ?>
                                        </p>
                                    </div>
                                </div>
                                <div class="px-6 py-5 border-t border-slate-100/60 mt-4 bg-slate-50/50 flex justify-end">
                                    <button onclick="alert('<?php echo addslashes($article['content_' . $currentLang] ?: $article['content_en']); ?>')" class="inline-flex items-center gap-1.5 text-xs font-bold text-brand-green-700 hover:underline cursor-pointer">
                                        Read full release ↗
                                    </button>
                                </div>
                            </article>
                        <?php endforeach; ?>
                    </div>
                </div>
            </section>
        <?php endif; ?>


        <!-- TAB 4: DEPARTMENTS & LEADERSHIP DIRECTORY -->
        <?php if ($activeTab === 'departments'): ?>
            <section id="view-departments" class="space-y-12 animate-fade-in flex flex-col items-center">
                
                <!-- Mayor's Strategic Desk -->
                <div class="w-full max-w-5xl bg-white border border-slate-205 rounded-3xl overflow-hidden shadow-sm grid md:grid-cols-12">
                    <div class="md:col-span-4 bg-slate-50/70 border-r border-slate-150 p-8 flex flex-col items-center justify-center text-center space-y-4">
                        <div class="h-32 w-32 rounded-full overflow-hidden border-[3px] border-brand-gold-500 shadow-md">
                            <img src="<?php echo htmlspecialchars($mayor['image']); ?>" alt="Mayor" class="h-full w-full object-cover object-top" />
                        </div>
                        <div>
                            <span class="text-[9.5px] uppercase font-black text-slate-400 tracking-wider">
                                <?php echo htmlspecialchars($mayor['role_' . $currentLang] ?: $mayor['role_en']); ?>
                            </span>
                            <h3 class="font-display font-extrabold text-[#ca8a04] text-lg.5 mt-0.5"><?php echo htmlspecialchars($mayor['name']); ?></h3>
                            <p class="text-xs text-brand-green-750 font-bold font-mono"><?php echo htmlspecialchars($mayor['email']); ?></p>
                        </div>
                        <div class="pt-4 border-t border-slate-200/80 w-full text-[10.5px] text-slate-500 font-mono space-y-1 select-none">
                            <p>📍 Admin Block, 1st Floor</p>
                            <p>⏱️ Term: <?php echo htmlspecialchars($mayor['term_' . $currentLang] ?: $mayor['term_en']); ?></p>
                        </div>
                    </div>

                    <div class="md:col-span-8 p-8 space-y-6">
                        <div>
                            <span class="text-[10px] font-bold text-brand-green-700 uppercase tracking-widest pl-1 font-mono">
                                <?php echo htmlspecialchars($mayor['desk_' . $currentLang] ?: $mayor['desk_en']); ?>
                            </span>
                            <h4 class="font-display font-black text-slate-800 text-xl tracking-tight mt-1">Special Executive Directive Program</h4>
                        </div>
                        
                        <p class="text-xs text-slate-500 leading-relaxed">
                            Under the central direction of Mayor Jemal Abasimel, the municipal executive focuses resources on the following strategic priorities:
                        </p>

                        <div class="grid gap-4 sm:grid-cols-3">
                            <div class="border border-slate-150 rounded-2xl p-4 bg-slate-50/40 select-none">
                                <span class="text-brand-green-700 font-black text-lg">01</span>
                                <h5 class="text-xs font-bold text-slate-800 mt-1">Export Value Chains</h5>
                                <p class="text-[10px] text-slate-450 mt-1"><?php echo htmlspecialchars($mayor['priority1_' . $currentLang] ?: $mayor['priority1_en']); ?></p>
                            </div>
                            <div class="border border-slate-150 rounded-2xl p-4 bg-slate-50/40 select-none">
                                <span class="text-brand-green-700 font-black text-lg">02</span>
                                <h5 class="text-xs font-bold text-slate-800 mt-1">Kebele Devolution</h5>
                                <p class="text-[10px] text-slate-450 mt-1"><?php echo htmlspecialchars($mayor['priority2_' . $currentLang] ?: $mayor['priority2_en']); ?></p>
                            </div>
                            <div class="border border-slate-150 rounded-2xl p-4 bg-slate-50/40 select-none">
                                <span class="text-brand-green-700 font-black text-lg">03</span>
                                <h5 class="text-xs font-bold text-slate-800 mt-1">Electronic Billing</h5>
                                <p class="text-[10px] text-slate-450 mt-1"><?php echo htmlspecialchars($mayor['priority3_' . $currentLang] ?: $mayor['priority3_en']); ?></p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Cabinet Portfolios Grid -->
                <div class="w-full max-w-5xl space-y-6">
                    <div class="border-b border-slate-150 pb-3">
                        <h3 class="font-display font-extrabold text-[#ca8a04] text-lg tracking-tight">Active Cabinet Portfolios & Strategy board</h3>
                        <p class="text-xs text-slate-400 mt-0.5">The central advisory cabinet coordinating trade, land planning, health, and municipal revenues.</p>
                    </div>

                    <div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
                        <?php foreach ($cabinet as $member): ?>
                            <div class="bg-white border border-slate-200/80 rounded-3xl p-5 shadow-subtle flex gap-4 items-start hover:shadow-md transition-shadow">
                                <div class="h-16 w-16 rounded-2xl overflow-hidden shadow-xs shrink-0 bg-slate-100 border border-slate-150">
                                    <img src="<?php echo htmlspecialchars($member['image']); ?>" alt="Cabinet" class="h-full w-full object-cover object-top" />
                                </div>
                                <div class="space-y-1 min-w-0">
                                    <h4 class="font-display font-bold text-slate-800 text-sm truncate"><?php echo htmlspecialchars($member['name']); ?></h4>
                                    <span class="block text-[9.5px] font-mono font-bold text-brand-green-700 uppercase truncate">
                                        <?php echo htmlspecialchars($member['role_' . $currentLang] ?: $member['role_en']); ?>
                                    </span>
                                    <p class="text-[10px] text-slate-450 leading-snug">
                                        Desk: <span class="text-slate-600 font-semibold"><?php echo htmlspecialchars($member['desk_' . $currentLang] ?: $member['desk_en']); ?></span>
                                    </p>
                                    <span class="block text-[10px] text-slate-400 mt-1 font-mono truncate"><?php echo htmlspecialchars($member['email']); ?></span>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </section>
        <?php endif; ?>


        <!-- TAB 5: CONTACT & PUBLIC UTILITY TICKETING -->
        <?php if ($activeTab === 'contact'): ?>
            <section id="view-contact" class="space-y-8 animate-fade-in flex flex-col items-center">
                
                <!-- Feedback success notice -->
                <?php if (isset($_GET['complaint_success'])): ?>
                    <div class="w-full max-w-4xl bg-[#fdfdf6] border border-[#f5efc8] text-brand-gold-750 p-6 rounded-2xl flex gap-4 items-start shadow-xs mb-2 select-none animate-fade-in">
                        <span class="text-xl">📢</span>
                        <div class="space-y-1">
                            <h4 class="text-xs font-semibold text-brand-gold-750 uppercase">Public Complaint Ticket Issued</h4>
                            <p class="text-[11px] text-slate-650 leading-relaxed">Your report was filed. Tracking Reference: <span class="font-mono bg-white border border-brand-gold-150 text-brand-gold-700 px-1.5 py-0.5 rounded font-bold">#<?php echo htmlspecialchars($_GET['ticket']); ?></span>. Local Kebele engineers will inspect the site coordinates within 24 hours.</p>
                        </div>
                    </div>
                <?php endif; ?>

                <div class="grid md:grid-cols-12 gap-8 w-full max-w-5xl">
                    <!-- Location Support details -->
                    <div class="md:col-span-4 bg-white border border-slate-205 rounded-3xl p-6.5 shadow-sm space-y-6">
                        <div class="border-b border-slate-100 pb-3">
                            <h3 class="font-display font-extrabold text-[#ca8a04] text-md.5">Municipal Office Desk</h3>
                            <span class="text-[9px] uppercase font-mono text-slate-400 font-bold">Direct Channels</span>
                        </div>

                        <div class="space-y-4 text-xs">
                            <div class="flex items-start gap-3">
                                <span class="p-1 bg-slate-50 border border-slate-150 rounded-lg">📍</span>
                                <div>
                                    <h4 class="font-bold text-slate-800">Agaro City Hall</h4>
                                    <p class="text-[10px] text-slate-450 mt-0.5">District Executive Avenue, Agaro Jimma Main Highway exit, Oromia Region</p>
                                </div>
                            </div>
                            <div class="flex items-start gap-3">
                                <span class="p-1 bg-slate-50 border border-slate-150 rounded-lg">📞</span>
                                <div>
                                    <h4 class="font-bold text-slate-800">Public Desk Hot-lines</h4>
                                    <p class="text-[10.5px] text-brand-green-750 font-mono mt-0.5">+251 47 111 2049 / 2050</p>
                                </div>
                            </div>
                            <div class="flex items-start gap-3">
                                <span class="p-1 bg-slate-50 border border-slate-150 rounded-lg">🕙</span>
                                <div>
                                    <h4 class="font-bold text-slate-800">Operational Hours</h4>
                                    <p class="text-[10px] text-slate-450 mt-0.5">Monday to Friday (8:30 AM - 5:30 PM)</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Complaint Filing desk -->
                    <div class="md:col-span-8 bg-white border border-slate-205 rounded-3xl p-6 sm:p-8 shadow-sm space-y-6">
                        <div class="border-b border-slate-100 pb-3">
                            <h3 class="font-display font-extrabold text-[#ca8a04] text-xl">Civic Incident & Utility Ticketing</h3>
                            <p class="text-xs text-slate-400 mt-0.5">Report utilities damage, water mains leakage, road potholes, or public waste issues safely.</p>
                        </div>

                        <form action="submit_complaint.php" method="POST" class="space-y-4">
                            <div class="grid gap-4 sm:grid-cols-2">
                                <div class="space-y-1">
                                    <label class="block text-[9.5px] font-bold text-slate-500 uppercase">Complaint Category*</label>
                                    <select required name="category" class="w-full text-xs.5 bg-slate-50 border border-slate-202 rounded-xl px-3.5 py-2.5 focus:bg-white focus:outline-none focus:border-brand-green-700">
                                        <option value="Water & Utilities">Water, Plumbing, & Utility Main burst</option>
                                        <option value="Road Damage & Potholes">Road Damage, Potholes & Gravel Maintenance</option>
                                        <option value="Waste & Sanitation">Public Sanitation & Open Dumping waste</option>
                                        <option value="Electricity Main outages">Streetlight System & Grid Power faults</option>
                                    </select>
                                </div>
                                <div class="space-y-1">
                                    <label class="block text-[9.5px] font-bold text-slate-500 uppercase">Short Incident Title*</label>
                                    <input type="text" required name="title" placeholder="Kebele 03 Water leakage exit" class="w-full text-xs.5 bg-slate-50 border border-slate-202 rounded-xl px-3.5 py-2.5 focus:bg-white focus:outline-none focus:border-brand-green-700" />
                                </div>
                            </div>

                            <div class="grid gap-4 sm:grid-cols-2">
                                <div class="space-y-1">
                                    <label class="block text-[9.5px] font-bold text-slate-500 uppercase">Exact Site Location Description*</label>
                                    <input type="text" required name="location" placeholder="Near Agaro High School Exit lane" class="w-full text-xs.5 bg-slate-50 border border-slate-202 rounded-xl px-3.5 py-2.5 focus:bg-white focus:outline-none focus:border-brand-green-700" />
                                </div>
                                <div class="space-y-1">
                                    <label class="block text-[9.5px] font-bold text-slate-500 uppercase">Kebele Sector*</label>
                                    <select required name="kebele" class="w-full text-xs.5 bg-slate-50 border border-slate-202 rounded-xl px-3.5 py-2.5 focus:bg-white focus:outline-none focus:border-brand-green-700">
                                        <option value="Kebele 01">Kebele 01</option>
                                        <option value="Kebele 02">Kebele 02</option>
                                        <option value="Kebele 03">Kebele 03</option>
                                        <option value="Kebele 04">Kebele 04</option>
                                        <option value="Kebele 05">Kebele 05</option>
                                    </select>
                                </div>
                            </div>

                            <div class="space-y-1">
                                <label class="block text-[9.5px] font-bold text-slate-500 uppercase">Detailed Description of Incident*</label>
                                <textarea required name="description" rows="4" placeholder="Give full explanation of leakages, damage signs, or duration..." class="w-full text-xs.5 bg-slate-50 border border-slate-202 rounded-xl px-3.5 py-2.5 focus:bg-white focus:outline-none focus:border-brand-green-700"></textarea>
                            </div>

                            <div class="grid gap-4 sm:grid-cols-2">
                                <div class="space-y-1">
                                    <label class="block text-[9.5px] font-bold text-slate-500 uppercase">Your Name (Ignored if Anonymous)</label>
                                    <input type="text" name="reporter_name" placeholder="Ato Chala Girma" class="w-full text-xs.5 bg-slate-50 border border-slate-202 rounded-xl px-3.5 py-2.5 focus:bg-white focus:outline-none focus:border-brand-green-700" />
                                </div>
                                <div class="space-y-1">
                                    <label class="block text-[9.5px] font-bold text-slate-500 uppercase">Contact Phone (Ignored if Anonymous)</label>
                                    <input type="text" name="reporter_phone" placeholder="+251 911 ..." class="w-full text-xs.5 bg-slate-50 border border-slate-202 rounded-xl px-3.5 py-2.5 focus:bg-white focus:outline-none focus:border-brand-green-700" />
                                </div>
                            </div>

                            <div class="flex items-center gap-2 select-none py-1">
                                <input type="checkbox" id="anon-box" name="is_anonymous" class="rounded h-4 w-4 bg-slate-100 border-slate-200 text-brand-green-700 focus:ring-brand-green-600" />
                                <label for="anon-box" class="text-[11px] font-semibold text-slate-600 cursor-pointer">Submit anonymously (hide name and contact parameters from system boards)</label>
                            </div>

                            <div class="flex justify-end pt-2">
                                <button type="submit" class="bg-brand-green-700 hover:bg-brand-green-800 text-white font-bold py-3 px-5 text-xs.5 rounded-xl shadow cursor-pointer">
                                    Deploy Incident Ticket
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </section>
        <?php endif; ?>

    </main>

    <!-- FLOATING INTERACTIVE CHATBOT SIMULATOR -->
    <div id="floating-chatbot-block" class="fixed bottom-6 right-6 z-50 font-sans text-xs flex flex-col items-end">
        <button id="chatbot-toggle-btn" onclick="document.getElementById('chatbot-window').classList.toggle('hidden')" class="h-12 w-12 rounded-full bg-slate-900 border.5 border-slate-800 text-brand-gold-500 hover:bg-slate-805 flex items-center justify-center shadow-xl text-lg animate-pulse select-none cursor-pointer">
            💬
        </button>
        <div id="chatbot-window" class="hidden w-[310px] bg-white border border-slate-200 shadow-2xl rounded-2xl flex flex-col overflow-hidden max-h-[380px] mt-3 animate-fade-in text-slate-800">
            <div class="bg-slate-900 text-white p-3.5 flex items-center gap-2 border-b border-slate-805 select-none">
                <span class="text-md">☕</span>
                <div>
                    <h5 class="font-display font-bold text-xs.5 leading-none text-brand-gold-500">Agaro Virtual Copilot</h5>
                    <span class="text-[8.5px] text-slate-400">Kebele Support Virtual Officer</span>
                </div>
            </div>
            
            <div id="chatbot-messages-stage" class="p-3.5 space-y-3 overflow-y-auto max-h-[220px] custom-scrollbar bg-slate-50/50 text-[11px]">
                <div class="bg-slate-100 border border-slate-200 rounded-xl p-2.5 max-w-[85%] text-slate-700">
                    Akkam! Welcome to the Agaro municipal chatbot. How can I help you navigate town statistics, coffee cooperative licenses, or resident certifications?
                </div>
            </div>

            <!-- Predefined help inputs -->
            <div class="p-2 border-t border-slate-100 bg-white grid grid-cols-2 gap-1.5 text-[10px] font-bold select-none shrink-0 text-slate-650">
                <button onclick="sendMockBot('Show me Agaro elevation statistics...')" class="p-1.5 border border-slate-150 rounded text-center hover:bg-slate-50 cursor-pointer">⛰️ Elevation Stats</button>
                <button onclick="sendMockBot('How do I submit cooperative license application?')" class="p-1.5 border border-slate-150 rounded text-center hover:bg-slate-50 cursor-pointer">☕ Coffee License</button>
            </div>
        </div>
    </div>

    <script>
        function sendMockBot(text) {
            const stage = document.getElementById('chatbot-messages-stage');
            
            // Citizen Bubble
            const cBubble = document.createElement('div');
            cBubble.className = "bg-brand-green-700 text-white p-2.5 rounded-xl ml-auto max-w-[85%] font-semibold";
            cBubble.innerText = text;
            stage.appendChild(cBubble);
            
            stage.scrollTop = stage.scrollHeight;
            
            // Bot Response delay
            setTimeout(() => {
                let response = "Of course! Let me support your query. We coordinate 9 local Kebeles, specialty forest coffee dry washing processing licenses, and online building permit registrations. Please explore the 'Services' tab to apply online, or 'Contact' to file ticketing logs.";
                if (text.includes('elevation')) {
                    response = "Agaro stands proud at 1,820 meters above mean sea level in Western Jimma Zone, Oromia. We export coffee to global hubs.";
                } else if (text.includes('cooperative')) {
                    response = "Agricultural cooperative registrations are reviewed under our 'Services' portal. Fill out the application form pointing to the Industry promotion desk, and our Kebele coordinator panel will register your wet/dry mills.";
                }
                
                const bBubble = document.createElement('div');
                bBubble.className = "bg-slate-100 border border-slate-200 rounded-xl p-2.5 max-w-[85%] text-slate-700";
                bBubble.innerText = response;
                stage.appendChild(bBubble);
                stage.scrollTop = stage.scrollHeight;
            }, 750);
        }
    </script>

</body>
</html>
