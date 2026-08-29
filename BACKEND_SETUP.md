# Agaro News & Events Backend System

## Overview

This backend system enables dynamic management of news articles and events for the Agaro Municipal website. The system provides REST APIs and an admin panel for easy content management.

## Setup Instructions

### 1. Database Setup

Run the SQL commands to create the required tables:

```bash
# In phpMyAdmin or MySQL command line:
1. Open `php_export/database.sql` (already exists)
2. Open `php_export/events_table.sql` and run it to create the events table
```

Or connect via terminal:
```bash
mysql -u root -p agaro_municipal_db < php_export/events_table.sql
```

### 2. File Structure

```
php_export/
├── config.php              # Database configuration
├── database.sql            # News & Cabinet tables
├── events_table.sql        # Events table (NEW)
├── api_news.php            # News REST API (NEW)
├── api_events.php          # Events REST API (NEW)
├── admin_manage.php        # Admin panel (NEW)
├── index.php               # Main export
└── ... other files

src/services/
└── newsEventsService.ts    # React service to call APIs (NEW)
```

### 3. Database Tables

#### News Table
```sql
- id: varchar(64) PRIMARY KEY
- category: varchar(64)
- date: date
- image: varchar(255) [optional]
- title_en, title_om, title_am: varchar(255)
- excerpt_en, excerpt_om, excerpt_am: text
- content_en, content_om, content_am: text
```

#### Events Table
```sql
- id: varchar(64) PRIMARY KEY
- category: varchar(100)
- event_date: date
- event_time: time
- image: varchar(255) [optional]
- title_en, title_om, title_am: varchar(255)
- desc_en, desc_om, desc_am: text
- loc_en, loc_om, loc_am: varchar(255)
- created_at: timestamp
- updated_at: timestamp
```

## API Endpoints

### News API (`api_news.php`)

#### Get All News
```
GET /api_news.php?action=all
Returns: { success: true, data: [articles...] }
```

#### Get Latest News (with limit)
```
GET /api_news.php?action=latest&limit=6
Returns: { success: true, data: [articles...] }
```

#### Get News by Category
```
GET /api_news.php?action=category&category=Infrastructure&limit=10
Returns: { success: true, data: [articles...] }
```

#### Get Single Article
```
GET /api_news.php?id=news-123456789
Returns: { success: true, data: {article} }
```

#### Create News Article
```
POST /api_news.php?action=create
Body: {
  "category": "Infrastructure",
  "date": "2026-06-08",
  "image": "https://...",
  "title_en": "Article Title",
  "title_om": "Mata jira",
  "title_am": "ዐረፍተ ነገር",
  "excerpt_en": "Summary...",
  "excerpt_om": "...",
  "excerpt_am": "...",
  "content_en": "Full content...",
  "content_om": "...",
  "content_am": "..."
}
```

#### Update Article
```
PUT /api_news.php?action=update&id=news-123456789
Body: { fields to update... }
```

#### Delete Article
```
DELETE /api_news.php?action=delete&id=news-123456789
```

### Events API (`api_events.php`)

#### Get All Events
```
GET /api_events.php?action=all
```

#### Get Upcoming Events
```
GET /api_events.php?action=upcoming&limit=6
```

#### Get Past Events
```
GET /api_events.php?action=past&limit=10
```

#### Get Single Event
```
GET /api_events.php?id=event-123456789
```

#### Create Event
```
POST /api_events.php?action=create
Body: {
  "category": "Community",
  "event_date": "2026-06-25",
  "event_time": "09:00:00",
  "image": "https://...",
  "title_en": "Event Name",
  "title_om": "...",
  "title_am": "...",
  "desc_en": "Description...",
  "desc_om": "...",
  "desc_am": "...",
  "loc_en": "Location",
  "loc_om": "...",
  "loc_am": "..."
}
```

#### Update Event
```
PUT /api_events.php?action=update&id=event-123456789
Body: { fields to update... }
```

#### Delete Event
```
DELETE /api_events.php?action=delete&id=event-123456789
```

## Admin Panel

### Access
```
http://localhost/agaro/php_export/admin_manage.php
```

### Default Password
```
agaro2026admin
```

⚠️ **CHANGE THIS IN PRODUCTION!** Edit `admin_manage.php` line 22:
```php
if ($password === 'agaro2026admin') {  // Change this!
```

### Features
- 📝 Create, view, and delete news articles
- 🎉 Create, view, and delete events
- 📊 Dashboard with recent items
- 🌐 Full multilingual support (English, Afan Oromo, Amharic)
- 🖼️ Image URL support for articles and events

## React Integration

### Using the Service

```typescript
import { newsService, eventsService } from '@/services/newsEventsService';

// Get latest news
const news = await newsService.getLatest(6);

// Get upcoming events
const events = await eventsService.getUpcoming(3);

// Create new article
await newsService.create({
  category: 'Infrastructure',
  date: '2026-06-15',
  title_en: 'New Road Project',
  // ... other fields
});
```

### Update HomeView.tsx (Example)

```typescript
import { newsService, eventsService } from '@/services/newsEventsService';
import { useEffect, useState } from 'react';

export default function HomeView({ currentLang, onNavigateToTab }) {
  const [newsData, setNewsData] = useState([]);
  const [eventsData, setEventsData] = useState([]);

  useEffect(() => {
    // Fetch latest news
    newsService.getLatest(2).then(setNewsData);
    
    // Fetch upcoming events
    eventsService.getUpcoming(3).then(setEventsData);
  }, []);

  // Use newsData and eventsData in render...
}
```

## Best Practices

1. **Image URLs**: Use absolute URLs (https://...) or host images in `/assets/images/`
2. **Dates**: Use YYYY-MM-DD format
3. **Times**: Use HH:MM:SS format (24-hour)
4. **Translations**: Always provide all three language versions
5. **Categories**: Use consistent category names across articles/events
6. **Password**: Change the default admin password immediately

## Security Notes

- All inputs are sanitized via prepared statements
- JSON responses prevent XSS
- Implement authentication before production deployment
- Consider adding role-based access control (admin, editor, viewer)
- Add password hashing for production

## Troubleshooting

### Database Connection Error
- Verify MySQL is running
- Check `config.php` database credentials
- Ensure `agaro_municipal_db` database exists

### API Returns Error
- Check browser console for CORS issues
- Verify file permissions on PHP files
- Check MySQL error logs

### Images Not Loading
- Verify image URLs are correct
- Check if images are accessible publicly
- Use placeholder images if needed

## Future Enhancements

- [ ] User authentication system
- [ ] Image upload to server instead of URL
- [ ] Draft/Published status for articles
- [ ] Event RSVP system
- [ ] Comments/reactions on articles
- [ ] Admin user management
- [ ] Scheduled publishing
- [ ] Search functionality
- [ ] API pagination
