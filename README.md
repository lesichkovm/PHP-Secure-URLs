Secure URLs
=============

1. Introduction
----------------
The script generates secure URLs, which can be accessed only by the current user.
The URLs are attached to the user's IP address and session ID, thus cannot be used
by anyone else, even if the URL is known (i.e. sent over Skype).

2. Expiration
----------------
The generated links will be valid for the current session only. They will invalidate
once the user closes the browser. The links will also expire when the session ID is
changed i.e. when called session_regenerate_id() on user logout.

3. Demo
----------------
The code is a working demo. To test how links will be expired/changed click the
"Reset links" link. It will reset all secure URLs, making old URLs inaccessible.
