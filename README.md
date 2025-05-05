Here are the files where changes have been made for the requested features:

createclassroom.php:
Debugging statements were added to log faculty ID, subject, unique code, and errors during classroom creation.

joinclassroom.php:
Debugging statements were added to log student ID, unique code, classroom ID, and errors during classroom joining.
Added an "Open Classroom" button for students to view classroom details.

uploadclassroommaterials.php:
Enhanced to allow faculty to upload notes and post announcements to specific classrooms.
Debugging logs were added to capture file upload errors and paths.

viewclassroommaterials.php:
Added a section to display announcements for students in classrooms they have joined.

welcomestudent.php:
Added an "Announcements" section to display announcements from any faculty for the last 24 hours.
Fixed the query for "Last 20 Days" to replace sp.RollNumber with sp.student_id.


welcomefaculty.php:
Added a "Manage Classroom Content" button to navigate to uploadclassroommaterials.php.

cc_db.sql:
Updated to include the classroom_announcements table for storing announcements.
