# Laravel-Based Job Management Portal

## Overview

This is a job management portal built using Laravel. It provides functionalities for Admins and Users to manage job posts, track applications, and get notifications via email. The application follows the repository pattern and uses Laravel policies for authorization, email queues for notifications, and scheduled jobs for job expiry. This project is designed with a focus on backend functionality.

### Features

#### Admin Panel
- **Create, Edit, Delete Jobs:** Admins can manage job posts.
- **View Applicants:** Admins can view a list of applicants per job post.
- **Send Bulk Emails:** Admins can send custom emails to all applicants for a specific job post.
- **Update Applicant Status:** Admins can update the status of job applications (Applied, Rejected, Interview, Hired).
- **Download CVs:** Admins can download CVs uploaded by users.

#### User Panel
- **Browse Jobs:** Users can browse available job posts.
- **Apply for Jobs:** Users can apply for jobs, including uploading a CV and writing a cover letter.
- **View Applied Jobs:** Users can view their job applications and the status (Applied, Rejected, Interview, Hired).
- **Edit or Remove Applications:** Users can edit or remove their applications until the status changes.

#### Email Notification
- Users receive a confirmation email upon applying for a job.
- Admins can send bulk emails to all applicants for a specific job.

#### Job Expiry
- Jobs automatically expire after the deadline using Laravel Scheduler and Commands.

#### Search and Filter
- **Search:** Users can search jobs by title, company name, and job location.
- **Filters:** Users can filter jobs by status (e.g., applied, rejected), type (e.g., full-time, part-time, internship).

---

## Technical Requirements

- **Authentication:** Laravel Breeze is used for authentication.
- **Role-Based Access Control:** Admins and Users have different roles, managed through middleware.
- **Policies:** `JobApplicantPolicy` and `JobPostPolicy` handle authorization.
- **Queues:** Email notifications are sent using Laravel queues (email queues).
- **Repository Pattern:** Business logic is separated into repositories.
- **Laravel Notifications:** Job application confirmation emails are handled via notifications instead of raw Mail.

---

## Installation Instructions

Follow the steps below to set up the project locally:

### 1. Clone the Repository
```bash
git clone https://github.com/rabiahassann/job-management-portal.git
cd job-management-portal


## loom Video link
https://www.loom.com/share/650e4e70d9454e5ba8894d95d445516e?focus_title=1&muted=1&from_recorder=1
