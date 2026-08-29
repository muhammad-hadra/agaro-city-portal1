// src/services/newsEventsService.ts
// Service to handle API calls for News and Events management

const API_BASE = 'http://localhost/agaro/php_export';
const SITE_BASE = 'http://localhost/agaro';

const getImageUrl = (imagePath: string | null): string | null => {
  if (!imagePath) return null;
  if (imagePath.startsWith('http')) return imagePath; // Already a full URL
  if (imagePath.startsWith('uploads/')) return `${API_BASE}/${imagePath}`; // Specific for PHP backend uploads
  if (imagePath.startsWith('/')) return SITE_BASE + imagePath; // Relative path
  return imagePath;
};

interface NewsArticle {
  id: string;
  category: string;
  date: string;
  image?: string;
  title_en: string;
  title_om: string;
  title_am: string;
  excerpt_en: string;
  excerpt_om: string;
  excerpt_am: string;
  content_en: string;
  content_om: string;
  content_am: string;
}

interface Event {
  id: string;
  category: string;
  event_date: string;
  event_time: string;
  image?: string;
  title_en: string;
  title_om: string;
  title_am: string;
  desc_en: string;
  desc_om: string;
  desc_am: string;
  loc_en: string;
  loc_om: string;
  loc_am: string;
  created_at?: string;
}

// NEWS API CALLS
export const newsService = {
  // Get all news articles
  getAll: async (): Promise<NewsArticle[]> => {
    try {
      const response = await fetch(`${API_BASE}/api_news.php?action=all`);
      const data = await response.json();
      if (data.success && data.data) {
        return data.data.map((article: any) => ({
          ...article,
          image: getImageUrl(article.image)
        }));
      }
      return [];
    } catch (error) {
      console.error('Error fetching news:', error);
      return [];
    }
  },

  // Get latest news articles
  getLatest: async (limit = 6): Promise<NewsArticle[]> => {
    try {
      const response = await fetch(`${API_BASE}/api_news.php?action=latest&limit=${limit}`);
      const data = await response.json();
      if (data.success && data.data) {
        return data.data.map((article: any) => ({
          ...article,
          image: getImageUrl(article.image)
        }));
      }
      return [];
    } catch (error) {
      console.error('Error fetching latest news:', error);
      return [];
    }
  },

  // Get news by category
  getByCategory: async (category: string, limit = 10): Promise<NewsArticle[]> => {
    try {
      const response = await fetch(
        `${API_BASE}/api_news.php?action=category&category=${encodeURIComponent(category)}&limit=${limit}`
      );
      const data = await response.json();
      if (data.success && data.data) {
        return data.data.map((article: any) => ({
          ...article,
          image: getImageUrl(article.image)
        }));
      }
      return [];
    } catch (error) {
      console.error('Error fetching news by category:', error);
      return [];
    }
  },

  // Get single article by ID
  getById: async (id: string): Promise<NewsArticle | null> => {
    try {
      const response = await fetch(`${API_BASE}/api_news.php?id=${encodeURIComponent(id)}`);
      const data = await response.json();
      if (data.success && data.data) {
        return {
          ...data.data,
          image: getImageUrl(data.data.image)
        };
      }
      return null;
    } catch (error) {
      console.error('Error fetching article:', error);
      return null;
    }
  },

  // Create new article
  create: async (article: Omit<NewsArticle, 'id'>): Promise<{ success: boolean; id?: string; error?: string }> => {
    try {
      const response = await fetch(`${API_BASE}/api_news.php?action=create`, {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify(article)
      });
      return await response.json();
    } catch (error) {
      console.error('Error creating article:', error);
      return { success: false, error: String(error) };
    }
  },

  // Update article
  update: async (id: string, updates: Partial<NewsArticle>): Promise<{ success: boolean; error?: string }> => {
    try {
      const response = await fetch(`${API_BASE}/api_news.php?action=update&id=${encodeURIComponent(id)}`, {
        method: 'PUT',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify(updates)
      });
      return await response.json();
    } catch (error) {
      console.error('Error updating article:', error);
      return { success: false, error: String(error) };
    }
  },

  // Delete article
  delete: async (id: string): Promise<{ success: boolean; error?: string }> => {
    try {
      const response = await fetch(`${API_BASE}/api_news.php?action=delete&id=${encodeURIComponent(id)}`, {
        method: 'DELETE'
      });
      return await response.json();
    } catch (error) {
      console.error('Error deleting article:', error);
      return { success: false, error: String(error) };
    }
  }
};

// EVENTS API CALLS
export const eventsService = {
  // Get all events
  getAll: async (): Promise<Event[]> => {
    try {
      const response = await fetch(`${API_BASE}/api_events.php?action=all`);
      const data = await response.json();
      if (data.success && data.data) {
        return data.data.map((event: any) => ({
          ...event,
          image: getImageUrl(event.image)
        }));
      }
      return [];
    } catch (error) {
      console.error('Error fetching events:', error);
      return [];
    }
  },

  // Get upcoming events
  getUpcoming: async (limit = 6): Promise<Event[]> => {
    try {
      const response = await fetch(`${API_BASE}/api_events.php?action=upcoming&limit=${limit}`);
      const data = await response.json();
      if (data.success && data.data) {
        return data.data.map((event: any) => ({
          ...event,
          image: getImageUrl(event.image)
        }));
      }
      return [];
    } catch (error) {
      console.error('Error fetching upcoming events:', error);
      return [];
    }
  },

  // Get past events
  getPast: async (limit = 10): Promise<Event[]> => {
    try {
      const response = await fetch(`${API_BASE}/api_events.php?action=past&limit=${limit}`);
      const data = await response.json();
      if (data.success && data.data) {
        return data.data.map((event: any) => ({
          ...event,
          image: getImageUrl(event.image)
        }));
      }
      return [];
    } catch (error) {
      console.error('Error fetching past events:', error);
      return [];
    }
  },

  // Get single event by ID
  getById: async (id: string): Promise<Event | null> => {
    try {
      const response = await fetch(`${API_BASE}/api_events.php?id=${encodeURIComponent(id)}`);
      const data = await response.json();
      if (data.success && data.data) {
        return {
          ...data.data,
          image: getImageUrl(data.data.image)
        };
      }
      return null;
    } catch (error) {
      console.error('Error fetching event:', error);
      return null;
    }
  },

  // Create new event
  create: async (event: Omit<Event, 'id' | 'created_at'>): Promise<{ success: boolean; id?: string; error?: string }> => {
    try {
      const response = await fetch(`${API_BASE}/api_events.php?action=create`, {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify(event)
      });
      return await response.json();
    } catch (error) {
      console.error('Error creating event:', error);
      return { success: false, error: String(error) };
    }
  },

  // Update event
  update: async (id: string, updates: Partial<Event>): Promise<{ success: boolean; error?: string }> => {
    try {
      const response = await fetch(`${API_BASE}/api_events.php?action=update&id=${encodeURIComponent(id)}`, {
        method: 'PUT',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify(updates)
      });
      return await response.json();
    } catch (error) {
      console.error('Error updating event:', error);
      return { success: false, error: String(error) };
    }
  },

  // Delete event
  delete: async (id: string): Promise<{ success: boolean; error?: string }> => {
    try {
      const response = await fetch(`${API_BASE}/api_events.php?action=delete&id=${encodeURIComponent(id)}`, {
        method: 'DELETE'
      });
      return await response.json();
    } catch (error) {
      console.error('Error deleting event:', error);
      return { success: false, error: String(error) };
    }
  }
};

export type { NewsArticle, Event };
