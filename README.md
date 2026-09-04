# ENT News Portal

Minimalist editorial news portal featuring a complete publication workflow, multi-role access, and a clean reading interface.

Built with Laravel 13, Tailwind CSS, and SQLite for lightweight execution and zero-config deployment.

---

## Key Features

- **Guest Access:** Browse articles, search by title, and filter content by category.
- **Role-Based Auth:** Distinct access levels for **Writer** and **Super Admin**.
- **Editorial Workflow:**
  - Writers draft articles and submit them for review.
  - Admins review pending submissions: Approve, Request Revision (with review notes), or Publish.
  - Writers can view rejection/revision notes and resubmit updated drafts.
- **Rich Text Editing:** Tiptap integration for clean article formatting.
- **Media Management:** Local cover image upload pipeline with web storage link.
- **Admin Dashboard:** Minimalist overview for site stats and pending editorial reviews.

---

## Tech Stack

- **Framework:** Laravel 13 (PHP 8.2+)
- **Frontend:** Blade, Tailwind CSS, Vite
- **Database:** SQLite
- **Editor:** Tiptap

---

## Quick Setup

### 1. Clone & Install Dependencies

```bash
git clone <repository-url>
cd news

composer install
npm install