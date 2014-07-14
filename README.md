Gigaom 404 Handling
===================

* Ticket: http://github.com/GigaOM/gigaom/issues/4854

What's going on?
----------------

We're getting some malformed requests with some extranenous junk appended to
seemingly valid URLs. So when we get a 404 we'll try to clean up the URL
by removing everything after the last '/' and see if the URL resolves to
a post. If so then we'll redirect the user to that url.


Hacking notes
-------------

Struggles & annoyances
----------------------
