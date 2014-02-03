e-RCHRKG
=======
#KOMPAS JAKARTA

Penting
------------
* Rapihin Modules
	joborder dashboard, candidate dashboard, scorecard dipindah ke sana.
	ktemplate, reference, usermanagement, dipindah ke setting
	Calendar pake bootstrap datepicker dan fullcalendar
*Login AS -> register model, register views terkait dengan *Joborder (Berdasarkan Vertical) ?
*Joborder dan Candidate ?

Joborder
-----------
*Job Dashboard .
**Warna priority dan name, internal-mobility, expiring-three-day, external-release, waiting-approval .
**Label/Badge Diganti .
**Filter joborder ?

*Job Create / Edit / Template -
*Job Search ?

Candidate
-----------
*Candidate Dashboard -
*Candidate Search -
*Candidate Homepage -

Note:
crumb atas click ajax, per selection step ajax, hanya info saja.
widget deskripsi kiri dan kanan
tombol print, downlod, edit, delete
tabel animation dan transform
slider -> bx slider
bawah
widget + action resume googledocs
widget event-total comment
Tanya, action di candidate
kalau ngelamar banyak apa yang terjadi
Tambah Database
JoborderCandidateSources
Flow 4 awaiting-for-approval


Settings
-----------
Business Area / Vertical
	Bisnis Unit Corporate
	Departemen Corporate
	Users Internal Staff, Agency Staff, Candidate Sources
	Jobs Total: 51 Active: 21

Locations
	Address
	Users Internal Staff, Agency Staff, Candidate Sources
	Jobs Total: 51 Active: 21

CostCenter
	Verticals, nama-nama
	Locations, nama-nama
	Users

Candidate Sources
Bikin View, Bisa Agregate

Approval 1,2,3
Facebook And Linkendin -> Nama Email

Account, username dan password digenerate
aktifasi email, disuruh
nambah page password

blacklist -> internal
log login attempt


recruiter manager, dan recruiter approval
* sesama vertical
siapa yang proses duluan, unit lain ga boleh ganggu


RAPIHIN
1. Setting <- Usermanagement, Reference, Ktemplate .
2. Candidates <- Applicant, Jobapply
3. Register <- Login
4. Welcome <- Vacancy

PR Samain UI Reference, Usermanagement dan Ktemplate dengan Verticals

Layout:
Dashboard
1. MyTaskbar
2. Scorecard
3. Calender
Candidate
4. Candidate Dashboard
5. Import Candidate
6. Candidate Create
7. Candidate Search
Setting
8. Internal Staff
9. External Staff
10. Partner & Options
11. Candidate Home Pages
12. Scorecard(Internal Staff)
13. Scorecard(Candidate Sources)
14. Email Templates

FOKUS
Setting -> Nunggu Views

Mingu 1:
1. Rapihin & Samakan Joborder dengan Hiring Bos
2. Rapihin Dashboard Dulu .
3. Rapihin Register ke auth semua .
4. Rapihin Jobapply, dan applicant ke candidate
5. Rapihin vacancy ke welcome .
6. Delete authbreaker -> ga penting .
