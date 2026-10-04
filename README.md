# Ihumure — Smart Alcohol Abuse Prevention & Rehabilitation Support System

A confidential national digital health platform for public awareness, validated WHO AUDIT self-screening, and certified counsellor matching in Rwanda.

## Privacy Model & Zero-Stigma Access

People seeking help can **continue completely anonymously**. The system automatically provisions an encrypted private ID (e.g., `IH-4F8K2A`) and PIN:

- Screening history is securely stored under that ID without public profiling
- Certified counsellors are matched based on WHO risk zone, care category, and Rwandan district
- Confidential 1-on-1 messaging remains on that ID until the user chooses to share contact details
- Real names and phone numbers remain strictly optional

## How to Run

PHP 8+ with PDO SQLite (or MySQL) is supported.

```bash
php -S localhost:8080 router.php
```

Then open `http://localhost:8080`

The system automatically initializes database tables and seeds certified demo practitioner accounts. To use MySQL, set `DB_DRIVER` to `mysql` in `config/config.php` and configure host/user/credentials.

## Verified System Roles

| Role | Sign-in Credentials |
|---|---|
| Anonymous consumer | Private ID `IH-DEMO01` / PIN `2026` |
| Health System Admin | `admin@ihumure.rw` / `Admin@2026` |
| Verified Public Counsellor | `umutoni@ihumure.rw` / `Counsel@2026` |
| Registered Counsellor (Admin Verification Queue) | `niyonzima@ihumure.rw` / `Counsel@2026` |

## Core Platform Capabilities

- **Dynamic Interactive Hero Experience**: Visual transitions from addiction struggles to compassionate medical counselling and recovery.
- **WHO AUDIT 10-Question Clinical Self-Assessment**: Standardized scoring (0–40) across 4 clinical risk zones (Low, Hazardous, Harmful, Dependence).
- **Interactive Side-by-Side Showcase**: Step-by-step guidance on confidential screening, professional matching, and privacy safeguards.
- **Holistic Recovery Ecosystem**: Evidence-based pillars featuring physical sports, balanced nutrition & liver detoxification, and mindfulness.
- **Practitioner Registry & Verification**: Manual clinical credential auditing by health administrators.
- **Confidential Case Management & Telehealth**: Secure consultation requests, private chat threads, and integrated group video rooms.
- **Emergency Crisis Safeguards**: Direct links to Rwandan national emergency (112), mental health hotline (114), and gender-based violence support (3588).
