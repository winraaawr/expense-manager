<h1>Expense Manager</h1>
<h6>Submitted by: John Matthew Lubi</h6>

<span>Laravel 10 and VueJS 3 via InertiaJS</span>
<ul>
    <li>run composer install</li>
    <li>run cp .env.example .env</li>
    <li>run php artisan key:generate</li>
    <li>run php artisan migrate:fresh --seed</li>
    <li>run npm run dev</li>
    <li>run php artisan serve</li>
    <li>go to link localhost:8000 or check the APP_URL in the .env file</li>
</ul>

<h3>User Account</h3>
<p>All newly created user account's password is "password"</p>
<h4>Account Seeds</h4>
<h6>Admin Account</h6>
<span>Email: juandelacruz@email.com</span><br>
<span>Password: password</span>
<h6>Default User Account</h6>
<span>Email: mariadelacruz@email.com</span><br>
<span>Password: password</span>

<h3>Default Roles</h3>
<ul>
    <li>Administrator</li>
    <li>User</li>
</ul>

<h1>User Activities Flow</h1>
<h3>Adding User (Administrator)</h3>
<ul>
    <li>Click the users navigation in the sidebar to redirect to user management > user page.</li>
    <li>Click the add user button which can be found in the bottom right corner of the users table.</li>
    <li>Fill up the details and click the save button to add the new user.</li>
    <li>Newly created user accounts password will be automatically "password".</li>
</ul>

<h3>Updating User (Administrator)</h3>
<ul>
    <li>Click the users navigation in the sidebar to redirect to user management > user page.</li>
    <li>Click the row of the user that you wish to update.</li>
    <li>Fill up the details to update and click the update button to update the user.</li>
    <li>You could also click the delete button located at the lower left part of the modal to delete the user (Administrator users cannot be deleted).</li>
</ul>

<h3>Adding Role (Administrator)</h3>
<ul>
    <li>Click the roles navigation in the sidebar to redirect to user management > roles page.</li>
    <li>Click the add role button which can be found in the bottom right corner of the roles table.</li>
    <li>Fill up the details and click the save button to add the new role.</li>
</ul>

<h3>Updating Role (Administrator)</h3>
<ul>
    <li>Click the roles navigation in the sidebar to redirect to user management > roles page.</li>
    <li>Click the row of the role that you wish to update.</li>
    <li>Fill up the details to update and click the update button to update the role.</li>
    <li>You could also click the delete button located at the lower left part of the modal to delete the role (Administrator role cannot be deleted).</li>
</ul>

<h3>Adding Expense Category (Administrator)</h3>
<ul>
    <li>Click the expense categories navigation in the sidebar to redirect to expense management > expense categories page.</li>
    <li>Click the add category button which can be found in the bottom right corner of the expense categories table.</li>
    <li>Fill up the details and click the save button to add the new category.</li>
</ul>

<h3>Updating Expense Category (Administrator)</h3>
<ul>
    <li>Click the expense categories navigation in the sidebar to redirect to expense management > expense categories page.</li>
    <li>Click the row of the category that you wish to update.</li>
    <li>Fill up the details to update and click the update button to update the category.</li>
    <li>You could also click the delete button located at the lower left part of the modal to delete the category.</li>
</ul>

<h3>Adding Expense (All Users)</h3>
<ul>
    <li>Click the expenses navigation in the sidebar to redirect to expense management > expenses page.</li>
    <li>Click the add category button which can be found in the bottom right corner of the expenses table.</li>
    <li>Fill up the details and click the save button to add the new expense.</li>
</ul>

<h3>Updating Expense (All Users)</h3>
<ul>
    <li>Click the expenses navigation in the sidebar to redirect to expense management > expenses page.</li>
    <li>Click the row of the expense that you wish to update.</li>
    <li>Fill up the details to update and click the update button to update the expense.</li>
    <li>You could also click the delete button located at the lower left part of the modal to delete the expense.</li>
</ul>

<h3>Update Profile (All Users)</h3>
<ul>
    <li>To update profile, click the section in the sidebar where name and role is located to redirect to user profile update page.</li>
    <li>In here, the user can update its name, email, and change password.</li>
    <li>Simply click save button to save changes.</li>
</ul>





