-- events_table.sql
-- Create the events table for Agaro Municipal Events Management

CREATE TABLE IF NOT EXISTS `events` (
  `id` varchar(64) NOT NULL,
  `category` varchar(100) NOT NULL DEFAULT 'General',
  `event_date` date NOT NULL,
  `event_time` time NOT NULL,
  `image` varchar(255) DEFAULT NULL,
  `title_en` varchar(255) NOT NULL,
  `title_om` varchar(255) NOT NULL,
  `title_am` varchar(255) NOT NULL,
  `desc_en` text NOT NULL,
  `desc_om` text NOT NULL,
  `desc_am` text NOT NULL,
  `loc_en` varchar(255) NOT NULL,
  `loc_om` varchar(255) NOT NULL,
  `loc_am` varchar(255) NOT NULL,
  `created_at` timestamp DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  INDEX `event_date_idx` (`event_date`),
  INDEX `category_idx` (`category`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Seed initial events data
INSERT INTO `events` (`id`, `category`, `event_date`, `event_time`, `image`, `title_en`, `title_om`, `title_am`, `desc_en`, `desc_om`, `desc_am`, `loc_en`, `loc_om`, `loc_am`, `created_at`) VALUES

('event-1', 'Community', '2026-06-25', '09:00:00', 'https://images.unsplash.com/photo-1552664730-d307ca884978?auto=format&fit=crop&w=800&q=80',
'Community Town Hall Meeting',
'Soba Bulchiinsaa Uummataa',
'የከተማው ህዝባዊ ውይይት መድረክ',
'Discussion of current fiscal capital budgets and Kebele 03 road progress with the Mayor. An open forum for citizens to voice concerns and ask questions.',
'Kantiibaa waliin waa\'ee bajata waggaafi daandii aspaaltii Kebele 03 irratti mari\'achuu. Bakka namoonni waa gaafatuu fi geeddaruu danda\'an.',
'ስለ ዓመታዊ በጀት ዝግጅት እና ስለቀበሌ 03 አስፋልት መንገድ ግንባታ ከከንቲባው ጋር የሚደረግ ውይይት። ህዝብ ጥያቄ መጠየቅ 및ያለ መልስ ማግኘት ይችላል።',
'City Hall Auditorium',
'Galma Kellaa Magaalaa',
'በከተማው አስተዳደር አዳራሽ',
NOW()),

('event-2', 'Festival', '2026-10-14', '08:30:00', 'https://images.unsplash.com/photo-1511379938547-c1f69b13d835?auto=format&fit=crop&w=800&q=80',
'Specialty Arabica Coffee Festival 2026',
'Festival Buna Addunyaa Aggaaroo',
'የአጋሮ ልዩ የአረቢካ ቡና ፌስቲቫል',
'Celebrating our organic washing stations with global buyers, jasmine cupping, and local dances. Three days of premium coffee tasting, cultural performances, and networking opportunities.',
'Oomisha buna keenya dhandhamufi qulqullina bunaa agarsiisuuf daldaltoonni addunyaa ni argamu. Guyyoota sadii kubbaa buna gaarii qooti, seexameewwan toluu fi haalaala jechuu.',
'የአጋሮን ልዩ የመታጠቢያ ጣቢያ ቡና ውህደቶችን እውቅና ለመስጠት ከዓለም ገዢዎች ጋር የሚደረግ ዝግጅት። ሦስት ቀናት ልዩ የቡና ቅመሚት፣ የባህል አሠሪ እና ጥምረት።',
'Central Municipal Square',
'Iddoo Waltajjii Guddaa',
'በማዕከላዊ የከተማው አደባባይ',
NOW()),

('event-3', 'Sports', '2026-06-30', '14:00:00', 'https://images.unsplash.com/photo-1518611505868-48a1d2bae759?auto=format&fit=crop&w=800&q=80',
'Agaro Municipal Youth Sports Championship',
'Dorgommii Ispoortii Dargaggootaa',
'የአጋሮ ወጣቶች ስፖርት ሻምፒዮና',
'Annual athletics event and regional football final matching Kebele 01 vs Kebele 04. Expect fast-paced action and team spirit from our young athletes.',
'Dorgommii kubbaa miilaa tapha dhumaa gidduu Kebele 01 fi Kebele 04 taasifamuu. Ispoortaawwan ol\'aadhaa fi koreera gidduu armaan gadii ni mul\'atu.',
'ዓመታዊ የአትሌቲክስ ውድድር እና የቀበሌ 01 ከቀበሌ 04 ጋር የሚያደርጉት የእግር ኳስ የፍጻሜ ጨዋታ። ወጣቶች ጥናታቸውን ይገልጻሉ።',
'Agaro Regional Field Stadium',
'Istaadiyeemii Magaalaa Aggaaroo',
'በአጋሮ ሜዳ ስታዲየም',
NOW());
