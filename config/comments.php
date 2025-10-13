<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Comment Moderation
    |--------------------------------------------------------------------------
    |
    | If true, comments must be approved before they are displayed. Set to false
    | to automatically approve all comments.
    |
    */
    'approval_required' => env('COMMENTS_APPROVAL_REQUIRED', true),

    /*
    |--------------------------------------------------------------------------
    | Comment Nesting
    |--------------------------------------------------------------------------
    |
    | Maximum depth for nested comments. Set to 0 to disable nesting.
    |
    */
    'max_nesting' => env('COMMENTS_MAX_NESTING', 5),

    /*
    |--------------------------------------------------------------------------
    | Comments per Page
    |--------------------------------------------------------------------------
    |
    | Number of comments to display per page.
    |
    */
    'per_page' => env('COMMENTS_PER_PAGE', 10),

    /*
    |--------------------------------------------------------------------------
    | Comment Editing
    |--------------------------------------------------------------------------
    |
    | Allow users to edit their own comments.
    |
    */
    'allow_editing' => env('COMMENTS_ALLOW_EDITING', true),

    /*
    |--------------------------------------------------------------------------
    | Comment Deletion
    |--------------------------------------------------------------------------
    |
    | Allow users to delete their own comments.
    |
    */
    'allow_deletion' => env('COMMENTS_ALLOW_DELETION', true),

    /*
    |--------------------------------------------------------------------------
    | Comment Voting
    |--------------------------------------------------------------------------
    |
    | Allow users to vote on comments.
    |
    */
    'allow_voting' => env('COMMENTS_ALLOW_VOTING', true),

    /*
    |--------------------------------------------------------------------------
    | Comment Reporting
    |--------------------------------------------------------------------------
    |
    | Allow users to report comments.
    |
    */
    'allow_reporting' => env('COMMENTS_ALLOW_REPORTING', true),

    /*
    |--------------------------------------------------------------------------
    | Guest Comments
    |--------------------------------------------------------------------------
    |
    | Allow unauthenticated users to post comments.
    |
    */
    'allow_guest_comments' => env('COMMENTS_ALLOW_GUEST', false),

    /*
    |--------------------------------------------------------------------------
    | Gravatar
    |--------------------------------------------------------------------------
    |
    | Use Gravatar for comment author avatars.
    |
    */
    'use_gravatar' => env('COMMENTS_USE_GRAVATAR', true),

    /*
    |--------------------------------------------------------------------------
    | Comment Moderation
    |--------------------------------------------------------------------------
    |
    | Email address to notify when a new comment is posted.
    |
    */
    'moderation_email' => env('COMMENTS_MODERATION_EMAIL', null),
];
