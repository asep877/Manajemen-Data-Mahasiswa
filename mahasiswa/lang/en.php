<?php
/**
 * lang/en.php : English translation
 */
return [
    // General
    'app_title'        => 'Student Data Management',
    'footer_text'      => '© %s Web Programming Course Project',
    'hello'            => 'Hello, %s',
    'logout'           => 'Logout',
    'language_label'   => 'Language',

    // Login
    'login_title'      => 'Sign In',
    'login_subtitle'   => 'Please log in to manage student data.',
    'username'         => 'Username',
    'password'         => 'Password',
    'login_button'     => 'Sign In',
    'login_required'   => 'Username and password are required.',
    'login_failed'     => 'Incorrect username or password.',
    'login_success'    => 'Login successful. Welcome, %s!',
    'logout_success'   => 'You have been logged out.',
    'login_hint'       => 'Demo account: admin / admin123',

    // Pages & buttons
    'student_list'     => 'Student List',
    'add_student'      => 'Add Student',
    'edit_student'     => 'Edit Student',
    'no'               => 'No',
    'nim'              => 'Student ID (NIM)',
    'name'             => 'Full Name',
    'email'            => 'Email',
    'major'            => 'Major',
    'phone'            => 'Phone',
    'created_at'       => 'Created At',
    'action'           => 'Actions',
    'edit'             => 'Edit',
    'delete'           => 'Delete',
    'save'             => 'Save',
    'update'           => 'Update',
    'cancel'           => 'Cancel',
    'select_major'     => '-- Select Major --',
    'no_data'          => 'No student data yet.',
    'total_data'       => 'Total: %d records',
    'confirm_delete'   => 'Are you sure you want to delete "%s"? This action cannot be undone.',

    // Field hints
    'hint_nim'         => 'Digits only, 5-20 digits.',
    'hint_name'        => 'Letters, spaces, dots, apostrophes, or hyphens (3-100 characters).',
    'hint_email'       => 'Example: name@email.com',
    'hint_phone'       => 'Digits only, 10-15 digits.',

    // Flash messages
    'msg_created'        => 'Student data was added successfully.',
    'msg_create_failed'  => 'Failed to save student data.',
    'msg_updated'        => 'Student data was updated successfully.',
    'msg_update_failed'  => 'Failed to update student data.',
    'msg_deleted'        => 'Student data was deleted successfully.',
    'msg_delete_failed'  => 'Failed to delete student data.',
    'msg_not_found'      => 'Student data not found.',
    'msg_invalid_request'=> 'Invalid request.',
    'msg_csrf_invalid'   => 'Invalid security token. Please reload the page and try again.',
    'msg_db_error'       => 'A database error occurred.',
    'form_has_errors'    => 'Please check your form inputs.',

    // Validation errors
    'err_required'       => 'This field is required.',
    'err_nim_numeric'    => 'Student ID must contain digits only.',
    'err_nim_length'     => 'Student ID must be 5 to 20 digits long.',
    'err_nim_exists'     => 'This Student ID is already registered.',
    'err_name_length'    => 'Name must be 3 to 100 characters long.',
    'err_name_format'    => 'Name may only contain letters, spaces, dots, apostrophes, and hyphens.',
    'err_email_invalid'  => 'Invalid email format.',
    'err_email_length'   => 'Email must not exceed 100 characters.',
    'err_major_invalid'  => 'The selected major is not valid.',
    'err_phone_numeric'  => 'Phone number must contain digits only.',
    'err_phone_length'   => 'Phone number must be 10 to 15 digits long.',
];
