# Calendar of meetings

Test task for "Aulink"

Main features:
- Authorization.
- Registration through invitations(SMTP).
- Сreating an event
- View information about an event.
- Deleting an event.
- Moving(drag-and- drop) events to another date.
- Changing(expanding) the date range of the event (using drag-n- drop).
- Event should have status - new, in-progress, done.

Events have:
- name
- date
- time
- description
- Author
- Status
- color scheme (colorpicker)

This system is &quot;One Page website&quot; all actions is using AJAX.
This system have two groups of users - the administrator, users. New member can register using invite link received in email. Only administrator can send invites to e-mail.

The administrator has full access to all events - he can update and/or remove any events.

Users can view the details of all events from all users. Editing and deleting are possible only for their own events.


# Installing:
1. Copy repository to your server;
2. Import sql file "aulink_bd.sql"; 
3. Write accesses to your DB in "/db/db_connect.php";
4. Write SMTP accesses to send Email-invites in "/mailer/sender.php";

Users from DB:
1. email: markbelinskiy94@gmail.com pass: Admin (Administrator, all rights);
2. email: korshun94z@gmail.com pass: Mark (Usual user);
3. email: belinskijmark@gmail.com pass: TestMar (Usual user);

Used technologies: Jquery 3, AJAX, Bootstrap 4, phpMailer, fullcalendar.js, PHP 7, MySql DB, OpenServer
